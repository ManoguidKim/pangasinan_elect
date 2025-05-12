<?php

namespace App\Livewire\Scan;

use App\Models\Event;
use App\Models\Scanlog;
use Carbon\Carbon;
use FPDF;
use Livewire\Component;

class ScanlogsReport extends Component
{
    public $events;
    public $selectedEvent;
    public $pdfData;

    public function mount()
    {
        $this->events = Event::all();
    }

    public function render()
    {
        return view('livewire.scan.scanlogs-report');
    }

    public function printScanlogsReport()
    {
        $eventName = Event::find($this->selectedEvent)->name;


        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, $eventName, 0, 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(173, 216, 230);
        $pdf->Cell(10, 10, '#', 1, 0, 'L', true);
        $pdf->Cell(100, 10, 'Name', 1, 0, 'L', true);
        $pdf->Cell(40, 10, 'Barangay', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Date Time', 1, 1, 'C', true);

        $scanlogs = Scanlog::select(
            'scanlogs.id',
            'voters.fname',
            'voters.mname',
            'voters.lname',
            'voters.suffix',
            'events.name as event_name',
            'barangays.name as barangay_name',
            'scanlogs.created_at'
        )
            ->join('voters', 'voters.id', '=', 'scanlogs.voter_id')
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->join('events', 'events.id', '=', 'scanlogs.event_id')

            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->where('scanlogs.event_id', $this->selectedEvent)

            ->orderBy('scanlogs.id', 'desc')
            ->get();

        $ctr = 1;
        foreach ($scanlogs as $scanlog) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(10, 10, $ctr++, 1, 0, 'L');
            $pdf->Cell(100, 10, $scanlog->lname . ', ' . $scanlog->fname . ' ' . $scanlog->mname . ' ' . $scanlog->suffix, 1, 0, 'L');
            $pdf->Cell(40, 10, $scanlog->barangay_name, 1, 0, 'C');
            $pdf->Cell(40, 10, Carbon::parse($scanlog->created_at)->format('M d, Y h:i A'), 1, 1, 'C');
        }

        $pdfContent = base64_encode($pdf->Output('S')); // Output as string
        $this->dispatch('open-pdf', pdf: $pdfContent);
    }
}
