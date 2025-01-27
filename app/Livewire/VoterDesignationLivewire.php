<?php

namespace App\Livewire;

use App\Models\Designation;
use App\Models\Voter;
use App\Models\VoterDesignation;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class VoterDesignationLivewire extends Component
{
    use WithoutUrlPagination;

    public $voter;
    public $voterId;
    public $voterName;

    public $designationId;
    public $designation;

    public $designations = [];
    public $voterDesignation = [];

    public $isEdit = false;



    protected $rules = [
        'designation' => 'required',
    ];


    public function mount(Voter $voter)
    {
        $voter = Voter::where(
            'id',
            $voter->id
        )->first();

        $this->voterId = $voter->id;
        $this->voterName = $voter->fname . ' ' . $voter->lname;
    }

    public function render()
    {
        $this->designations = Designation::where('municipality_id', auth()->user()->municipality_id)->get();;

        $this->voterDesignations = VoterDesignation::select(
            'designations.name',
            'voter_designations.voter_id',
            'voter_designations.id',
            'voter_designations.designation_id'
        )
            ->join('designations', 'voter_designations.designation_id', '=', 'designations.id')
            ->where(
                [
                    'voter_designations.voter_id' => $this->voterId
                ]
            )
            ->get();


        return
            view(
                'livewire.voter-designation-livewire',
                [
                    'designations' => $this->designations,
                    'voterDesignations' => $this->voterDesignations
                ]
            );
    }

    public function createVoterDesignation()
    {
        $this->authorize('createVoterDesignation', VoterDesignation::class);

        $this->validate();

        VoterDesignation::create(
            [
                'voter_id' => $this->voterId,
                'designation_id' => $this->designation
            ]
        );

        // session()->flash('message', 'Voter Designation created successfully');

        $this->resetFields();

        return redirect()->route('system-admin-voters')->with('message', 'Voter Designation created successfully');
    }


    public function deleteVoterDesignation(VoterDesignation $voterdesignation)
    {
        $voterdesignation->delete();
        session()->flash('message', 'Voter Designation deleted successfully');

        $this->resetFields();
    }


    public function resetFields()
    {
        $this->voter = "";
        $this->designation = "";
        $this->designationId = "";

        $this->isEdit = false;
    }
}
