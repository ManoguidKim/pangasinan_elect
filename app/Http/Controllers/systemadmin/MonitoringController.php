<?php

namespace App\Http\Controllers\systemadmin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\User;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function validatorMonitoring()
    {
        $municipalities = Municipality::all();
        return view('systemadmin.dashboard.monitoring.validator.index', [
            'municipalities' => $municipalities
        ]);
    }

    public function viewValidatorMonitoring(Municipality $municipality)
    {

        // Fetch data for Validators' activity logs grouped by barangay
        $updatedPerBarangay = User::selectRaw("
        users.name AS validator_name,
        barangays.name AS barangay_name,
        COUNT(DISTINCT voters.id) AS total_voters,
        COUNT(DISTINCT activity_log.subject_id) AS total_updates
    ")
            ->join('barangays', 'barangays.id', '=', 'users.barangay_id')
            ->leftJoin('voters', 'voters.barangay_id', '=', 'barangays.id')
            ->leftJoin('activity_log', function ($join) {
                $join->on('activity_log.causer_id', '=', 'users.id')
                    ->on('activity_log.subject_id', '=', 'voters.id');
            })
            ->where('users.municipality_id', $municipality->id)
            ->where('users.role', 'Validator')
            ->groupBy('users.name', 'barangays.name')
            ->orderBy('barangays.name', 'asc')
            ->get();


        // Prepare chart data grouped by barangay
        $validators = $updatedPerBarangay->pluck('validator_name')->toArray();
        $totalVoters = $updatedPerBarangay->pluck('total_voters')->toArray();
        $totalUpdates = $updatedPerBarangay->pluck('total_updates')->toArray();

        $chartData = collect($validators)->map(function ($validator, $index) use ($totalVoters, $totalUpdates) {
            return [
                'x' => $validator,
                'y' => $totalUpdates[$index] ?? 0, // Total updates made
                'goals' => [
                    [
                        'name' => 'Expected Updates',
                        'value' => $totalVoters[$index] ?? 0, // Expected total voters
                        'strokeWidth' => 5,
                        'strokeDashArray' => 2,
                        'strokeColor' => '#775DD0',
                    ],
                ],
            ];
        })->toArray();

        // Pass the data to the view
        return view('systemadmin.dashboard.monitoring.validator.view', [
            'chartData' => $chartData
        ]);
    }
}
