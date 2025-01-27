<?php

namespace App\Http\Controllers\systemadmin;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalActiveVoter = Voter::where('status', 'Active')->count();
        $totalAllyVoter = Voter::where(['status' => 'Active', 'remarks' => 'Ally'])->count();

        $scannedSummary = Voter::selectRaw("
        COUNT(voters.id) as total_voters,
        SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) as total_scans,
        FORMAT((SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) / COUNT(voters.id)) * 100, 2) as scan_percentage
    ")
            ->leftJoin('scanlogs', 'scanlogs.voter_id', '=', 'voters.id')
            ->first();

        return view(
            'systemadmin.dashboard.index',
            [
                'totalActiveVoter' => $totalActiveVoter,
                'totalAllyVoter' => $totalAllyVoter,
                'scannedSummary' => $scannedSummary
            ]
        );
    }

    public function encoderMonitoring()
    {
        $data = Voter::selectRaw("
    DATE(voters.created_at) as date,
    municipalities.name as municipality_name,
    COUNT(*) as total_inputs
")
            ->join('municipalities', 'municipalities.id', '=', 'voters.municipality_id')
            ->groupBy('date', 'municipality_name')
            ->orderBy('date')
            ->get();

        $chartData = $data->groupBy('municipality_name')->map(function ($group, $key) {
            return [
                'name' => $key,
                'data' => $group->map(function ($item) {
                    return [
                        'x' => $item->date,
                        'y' => $item->total_inputs,
                    ];
                })->toArray(),
            ];
        })->values();

        return view('systemadmin.dashboard.monitoring.index', [
            'chartData' => $chartData->toArray(),
        ]);
    }
}
