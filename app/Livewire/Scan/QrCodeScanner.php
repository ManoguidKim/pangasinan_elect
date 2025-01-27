<?php

namespace App\Livewire\Scan;

use Livewire\Component;

class QrCodeScanner extends Component
{
    public $qrCodeData = null;

    public function stopScanning()
    {
        dd("HAHAHA");
    }

    public function render()
    {
        return view('livewire.scan.qr-code-scanner');
    }
}
