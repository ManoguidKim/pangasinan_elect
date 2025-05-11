<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Log;
use App\Models\Scanlog;
use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardLivewire extends Component
{
    public function render()
    {

        $activeVoter = Voter::where(['is_checked' => '1', 'status' => 'Active', 'municipality_id' => auth()->user()->municipality_id])->count();
        $voterTaggedAlly = Voter::where(['is_checked' => '1', 'status' => 'Active', 'remarks' => 'Ally', 'municipality_id' => auth()->user()->municipality_id])->count();


        // Gender
        $voterGenderBracket = Voter::selectRaw("
            SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) as male_count,
            SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) as female_count
        ")
            ->where(['municipality_id' => auth()->user()->municipality_id, 'is_checked' => '1', 'status' => 'Active'])
            ->first();


        // Faction
        $voterFactionBracket = Voter::selectRaw("
            SUM(CASE WHEN remarks = 'Ally' THEN 1 ELSE 0 END) as ally_count,
            SUM(CASE WHEN remarks = 'Opponent' THEN 1 ELSE 0 END) as opponent_count,
            SUM(CASE WHEN remarks = 'Undecided' THEN 1 ELSE 0 END) as undecided_count
        ")
            ->where('municipality_id', auth()->user()->municipality_id)
            ->where('status', 'Active')
            ->where('is_checked', '1')
            ->first();


        // Active Voter Per Barangay
        $voterPerBarangay = Barangay::selectRaw("
            count(voters.id) as total_voter,
            barangays.name, 
            SUM(CASE WHEN voters.status = 'Active' AND voters.remarks = 'Ally' THEN 1 ELSE 0 END) as ally_voter,
            SUM(CASE WHEN voters.status = 'Active' AND voters.remarks = 'Opponent' THEN 1 ELSE 0 END) as opponent_voter,
            SUM(CASE WHEN voters.status = 'Active' AND voters.remarks = 'Undecided' THEN 1 ELSE 0 END) as undecided_voter
        ")
            ->leftJoin('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->where(['is_checked' => '1', 'status' => 'Active'])
            ->groupBy('barangays.name')
            ->orderBy('barangays.name')
            ->get();

        // Collect the results directly into arrays
        $barangays = $voterPerBarangay->pluck('name')->toArray();
        $allyVoterCounts = $voterPerBarangay->pluck('ally_voter')->toArray();
        $opponentVoterCounts = $voterPerBarangay->pluck('opponent_voter')->toArray();
        $undecidedVoterCounts = $voterPerBarangay->pluck('undecided_voter')->toArray();
        $totalVoterCounts = $voterPerBarangay->pluck('total_voter')->toArray();


        // Count Scanned QR 
        $scannedVoter = Voter::selectRaw("
        COUNT(voters.id) as total_voters,
        SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) as total_scans,
        FORMAT((SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) / COUNT(voters.id)) * 100, 1) as scan_percentage
    ")
            ->leftJoin('scanlogs', 'scanlogs.voter_id', '=', 'voters.id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->whereIn('voters.remarks', ['Ally', 'Undecided'])
            ->where('voters.status', 'Active')
            ->where('voters.is_guiconsulta', 'No')
            ->first();

        $distributedQr = Voter::where(['is_checked' => '1', 'status' => 'Active', 'is_guiconsulta' => 'No', 'municipality_id' => auth()->user()->municipality_id])
            ->whereIn('remarks', ['Ally', 'Undecided'])
            ->count();

        // Update Percentage
        $updates = Voter::selectRaw("
        COUNT(voters.id) as total_voters,
        SUM(CASE WHEN activity_log.id IS NOT NULL AND activity_log.description = 'updated' THEN 1 ELSE 0 END) as total_updates,
        FORMAT((SUM(CASE WHEN activity_log.id IS NOT NULL AND activity_log.description = 'updated' THEN 1 ELSE 0 END) / COUNT(voters.id)) * 100, 5) as update_percentage
    ")
            ->leftJoin('activity_log', 'activity_log.subject_id', '=', 'voters.id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->first();

        return
            view(
                'livewire.dashboard-livewire',
                [
                    'activeVoter' => $activeVoter,
                    'voterTaggedAlly' => $voterTaggedAlly,
                    'voterGenderBracket' => $voterGenderBracket,
                    'voterPerBarangay' => $voterPerBarangay,
                    'voterFactionBracket' => $voterFactionBracket,

                    'barangays' => $barangays,
                    'allyVoterCounts' => $allyVoterCounts,
                    'opponentVoterCounts' => $opponentVoterCounts,
                    'undecidedVoterCounts' => $undecidedVoterCounts,
                    'totalVoterCounts' => $totalVoterCounts,

                    'scannedVoter' => $scannedVoter,
                    'distributedQr' => $distributedQr,
                    'updates' => $updates
                ]
            );
    }
}
