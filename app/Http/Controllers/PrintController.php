<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\CardLayout;
use App\Models\Designation;
use App\Models\Organization;
use App\Models\Voter;

use FPDF;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\GdImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view('print.index', ['barangays' => $barangays]);
    }

    public function pinoyworker()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view('print.pwindex', ['barangays' => $barangays]);
    }

    public function printSelection()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view(
            'print.printselection',
            [
                'barangays' => $barangays
            ]
        );
    }

    public function print(Request $request)
    {
        $barangay = $request->input('barangay');
        $data = Voter::query()
            ->select('voters.id', 'voters.lname', 'voters.fname', 'barangays.name as barangay_name')
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->where('voters.barangay_id', $barangay)

            ->where('voters.is_checked', 1)
            ->where('voters.status', 'Active')
            ->where('voters.is_guiconsulta', 'No')
            ->whereIn('voters.remarks', ['Ally', 'Undecided'])
            ->orderBy('voters.lname')
            ->get();

        $pdf = new FPDF('P', 'mm', [216, 330]); // Custom size for long bond paper
        $pdf->SetFont('Arial', '', 12);

        $startX = 10;
        $startY = 10;
        $cardWidth = 95;
        $cardHeight = 55;
        $cardsPerPage = 10; // 5 rows × 2 columns
        $spacingX = 5;
        $spacingY = 5;

        foreach ($data as $index => $info) {
            if ($index % $cardsPerPage === 0) {
                $pdf->AddPage();
            }

            $column = $index % 2;
            $row = floor(($index % $cardsPerPage) / 2);

            $x = $startX + $column * ($cardWidth + $spacingX);
            $y = $startY + $row * ($cardHeight + $spacingY);

            // Background template
            $backgroundPath = public_path('cardlayout.jpg');
            $pdf->Image($backgroundPath, $x, $y, $cardWidth, $cardHeight);

            // Generate QR code
            $renderer = new ImageRenderer(new RendererStyle(150), new ImagickImageBackEnd());
            $writer = new Writer($renderer);
            $qrImage = $writer->writeString($info->id);

            $qrTempPath = storage_path("app/public/qr_$index.png");
            file_put_contents($qrTempPath, $qrImage);

            $image = imagecreatefrompng($qrTempPath);
            if ($image) {
                $rgbPath = storage_path("app/public/qr_rgb_$index.png");
                imagepng($image, $rgbPath);
                imagedestroy($image);
            } else {
                throw new \Exception("Failed to convert QR image for FPDF");
            }

            // Insert QR Code
            $pdf->Image($rgbPath, $x + 2, $y + 2, 40, 40);

            // Insert Name
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetXY($x + 50, $y + 20);
            $pdf->Cell(55, 5, $info->lname . ',', 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY($x + 50, $y + 25);
            $pdf->Cell(55, 5, $info->fname, 0, 1, 'L');

            // Barangay
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetXY($x + 50, $y + 30);
            $pdf->Cell(55, 5, $info->barangay_name, 0, 1, 'L');
        }

        // Cleanup QR temp files
        for ($i = 0; $i < count($data); $i++) {
            @unlink(storage_path("app/public/qr_$i.png"));
            @unlink(storage_path("app/public/qr_rgb_$i.png"));
        }

        // Return PDF response
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="generated_ids_long.pdf"');
    }

    public function printSelected()
    {
        $data = Session::get('voters');

        $pdf = new FPDF('P', 'mm', [216, 330]); // Custom size for long bond paper
        $pdf->SetFont('Arial', '', 12);

        $startX = 10;
        $startY = 10;
        $cardWidth = 95;
        $cardHeight = 55;
        $cardsPerPage = 10; // 5 rows × 2 columns
        $spacingX = 5;
        $spacingY = 5;

        foreach ($data as $index => $info) {
            if ($index % $cardsPerPage === 0) {
                $pdf->AddPage();
            }

            $column = $index % 2;
            $row = floor(($index % $cardsPerPage) / 2);

            $x = $startX + $column * ($cardWidth + $spacingX);
            $y = $startY + $row * ($cardHeight + $spacingY);

            // Background template
            $backgroundPath = public_path('cardlayout.jpg');
            $pdf->Image($backgroundPath, $x, $y, $cardWidth, $cardHeight);

            // Generate QR code
            $renderer = new ImageRenderer(new RendererStyle(150), new ImagickImageBackEnd());
            $writer = new Writer($renderer);
            $qrImage = $writer->writeString($info->id);

            $qrTempPath = storage_path("app/public/qr_$index.png");
            file_put_contents($qrTempPath, $qrImage);

            $image = imagecreatefrompng($qrTempPath);
            if ($image) {
                $rgbPath = storage_path("app/public/qr_rgb_$index.png");
                imagepng($image, $rgbPath);
                imagedestroy($image);
            } else {
                throw new \Exception("Failed to convert QR image for FPDF");
            }

            // Insert QR Code
            $pdf->Image($rgbPath, $x + 2, $y + 2, 40, 40);

            // Insert Name
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetXY($x + 50, $y + 20);
            $pdf->Cell(55, 5, $info->lname . ',', 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY($x + 50, $y + 25);
            $pdf->Cell(55, 5, $info->fname, 0, 1, 'L');

            // Barangay
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetXY($x + 50, $y + 30);
            $pdf->Cell(55, 5, $info->barangay_name, 0, 1, 'L');
        }

        // Cleanup QR temp files
        for ($i = 0; $i < count($data); $i++) {
            @unlink(storage_path("app/public/qr_$i.png"));
            @unlink(storage_path("app/public/qr_rgb_$i.png"));
        }

        // Return PDF response
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="generated_ids_long.pdf"');
    }

    public function generateIDs()
    {
        $data = Voter::where('barangay_id', 17)->limit(20)->get();

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetFont('Arial', '', 12);

        $startX = 10;
        $startY = 10;
        $cardWidth = 90;
        $cardHeight = 55;
        $cardsPerPage = 8;

        $positions = []; // To store layout positions

        // -------- FRONT SIDE --------
        foreach ($data as $index => $info) {

            if ($index % $cardsPerPage == 0) {
                $pdf->AddPage();
            }

            $x = $startX + ($index % 2) * ($cardWidth + 5);
            $y = $startY + floor(($index % $cardsPerPage) / 2) * ($cardHeight + 5);

            // Save position for back layout later
            $positions[$index] = ['x' => $x, 'y' => $y];

            // Insert background template
            $backgroundPath = public_path('cardlayout.jpg');
            $pdf->Image($backgroundPath, $x, $y, $cardWidth, $cardHeight);

            // Generate QR code
            $renderer = new ImageRenderer(new RendererStyle(150), new ImagickImageBackEnd());
            $writer = new Writer($renderer);
            $qrImage = $writer->writeString($info->id);

            $qrTempPath = storage_path("app/public/qr_$index.png");
            file_put_contents($qrTempPath, $qrImage);

            $image = imagecreatefrompng($qrTempPath);
            if ($image) {
                $rgbPath = storage_path("app/public/qr_rgb_$index.png");
                imagepng($image, $rgbPath);
                imagedestroy($image);
            } else {
                throw new \Exception("Failed to convert QR image for FPDF");
            }

            // Insert QR Code
            $pdf->Image($rgbPath, $x + 2, $y + 1, 40, 40);

            // Insert Name
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetXY($x + 45, $y + 20);
            $pdf->MultiCell(55, 5, $info->lname . ',', 0, 'L');

            // Insert Name
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetXY($x + 45, $y + 25);
            $pdf->MultiCell(55, 5, $info->fname, 0, 'L');

            // Insert Barangay
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY($x + 45, $y + 30);
            $pdf->Cell(55, 5, 'Barangay', 0, 'L');
        }

        // -------- BACK SIDE --------
        foreach ($data as $index => $info) {

            if ($index % $cardsPerPage == 0) {
                $pdf->AddPage();
            }

            $x = $positions[$index]['x'];
            $y = $positions[$index]['y'];

            // Insert back layout
            $backLayoutPath = public_path('back_qr.jpg');
            $pdf->Image($backLayoutPath, $x, $y, $cardWidth, $cardHeight);

            // (Optional) Add back content like address, contact, etc.
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY($x + 10, $y + 40);
            $pdf->Cell(70, 5, 'This is the back side of the card.', 0, 'C');
        }

        // -------- Clean up temp QR images --------
        for ($i = 0; $i < count($data); $i++) {
            @unlink(storage_path("app/public/qr_$i.png"));
            @unlink(storage_path("app/public/qr_rgb_$i.png"));
        }

        // -------- Return the PDF --------
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="generated_ids.pdf"');
    }






    public function printQrcodeForPinotWorker(Request $request)
    {
        $barangay = $request->input('barangay');
        // $data = Session::get('voters');
        $data = Voter::query()
            ->select('voters.id', 'voters.fname', 'voters.mname', 'voters.lname', 'barangays.name as barangay_name')
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->where('barangays.id', $barangay)
            ->whereIn('voters.remarks', ['Undecided', 'Ally'])
            ->where('voters.status', 'Active')
            ->where('voters.is_checked', 1)
            ->get();

        $pdf = new FPDF('P', 'mm', [216, 330]); // Long bond paper size
        $pdf->SetFont('Arial', '', 12);

        $startX = 10;
        $startY = 10;
        $cardWidth = 95;
        $cardHeight = 55;
        $cardsPerPage = 10; // 5 rows × 2 columns
        $spacingX = 5;
        $spacingY = 5;

        foreach ($data as $index => $info) {
            if ($index % $cardsPerPage === 0) {
                $pdf->AddPage();
            }

            $column = $index % 2;
            $row = floor(($index % $cardsPerPage) / 2);

            $x = $startX + $column * ($cardWidth + $spacingX);
            $y = $startY + $row * ($cardHeight + $spacingY);

            $pdf->SetDrawColor(0, 0, 0); // black border
            $pdf->SetFillColor(255, 255, 255); // white background
            $pdf->Rect($x, $y, $cardWidth, $cardHeight, 'DF'); // D = draw border, F = fill

            // Logo (use your own image path)
            $logoPath = public_path('pw_logo.jpg');
            $pdf->Image($logoPath, $x + 2, $y + 2, 35); // adjust size and position as needed

            // Generate QR Code
            $renderer = new ImageRenderer(new RendererStyle(150), new ImagickImageBackEnd());
            $writer = new Writer($renderer);
            $qrImage = $writer->writeString($info->id);

            $qrTempPath = storage_path("app/public/qr_$index.png");
            file_put_contents($qrTempPath, $qrImage);

            $image = imagecreatefrompng($qrTempPath);
            if ($image) {
                $rgbPath = storage_path("app/public/qr_rgb_$index.png");
                imagepng($image, $rgbPath);
                imagedestroy($image);
            } else {
                throw new \Exception("Failed to convert QR image for FPDF");
            }

            // QR Code placement (top right)
            $pdf->Image($rgbPath, $x + $cardWidth - 32, $y + 2, 30); // QR code ~20mm

            // Full Name
            $fullName = strtoupper($info->lname . ', ' . $info->fname . ' ' . $info->mname);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY($x + 2, $y + 38);
            $pdf->Cell($cardWidth - 4, 5, $fullName, 0, 1, 'L');

            // ID Number
            // $pdf->SetFont('Arial', '', 9);
            // $pdf->SetX($x + 2);
            // $pdf->Cell($cardWidth - 4, 5, $info->id, 0, 1, 'L');

            // Location
            // $location = strtoupper("{$info->province} - {$info->municipality} - {$info->barangay_name}");
            $pdf->SetX($x + 2);
            $pdf->Cell($cardWidth - 4, 5, "PANGASINAN - BAYAMBANG - " . strtoupper($info->barangay_name), 0, 1, 'L');
        }

        // Cleanup QR temp files
        for ($i = 0; $i < count($data); $i++) {
            @unlink(storage_path("app/public/qr_$i.png"));
            @unlink(storage_path("app/public/qr_rgb_$i.png"));
        }

        // Return PDF response
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="generated_ids_long.pdf"');
    }
}
