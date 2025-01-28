<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Scanlog;
use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardLivewire extends Component
{
    public function render()
    {

        $activeVoter = Voter::where(['status' => 'Active', 'municipality_id' => auth()->user()->municipality_id])->count();
        $voterTaggedAlly = Voter::where(['status' => 'Active', 'remarks' => 'Ally', 'municipality_id' => auth()->user()->municipality_id])->count();
        $voterTaggedOpponent = Voter::where(['status' => 'Active', 'remarks' => 'Opponent', 'municipality_id' => auth()->user()->municipality_id])->count();
        $voterTaggedUndecided = Voter::where(['status' => 'Active', 'remarks' => 'Undecided', 'municipality_id' => auth()->user()->municipality_id])->count();

        // Gender
        $voterGenderBracket = Voter::selectRaw("
            SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) as male_count,
            SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) as female_count,
            SUM(CASE WHEN gender != 'female' AND gender != 'male' THEN 1 ELSE 0 END) as other_gender_count
        ")
            ->where('municipality_id', auth()->user()->municipality_id)
            ->first();

        // Age Bracket
        $voterAgeBracket = Voter::select(
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, STR_TO_DATE(dob, "%m/%d/%Y"), CURDATE()) BETWEEN 18 AND 34 THEN 1 ELSE 0 END) as young_adult'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, STR_TO_DATE(dob, "%m/%d/%Y"), CURDATE()) BETWEEN 35 AND 49 THEN 1 ELSE 0 END) as middle_age_adult'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, STR_TO_DATE(dob, "%m/%d/%Y"), CURDATE()) BETWEEN 50 AND 64 THEN 1 ELSE 0 END) as older_age'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, STR_TO_DATE(dob, "%m/%d/%Y"), CURDATE()) >= 65 THEN 1 ELSE 0 END) as senior')
        )
            ->where('municipality_id', auth()->user()->municipality_id)
            ->where('dob', '!=', '')
            ->first();

        // Faction
        $voterFactionBracket = Voter::selectRaw("
            SUM(CASE WHEN remarks = 'Ally' THEN 1 ELSE 0 END) as ally_count,
            SUM(CASE WHEN remarks = 'Opponent' THEN 1 ELSE 0 END) as opponent_count,
            SUM(CASE WHEN remarks = 'Undecided' THEN 1 ELSE 0 END) as undecided_count
        ")
            ->where('municipality_id', auth()->user()->municipality_id)
            ->where('status', 'Active')
            ->first();


        // Active Voter Per Barangay
        $voterPerBarangay = Barangay::selectRaw("
                barangays.name, 
                COALESCE(SUM(CASE WHEN voters.status = 'Active' THEN 1 ELSE 0 END), 0) as active_voter
            ")
            ->leftJoin('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->groupBy('barangays.name')
            ->orderBy('barangays.name')
            ->get();

        $barangays = $voterPerBarangay->pluck('name');
        $voterCounts = $voterPerBarangay->pluck('active_voter');





        // Count Scanned QR 
        $scannedVoter = Voter::selectRaw("
        COUNT(voters.id) as total_voters,
        SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) as total_scans,
        FORMAT((SUM(CASE WHEN scanlogs.id IS NOT NULL THEN 1 ELSE 0 END) / COUNT(voters.id)) * 100, 1) as scan_percentage
    ")
            ->leftJoin('scanlogs', 'scanlogs.voter_id', '=', 'voters.id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->first();

        return
            view(
                'livewire.dashboard-livewire',
                [
                    'activeVoter' => $activeVoter,
                    'voterTaggedAlly' => $voterTaggedAlly,
                    'voterTaggedOpponent' => $voterTaggedOpponent,
                    'voterTaggedUndecided' => $voterTaggedUndecided,
                    'voterGenderBracket' => $voterGenderBracket,
                    'voterAgeBracket' => $voterAgeBracket,
                    'voterPerBarangay' => $voterPerBarangay,
                    'voterFactionBracket' => $voterFactionBracket,

                    'barangays_datasets' => $barangays,
                    'votercounts_datasets' => $voterCounts,

                    'scannedVoter' => $scannedVoter
                ]
            );
    }
}
