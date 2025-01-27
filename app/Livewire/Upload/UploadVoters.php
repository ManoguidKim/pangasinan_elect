<?php

namespace App\Livewire\Upload;

use App\Models\Voter;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadVoters extends Component
{
    use WithFileUploads;

    public $excelFile;
    public $fileCount = 0;

    public function uploadVoters()
    {
        $this->validate([
            'excelFile' => 'required|mimes:csv,xls,xlsx|max:102400',
        ]);

        // Load the Excel file
        $spreadsheet = IOFactory::load($this->excelFile->getRealPath());
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process the data as needed
        dd($data);
        // foreach ($data as $row) {
        //     echo $row['A'] . " " . $row['B'];
        // }

        session()->flash('message', 'Excel file uploaded successfully.');
    }

    public function render()
    {
        return view('livewire.upload.upload-voters');
    }
}
