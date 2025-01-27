<?php

namespace App\Livewire;

use App\Models\Municipality;
use App\Models\Voter;
use Livewire\Component;

class VoterAnalytic extends Component
{
    public $search = "";

    public function render()
    {
        $voterFactions = [];
        if (auth()->user()->role == 'Admin') {
            $voterFactions = Voter::select('barangays.name')
                // Get the count of total voters and the count for each category
                ->selectRaw('COUNT(voters.id) as total_voters')
                ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
                ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
                ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

                // Join with barangays table
                ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')

                // Filter for active voters and search condition
                ->where('voters.status', 'Active')
                ->where('barangays.name', 'like', '%' . $this->search . '%')
                ->where('voters.municipality_id', auth()->user()->municipality_id)

                // Group by barangay name
                ->groupBy('barangays.name')

                // Order by barangay name
                ->orderBy('barangays.name', 'asc')
                ->get();

            $voterFactions = $voterFactions->map(function ($barangay) {
                // Total number of voters in the barangay
                $totalVoters = $barangay->total_voters;

                // Calculate the percentage for each category
                $barangay->ally_percentage = $totalVoters ? round(($barangay->ally_count / $totalVoters) * 100, 2) : 0;
                $barangay->opponent_percentage = $totalVoters ? round(($barangay->opponent_count / $totalVoters) * 100, 2) : 0;
                $barangay->undecided_percentage = $totalVoters ? round(($barangay->undecided_count / $totalVoters) * 100, 2) : 0;

                return $barangay;
            });
        } else {

            $voterFactions = Municipality::select('municipalities.name')

                // Get the count of allies, opponents, and undecided voters
                ->selectRaw('COUNT(voters.id) as total_voters')
                ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
                ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
                ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

                // Use LEFT JOIN to include municipalities even without voters
                ->leftJoin('voters', 'municipalities.id', '=', 'voters.municipality_id')

                // Filter for active voters and search condition
                ->where(function ($query) {
                    $query->where('voters.status', 'Active')
                        ->orWhereNull('voters.status'); // Include municipalities with no voters
                })
                ->where('municipalities.name', 'like', '%' . $this->search . '%')

                // Group by municipality name
                ->groupBy('municipalities.id', 'municipalities.name')

                // Order by municipality name
                ->orderBy('municipalities.name', 'asc')
                ->get();

            // Calculate percentages
            $voterFactions = $voterFactions->map(function ($municipality) {
                $totalVoters = $municipality->total_voters;

                // Calculate the percentage for each category
                $municipality->ally_percentage = $totalVoters ? round(($municipality->ally_count / $totalVoters) * 100, 2) : 0;
                $municipality->opponent_percentage = $totalVoters ? round(($municipality->opponent_count / $totalVoters) * 100, 2) : 0;
                $municipality->undecided_percentage = $totalVoters ? round(($municipality->undecided_count / $totalVoters) * 100, 2) : 0;

                return $municipality;
            });
        }

        return
            view(
                'livewire.voter-analytic',
                [
                    'voterfactions' => $voterFactions
                ]
            );
    }
}
