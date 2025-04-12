<?php

namespace App\Livewire;

use App\Models\Voter;
use Livewire\Component;

class InactiveVoter extends Component
{
    public $search;
    public function render()
    {
        $voters = Voter::select(
            'voters.id',
            'voters.fname',
            'voters.mname',
            'voters.lname',
            'voters.suffix',
            'barangays.name as barangay_name',
            'voters.precinct_no',
            'voters.gender',
            'voters.dob',
            'voters.status',
            'voters.remarks',
            'voters.image_path',
        )
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->where('voters.status', 'Inactive')
            ->where(function ($query) {
                $search = strtolower($this->search);
                $query->whereRaw('LOWER(voters.lname) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(voters.fname) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(voters.remarks) LIKE ?', ["%$search%"]);
            })
            ->orderBy('voters.lname')
            ->limit(200)
            ->get();

        return view('livewire.inactive-voter', [
            'voters' => $voters
        ]);
    }

    public function setActive($voterid)
    {
        Voter::where('id', $voterid)->update(['status' => 'Active']);
    }
}
