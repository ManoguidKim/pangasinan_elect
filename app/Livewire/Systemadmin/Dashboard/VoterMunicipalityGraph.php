<?php

namespace App\Livewire\Systemadmin\Dashboard;

use App\Models\Municipality;
use App\Models\Voter;
use Livewire\Component;

class VoterMunicipalityGraph extends Component
{
    public function render()
    {
        $voterPerMunicipality = Municipality::selectRaw("
                municipalities.name, 
                COALESCE(SUM(CASE WHEN voters.status = 'Active' THEN 1 ELSE 0 END), 0) as active_voter
            ")
            ->leftJoin('voters', 'municipalities.id', '=', 'voters.municipality_id')
            ->groupBy('municipalities.name')
            ->orderBy('municipalities.name')
            ->get();

        $municipalities = $voterPerMunicipality->pluck('name');
        $voterCounts = $voterPerMunicipality->pluck('active_voter');

        return view(
            'livewire.systemadmin.dashboard.voter-municipality-graph',
            [
                'municipalities' => $municipalities,
                'votercounts' => $voterCounts
            ]
        );
    }
}
