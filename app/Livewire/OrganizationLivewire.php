<?php

namespace App\Livewire;

use App\Models\Organization;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationLivewire extends Component
{

    use WithPagination;

    public $organization;
    public $organizationId = "";
    public $search = "";
    public $isEdit = false;

    protected $rules = [
        'organization' => 'required|string',
    ];

    public function render()
    {

        $organizations = Organization::where('municipality_id', auth()->user()->municipality_id)
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.organization-livewire', ['organizations' => $organizations]);
    }

    public function createOrganization()
    {
        $this->authorize('createOrganization', Organization::class);

        $this->validate();
        Organization::create([
            'name' => $this->organization
        ]);

        session()->flash('message', 'Organization created successfully');

        $this->resetField();
    }

    public function editOrganization(Organization $organization)
    {
        $this->authorize('updateOrganization', $organization);

        $voter = Organization::findOrFail($organization->id);
        $this->organizationId = $organization->id;
        $this->organization = $organization->name;

        $this->isEdit = true;
    }

    public function updateOrganization()
    {
        $this->validate();

        $voter = Organization::findOrFail($this->organizationId);
        $voter->update([
            'name' => $this->organization
        ]);

        session()->flash('message', 'Organization updated successfully');

        $this->resetField();
    }

    public function deleteOrganization(Organization $organization)
    {
        $this->authorize('deleteOrganization', $organization);
        $organization->delete();

        session()->flash('message', 'Organization deleted successfully');
    }

    public function resetField()
    {
        $this->organization = "";
        $this->search = "";

        $this->isEdit = false;
    }
}
