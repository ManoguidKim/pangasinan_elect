<?php

namespace App\Livewire\Systemadmin\Dashboard;

use App\Models\Municipality;
use App\Models\Voter;
use Livewire\Component;

class VoterFactionMunicipalityGraph extends Component
{
    public function render()
    {

        // Bar Graph voter faction per municipalities
        $voterPerMunicipality = Municipality::selectRaw("
        municipalities.name, 
        SUM(CASE WHEN voters.remarks = 'Ally' THEN 1 ELSE 0 END) as ally_counts,
        SUM(CASE WHEN voters.remarks = 'Opponent' THEN 1 ELSE 0 END) as opponent_counts,
        SUM(CASE WHEN voters.remarks = 'Undecided' THEN 1 ELSE 0 END) as undecided_counts
    ")
            ->leftJoin('voters', 'municipalities.id', '=', 'voters.municipality_id')
            ->groupBy('municipalities.name')
            ->orderBy('municipalities.name')
            ->get();

        // Prepare data for the chart
        $municipalities = $voterPerMunicipality->pluck('name')->toArray();
        $allycounts = $voterPerMunicipality->pluck('ally_counts')->toArray();
        $opponentcounts = $voterPerMunicipality->pluck('opponent_counts')->toArray();
        $undecidedcounts = $voterPerMunicipality->pluck('undecided_counts')->toArray();


        return view(
            'livewire.systemadmin.dashboard.voter-faction-municipality-graph',
            [
                'municipalities' => $municipalities,
                'allycounts' => $allycounts,
                'opponentcounts' => $opponentcounts,
                'undecidedcounts' => $undecidedcounts
            ]
        );
    }
}
