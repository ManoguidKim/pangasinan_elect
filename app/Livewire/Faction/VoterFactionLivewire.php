<?php

namespace App\Livewire\Faction;

use App\Models\Barangay;
use App\Models\Voter;
use Livewire\Component;

class VoterFactionLivewire extends Component
{
    public $search = "";

    public function render()
    {
        $voterTaggedAlly = Voter::where(['status' => 'Active', 'remarks' => 'Ally', 'municipality_id' => auth()->user()->municipality_id, 'is_checked' => 1])->count();
        $voterTaggedOpponent = Voter::where(['status' => 'Active', 'remarks' => 'Opponent', 'municipality_id' => auth()->user()->municipality_id, 'is_checked' => 1])->count();
        $voterTaggedUndecided = Voter::where(['status' => 'Active', 'remarks' => 'Undecided', 'municipality_id' => auth()->user()->municipality_id, 'is_checked' => 1])->count();

        $voterFactions = Barangay::select('barangays.name')
            ->selectRaw('COALESCE(SUM(voters.remarks = "ally"), 0) as ally_count')
            ->selectRaw('COALESCE(SUM(voters.remarks = "opponent"), 0) as opponent_count')
            ->selectRaw('COALESCE(SUM(voters.remarks = "undecided"), 0) as undecided_count')
            ->leftJoin('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->where('status', 'Active')
            ->where('is_checked', 1)
            ->where('barangays.name', 'like', '%' . $this->search . '%')
            ->groupBy('barangays.name')
            ->orderBy('barangays.name', 'asc')
            ->get();

        return
            view(
                'livewire.faction.voter-faction-livewire',
                [
                    'voterTaggedAlly' => $voterTaggedAlly,
                    'voterTaggedOpponent' => $voterTaggedOpponent,
                    'voterTaggedUndecided' => $voterTaggedUndecided,
                    'voterfactions' => $voterFactions
                ]
            );
    }
}
