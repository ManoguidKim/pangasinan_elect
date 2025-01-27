<?php

namespace App\Livewire;

use App\Models\Designation;
use Livewire\Component;

class DesignationLivewire extends Component
{
    public $designation;
    public $designationId = "";
    public $search = "";
    public $isEdit = false;

    protected $rules = [
        'designation' => 'required|string',
    ];

    public function render()
    {
        $designations = Designation::where('municipality_id', auth()->user()->municipality_id)
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.designation-livewire', ['designations' => $designations]);
    }

    public function createDesignation()
    {
        $this->authorize('createDesignation', Designation::class);

        $this->validate();
        Designation::create([
            'name' => $this->designation,
            'municipality_id' => auth()->user()->municipality_id
        ]);

        session()->flash('message', 'Designation created successfully');

        $this->resetField();
    }

    public function editDesignation(Designation $designation)
    {
        $this->authorize('updateDesignation', $designation);

        $voter = Designation::findOrFail($designation->id);
        $this->designationId = $designation->id;
        $this->designation = $designation->name;

        $this->isEdit = true;
    }

    public function updateDesignation()
    {
        $this->validate();

        $voter = Designation::findOrFail($this->designationId);
        $voter->update([
            'name' => $this->designation
        ]);

        session()->flash('message', 'Designation updated successfully');

        $this->resetField();
    }

    public function deleteDesignation(Designation $designation)
    {
        $this->authorize('deleteDesignation', $designation);
        $designation->delete();

        session()->flash('message', 'Designation deleted successfully');
    }

    public function resetField()
    {
        $this->designation = "";
        $this->search = "";

        $this->isEdit = false;
    }
}
