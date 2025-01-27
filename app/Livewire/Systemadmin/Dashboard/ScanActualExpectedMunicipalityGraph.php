<?php

namespace App\Livewire\Systemadmin\Dashboard;

use App\Models\Municipality;
use App\Models\Voter;
use Livewire\Component;

class ScanActualExpectedMunicipalityGraph extends Component
{
    public function render()
    {
        $scannedPerMunicipality = Municipality::selectRaw("
            municipalities.name,
            COUNT(voters.id) as total_voters,
            SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) as total_scans
        ")
            ->leftJoin('voters', 'voters.municipality_id', '=', 'municipalities.id')
            ->leftJoin('scanlogs', 'scanlogs.voter_id', '=', 'voters.id')
            ->groupBy('municipalities.name')
            ->orderBy('municipalities.name')
            ->get();

        // Extract data for the view
        $municipalities = $scannedPerMunicipality->pluck('name')->toArray();
        $totalVoters = $scannedPerMunicipality->pluck('total_voters')->toArray();
        $totalScans = $scannedPerMunicipality->pluck('total_scans')->toArray();

        // Prepare chart data with actual and expected values
        $chartData = collect($municipalities)->map(function ($municipality, $index) use ($totalVoters, $totalScans) {
            return [
                'x' => $municipality,
                'y' => $totalScans[$index], // Actual count (scans)
                'goals' => [
                    [
                        'name' => 'Expected',
                        'value' => $totalVoters[$index], // Expected count (total voters)
                        'strokeWidth' => 5,
                        'strokeDashArray' => 2,
                        'strokeColor' => '#775DD0',
                    ]
                ]
            ];
        })->toArray();

        return view(
            'livewire.systemadmin.dashboard.scan-actual-expected-municipality-graph',
            ['chartData' => $chartData]
        );
    }
}
