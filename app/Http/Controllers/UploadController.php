<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
}
