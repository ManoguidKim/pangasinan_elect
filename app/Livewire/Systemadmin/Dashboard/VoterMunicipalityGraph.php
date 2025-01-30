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
            ->groupBy('municipalities.id', 'municipalities.name') // Added municipalities.id to ensure proper grouping
            ->orderBy('municipalities.name')
            ->get();

        // No need to do pluck since we can directly pass data as needed
        return view(
            'livewire.systemadmin.dashboard.voter-municipality-graph',
            [
                'municipalities' => $voterPerMunicipality->pluck('name'),
                'votercounts' => $voterPerMunicipality->pluck('active_voter')
            ]
        );
    }
}
