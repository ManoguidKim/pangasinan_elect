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
}
