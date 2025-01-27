<?php

namespace App\Livewire\Printqr;

use Livewire\Component;

class PrintQrLivewire extends Component
{
    public $barangay;
    public $reportType;

    public function render()
    {
        return view('livewire.printqr.print-qr-livewire');
    }
}
