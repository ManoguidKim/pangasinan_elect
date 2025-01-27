<?php

namespace App\Livewire;

use App\Models\Organization;
use App\Models\Voter;
use App\Models\VoterOrganization;
use Livewire\Component;

class VoterOrganizationLivewire extends Component
{
    public $voter;
    public $voterId;
    public $voterName;

    public $organizationId;
    public $organization;

    public $organizations = [];
    public $voterOrganization = [];



    protected $rules = [
        'organization' => 'required',
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
        $this->organizations = Organization::where('municipality_id', auth()->user()->municipality_id)->get();

        $this->voterOrganizations = VoterOrganization::select(
            'organizations.name',
            'voter_organizations.voter_id',
            'voter_organizations.id',
            'voter_organizations.organization_id'
        )
            ->join('organizations', 'voter_organizations.organization_id', '=', 'organizations.id')
            ->where(
                [
                    'voter_organizations.voter_id' => $this->voterId
                ]
            )
            ->get();


        return
            view(
                'livewire.voter-organization-livewire',
                [
                    'organizations' => $this->organizations,
                    'voterOrganizations' => $this->voterOrganizations
                ]
            );
    }

    public function createVoterOrganization()
    {
        // $this->authorize('createVoterOrganization', VoterOrganizations::class);

        $this->validate();

        VoterOrganization::create(
            [
                'voter_id' => $this->voterId,
                'organization_id' => $this->organization
            ]
        );

        session()->flash('message', 'Voter Organization created successfully');

        $this->resetFields();
    }


    public function deleteVoterOrganization(VoterOrganization $voterorganization)
    {
        $this->authorize('deleteVoterOrganization', VoterOrganization::class);

        $voterorganization->delete();
        session()->flash('message', 'Voter Organization deleted successfully');

        $this->resetFields();
    }


    public function resetFields()
    {
        $this->voter = "";
        $this->organization = "";
        $this->organizationId = "";
    }
}
