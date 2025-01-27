<?php

namespace App\Livewire;

use App\Models\Voter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ValidatorLivewire extends Component
{
    public $search = '';
    public $remarks = '';
    public $type = '';
    public $selectedVoter;
    public $isModalOpen = false;

    public function updateVoter(Voter $voter, string $remarks)
    {
        $this->authorize('update', $voter);

        $voter->update([
            'remarks' => $remarks,
        ]);

        return redirect()->route('system-validator-barangay-voter-list', ['navigate' => true])->with('message', $voter->fname . ' ' . $voter->lname . ' updated remarks successfully: ' . $remarks);
    }

    public function render()
    {
        return
            view(
                'livewire.validator-livewire',
                [
                    'voters' => Voter::select(
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

                        ->where('voters.municipality_id', auth()->user()->municipality_id)
                        ->where('voters.barangay_id', auth()->user()->barangay_id)
                        ->where(function ($query) {
                            $query->where('voters.fname', 'like', '%' . $this->search . '%')
                                ->orWhere('voters.lname', 'like', '%' . $this->search . '%');
                        })

                        ->when(Auth::user()->barangay_id != '', function ($query) {
                            $query->where('voters.barangay_id', '=', Auth::user()->barangay_id);
                        })

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
                        ->paginate(500)
                ]
            );
    }

    public function resetFields()
    {
        $this->search = '';
        $this->remarks = '';
        $this->type = '';
        $this->isEdit = false;
    }
}
