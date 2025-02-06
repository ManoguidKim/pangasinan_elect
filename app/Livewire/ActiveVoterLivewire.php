<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActiveVoterLivewire extends Component
{
    public $barangay = "";
    public $search = "";
    public $voter_id = "";

    public function render()
    {
        $voters = Voter::select(
            'voters.id',
            'voters.fname',
            'voters.mname',
            'voters.lname',
            'barangays.name',
            'voters.precinct_no',
            'voters.gender',
            'voters.dob',
            'voters.status',
            'voters.remarks',
            'voters.image_path',
            DB::raw('GROUP_CONCAT(DISTINCT organizations.name SEPARATOR ", ") as voter_organizations'),
            DB::raw('GROUP_CONCAT(DISTINCT designations.name SEPARATOR ", ") as voter_designations')
        )
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->leftJoin('voter_organizations', 'voter_organizations.voter_id', '=', 'voters.id')
            ->leftJoin('organizations', 'organizations.id', '=', 'voter_organizations.organization_id')
            ->leftJoin('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
            ->leftJoin('designations', 'designations.id', '=', 'voter_designations.designation_id')

            ->where('barangays.id', $this->barangay)

            ->groupBy(
                'voters.id',
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'barangays.name',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path',
            )

            ->get()
            ->filter(function ($voter) {
                return !is_null($voter->lname) && str_contains(strtolower($voter->lname), $this->search) ||
                    !is_null($voter->fname) && str_contains(strtolower($voter->fname), $this->search);
            });

        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();

        return
            view(
                'livewire.active-voter-livewire',
                [
                    'voters' => $voters,
                    'barangays' => $barangays
                ]
            );
    }
}
