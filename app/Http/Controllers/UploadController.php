<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use League\Csv\Reader;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('upload.index');
    }

    public function upload(FileUploadRequest $request)
    {
        ini_set('memory_limit', '512M'); // Adjust as needed
        ini_set('max_execution_time', '300'); // 300 seconds

        // Load the Excel file
        $spreadsheet = IOFactory::load($request->excelFile);
        // Get the first sheet
        $sheet = $spreadsheet->getActiveSheet();

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

            $barangayId = $rowData[0][0];
            $firstname = $rowData[0][1];
            $middlename = $rowData[0][2];
            $lastname = $rowData[0][3];
            $suffix = $rowData[0][4];
            $precinctNo = $rowData[0][5];
            $sex = $rowData[0][6];
            $dob = $rowData[0][7];

            if (is_numeric($dob)) {
                $dob = Date::excelToDateTimeObject($dob);
            }

            if ($sex == 'M' || $sex == 'm') {
                $sex = "Male";
            } else {
                if ($sex == 'F' || $sex == 'f') {
                    $sex = "Female";
                }
            }

            Voter::create([
                'municipality_id' => auth()->user()->municipality_id,
                'barangay_id' => $barangayId,
                'fname' => $firstname,
                'mname' => $middlename,
                'lname' => $lastname,
                'suffix' => $suffix,
                'precinct_no' => $precinctNo,
                'gender' => $sex,
                'dob' => $dob->format('Y-m-d'),
                'status' => "Active",
                'remarks' => "Undecided",
                'image_path' => "",
            ]);
        }

        return redirect()->route('system-admin-upload-voters')->with('message', 'File Uploaded Successfully');
    }

    public function importCsv()
    {
        set_time_limit(600);  // Allow the script to run for up to 10 minutes

        $path = storage_path('app/public/voter.csv');

        // Check if the file exists
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Read the CSV file
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // Set the header offset for CSV parsing

        // Begin database transaction
        DB::beginTransaction();

        try {
            foreach ($csv as $row) {
                // Ensure all required keys exist
                if (!isset(
                    $row['firstname'],
                    $row['middlename'],
                    $row['lastname'],
                    $row['barangay'],
                    $row['precinct'],
                    $row['gender'],
                )) {
                    continue; // Skip the row if any required column is missing
                }

                // Find the barangay by name
                $barangay = Barangay::where('name', $row['barangay'])->first();

                // If no barangay is found, set it to null or handle the error
                $barangayId = $barangay ? $barangay->id : null;


                $remarks = $row['side'];
                if ($remarks == "UndToAlly" || $remarks == "OppoToAlly") {
                    $remarks = "Ally";
                }

                // Create a new Voter record
                Voter::create([
                    'fname' => $row['firstname'],
                    'mname' => $row['middlename'],
                    'lname' => $row['lastname'],
                    'suffix' => $row['suffix'],
                    'barangay_id' => $barangayId,  // Handle missing barangay gracefully
                    'precinct_no' => $row['precinct'],
                    'gender' => $row['gender'],
                    'dob' => $row['dateofbirth'],
                    'status' => 'Active',
                    'remarks' => $remarks,
                    'image_path' => '',
                ]);
            }

            // Commit transaction if everything is successful
            DB::commit();

            return response()->json(['success' => 'CSV data imported successfully']);
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();

            return response()->json(['error' => 'Failed to import CSV data', 'message' => $e->getMessage()], 500);
        }
    }


    public function uploadOtherFile(Request $request)
    {
        ini_set('memory_limit', '1024M'); // Increased memory limit
        ini_set('max_execution_time', '100000000'); // Increased max execution time

        // Load the Excel file
        $spreadsheet = IOFactory::load($request->excelFile);
        // Get the first sheet
        $sheet = $spreadsheet->getActiveSheet();

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Array to hold the records to be inserted
            $votersData = [];

            for ($row = 2; $row <= $highestRow; $row++) {
                // Get row data
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

                // Extract required values
                $firstname = $rowData[0][5];
                $lastname = $rowData[0][4];
                $precinctNo = $rowData[0][2];
                $barangayData = Barangay::where(['name' => strtoupper($rowData[0][3]), 'municipality_id' => auth()->user()->municipality_id])->first();
                $remarks = $rowData[0][7];

                // Ensure 'remarks' has a default value if 'sex' is empty
                if ($remarks == 'Ally' || $rowData[0][8] == '') {
                    $remarks = "Ally";
                }

                // Prepare the data for batch insert
                $votersData[] = [
                    'municipality_id' => auth()->user()->municipality_id,
                    'barangay_id' => $barangayData->id,
                    'fname' => $firstname,
                    'mname' => "",
                    'lname' => $lastname,
                    'suffix' => "",
                    'precinct_no' => $precinctNo,
                    'gender' => "",
                    'dob' => "",
                    'status' => "Active",
                    'remarks' => $remarks,
                    'image_path' => ""
                ];

                // Insert in batches of 500 (or any other number that suits your environment)
                if (count($votersData) >= 500) {
                    Voter::insert($votersData);
                    $votersData = []; // Clear the array after batch insert
                }
            }

            // Insert remaining records (in case the last batch is less than 500)
            if (!empty($votersData)) {
                Voter::insert($votersData);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('system-admin-upload-voters')->with('message', 'File Uploaded Successfully');
        } catch (\Exception $e) {
            // Rollback transaction in case of an error
            DB::rollBack();
            return redirect()->route('system-admin-upload-voters')->with('message', 'Error occurred: ' . $e->getMessage());
        }
    }


    public function importMalasiquiCsv()
    {
        set_time_limit(600);  // Allow the script to run for up to 10 minutes

        $path = storage_path('app/public/votermalasiqui.csv');

        // Check if the file exists
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Read the CSV file
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // Set the header offset for CSV parsing

        // Begin database transaction
        DB::beginTransaction();

        try {
            foreach ($csv as $row) {
                // Ensure all required keys exist
                if (!isset(
                    $row['precinct'],
                    $row['barangay'],
                    $row['lastname'],
                    $row['remainingname'],
                    $row['side'],
                )) {
                    continue; // Skip the row if any required column is missing
                }

                $remarks = $row['side'];
                if ($remarks == "") {
                    $remarks = "Undecided";
                }


                $barangayName = strtoupper(trim($row['barangay']));

                // Query to get the barangay ID
                $barangay = Barangay::whereRaw('UPPER(TRIM(name)) = ? AND municipality_id = ?', [$barangayName, auth()->user()->municipality_id])->first();

                // Check if a barangay is found
                if (!$barangay) {
                    // Skip this iteration if the barangay is not found
                    continue;
                }

                $barangay_id = $barangay->id; // Get the ID from the result

                // Create a new Voter record
                Voter::create([
                    'municipality_id' => auth()->user()->municipality_id,
                    'barangay_id' => $barangay_id,
                    'fname' => $row['remainingname'],
                    'mname' => "", // You can adjust this if needed
                    'lname' => $row['lastname'],
                    'suffix' => "", // You can adjust this if needed
                    'precinct_no' => $row['precinct'],
                    'gender' => "", // You can adjust this if needed
                    'dob' => "", // You can adjust this if needed
                    'status' => "Active",
                    'remarks' => $remarks,
                    'image_path' => "" // You can adjust this if needed
                ]);
            }

            // Commit transaction if everything is successful
            DB::commit();

            return response()->json(['success' => 'CSV data imported successfully']);
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();

            return response()->json(['error' => 'Failed to import CSV data', 'message' => $e->getMessage()], 500);
        }
    }
}
