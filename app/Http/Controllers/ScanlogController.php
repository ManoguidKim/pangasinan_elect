<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class ScanlogController extends Controller
{
    public function index()
    {
        return view('scanlog.index');
    }

    public function scannedPerBarangay()
    {
        $scannedPerBarangay = Barangay::selectRaw("
            barangays.name,
            COUNT(voters.id) as total_voters,
            SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) as total_scans
        ")
            ->leftJoin('voters', 'voters.barangay_id', '=', 'barangays.id')
            ->leftJoin('scanlogs', 'scanlogs.voter_id', '=', 'voters.id')

            ->where('voters.status', 'Active')
            ->where('voters.is_guiconsulta', 'No')
            ->whereIn('voters.remarks', ['Ally', 'Undecided'])
            ->where('barangays.municipality_id', auth()->user()->municipality_id)

            ->groupBy('barangays.name')
            ->orderBy('barangays.name')
            ->get();

        // Extract data for the view
        $barangays = $scannedPerBarangay->pluck('name')->toArray();
        $totalVoters = $scannedPerBarangay->pluck('total_voters')->toArray();
        $totalScans = $scannedPerBarangay->pluck('total_scans')->toArray();

        // Prepare chart data with actual and expected values
        $chartData = collect($barangays)->map(function ($barangay, $index) use ($totalVoters, $totalScans) {
            return [
                'x' => $barangay,
                'y' => $totalScans[$index],
                'goals' => [
                    [
                        'name' => 'Expected',
                        'value' => $totalVoters[$index],
                        'strokeWidth' => 5,
                        'strokeDashArray' => 2,
                        'strokeColor' => '#775DD0',
                    ]
                ]
            ];
        })->toArray();

        return view('scanlog.scangraph', [
            'chartData' => $chartData
        ]);
    }
}
