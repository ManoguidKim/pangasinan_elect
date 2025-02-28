<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Designation;
use App\Models\Organization;
use App\Models\Voter;
use App\Models\VoterDesignation;
use App\Models\VoterOrganization;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VoterLivewire extends Component
{
    use WithPagination;

    public $fname;
    public $mname;
    public $lname;
    public $suffix;
    public $precinct_no;
    public $selectedBarangay;
    public $barangay;
    public $gender;
    public $dob;
    public $remarks = "Undecided";

    public $voter_id;
    public $searchBarangay;
    public $search = '';
    public $isEdit = false;


    public $currentVoterBarangayID = "";
    public $voterBarangayDetails = [];

    // Add Modal Variable
    public $addFname;
    public $addMname;
    public $addLname;
    public $addSuffix;
    public $addPrecinct;
    public $addBarangay;
    public $addGender;
    public $addDob;
    public $addRemarks;


    // Edit Modal Variable
    public $editId;
    public $editFname;
    public $editMname;
    public $editLname;
    public $editSuffix;
    public $editPrecinct;
    public $editBarangay;
    public $editGender;
    public $editDob;
    public $editRemarks;
    public $editStatus;

    public $editSelectedBarangayId;
    public $editSelectedBarangayName;

    public $isModalOpen = false;
    public $isOrganizationModalOpen = false;
    public $isDesignationModalOpen = false;

    public $barangays = [];

    // Organization
    public $organizations = [];
    public $voterorganizations = [];
    public $voterorganization_votername;
    public $selectedorganization;

    // Designation
    public $designations = [];
    public $voterdesignations = [];
    public $voterdesignation_votername;
    public $selecteddesignation;

    protected $rules = [
        'fname' => 'required',
        'mname' => 'nullable',
        'lname' => 'required',
        'suffix' => 'nullable',
        'precinct_no' => 'required',
        'barangay' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'remarks' => 'required',
    ];

    public function mount()
    {
        $this->barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
    }

    public function render()
    {
        $voters = Voter::select(
            'voters.id',
            'voters.fname',
            'voters.mname',
            'voters.lname',
            'voters.suffix',
            'barangays.name',
            'voters.precinct_no',
            'voters.gender',
            'voters.dob',
            'voters.status',
            'voters.remarks',
            'voters.image_path'
        )
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->where('voters.barangay_id', $this->searchBarangay)
            ->where('voters.status', 'Active')
            ->where(function ($query) {
                $search = strtolower($this->search);
                $query->whereRaw('LOWER(voters.lname) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(voters.fname) LIKE ?', ["%$search%"]);
            })
            ->orderBy('voters.lname')
            ->limit(100)
            ->get();


        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();

        return view(
            'livewire.voter-livewire',
            [
                'voters' => $voters,
                'barangays' => $barangays
            ]
        );
    }

    public function storeVoter()
    {
        $this->authorize('create', Voter::class);
        $this->validate();

        Voter::create([
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'suffix' => $this->suffix,
            'precinct_no' => $this->precinct_no,
            'barangay_id' => $this->barangay,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'image_path' => '',
            'remarks' => 'Undecided'
        ]);

        session()->flash('message', 'Voter created successfully');

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->fname = '';
        $this->mname = '';
        $this->lname = '';
        $this->precinct_no = '';
        $this->barangay = '';
        $this->selectedBarangay = '';
        $this->gender = '';
        $this->dob = '';

        $this->currentVoterBarangayID = "";
        $this->voterBarangayDetails = [];

        $this->isEdit = false;
        $this->voter_id = null;
    }

    public function save()
    {
        if (empty($this->editId)) {

            $validatedData = $this->validate([
                'addFname' => 'required|string|max:255',
                'addMname' => 'nullable|string|max:255',
                'addLname' => 'required|string|max:255',
                'addSuffix' => 'nullable|string|max:10',
                'addDob' => 'required|date',
                'addGender' => 'required|in:Male,Female,Other',
                'addBarangay' => 'required|exists:barangays,id',
                'addPrecinct' => 'required|string|max:50',
                'addRemarks' => 'required|string|max:500',
            ]);

            // Ensure user is authenticated before accessing properties
            if (auth()->check()) {
                Voter::create([
                    'fname' => $validatedData['addFname'],
                    'mname' => $validatedData['addMname'],
                    'lname' => $validatedData['addLname'],
                    'suffix' => $validatedData['addSuffix'],
                    'dob' => $validatedData['addDob'],
                    'gender' => $validatedData['addGender'],
                    'municipality_id' => auth()->user()->municipality_id,
                    'barangay_id' => $validatedData['addBarangay'],
                    'precinct_no' => $validatedData['addPrecinct'],
                    'remarks' => $validatedData['addRemarks'],
                    'status' => "Active",
                ]);
            } else {
                session()->flash('message', 'You must be logged in to add a voter.');
            }
        } else {

            $validatedData = $this->validate([
                'editFname' => 'required|string|max:255',
                'editMname' => 'nullable|string|max:255',
                'editLname' => 'required|string|max:255',
                'editSuffix' => 'nullable|string|max:10',
                'editDob' => 'required|date',
                'editGender' => 'required|in:Male,Female,Other',
                'editBarangay' => 'required|exists:barangays,id',
                'editPrecinct' => 'required|string|max:50',
                'editRemarks' => 'required|string|max:500',
                'editStatus' => 'required|string|max:500',
            ]);

            // dd($validatedData);

            // Ensure user is authenticated before accessing properties
            if (auth()->check()) {
                Voter::where('id', $this->editId)->update([
                    'fname' => $validatedData['editFname'],
                    'mname' => $validatedData['editMname'],
                    'lname' => $validatedData['editLname'],
                    'suffix' => $validatedData['editSuffix'],
                    'dob' => $validatedData['editDob'],
                    'gender' => $validatedData['editGender'],
                    'municipality_id' => auth()->user()->municipality_id,
                    'barangay_id' => $validatedData['editBarangay'],
                    'precinct_no' => $validatedData['editPrecinct'],
                    'remarks' => $validatedData['editRemarks'],
                    'status' => $validatedData['editStatus'],
                ]);
            } else {
                session()->flash('message', 'You must be logged in to add a voter.');
            }
        }

        session()->flash('message', 'Voter save successfully.');
        $this->closeModal();
    }


    public function delete(Voter $voter)
    {
        $voter->delete();
        session()->flash('message', 'Voter deleted successfully.');
    }


    // For Modal Functions here..
    public function closeModal()
    {
        $this->reset(
            [
                // Add
                'addFname',
                'addMname',
                'addLname',
                'addSuffix',
                'addPrecinct',
                'addBarangay',
                'addGender',
                'addDob',
                'addRemarks',

                // Edit
                'editId',
                'editFname',
                'editMname',
                'editLname',
                'editSuffix',
                'editPrecinct',
                'editBarangay',
                'editGender',
                'editDob',
                'editRemarks',
                'editStatus',

                'isModalOpen',

                // Organization
                'isOrganizationModalOpen',
                'organizations',
                'voterorganizations',
                'voterorganization_votername',
                'selectedorganization',

                // Designation
                'isDesignationModalOpen',
                'designations',
                'voterdesignations',
                'voterdesignation_votername',
                'selecteddesignation'
            ]
        );
        $this->resetValidation();
    }

    public function openEditModal(Voter $voter)
    {
        $this->editId       = $voter->id;
        $this->editFname    = $voter->fname;
        $this->editMname    = $voter->mname;
        $this->editLname    = $voter->lname;
        $this->editSuffix   = $voter->suffix;
        $this->editPrecinct = $voter->precinct_no;
        $this->editBarangay = $voter->barangay_id;
        $this->editGender   = $voter->gender;
        $this->editDob      = date('Y-m-d', strtotime($voter->dob));
        $this->editRemarks  = $voter->remarks;
        $this->editStatus   = $voter->status;

        $this->editSelectedBarangayId = $voter->barangay_id;
        $this->voterBarangayDetails = Barangay::where(
            [
                'id' => $this->editSelectedBarangayId,
                'municipality_id' => auth()->user()->municipality_id
            ]
        )->first();

        $this->isModalOpen = true;
    }

    public function openAddModal()
    {
        $this->reset(
            [
                // Add
                'addFname',
                'addMname',
                'addLname',
                'addSuffix',
                'addPrecinct',
                'addBarangay',
                'addGender',
                'addDob',
                'addRemarks'
            ]
        );
        $this->isModalOpen = true;
    }


    // For Voter Organization

    public function getOrganization()
    {
        $this->voterorganizations = [];
        $this->voterorganizations = VoterOrganization::select(
            'organizations.name',
            'voter_organizations.voter_id',
            'voter_organizations.id',
            'voter_organizations.organization_id'
        )
            ->join('organizations', 'voter_organizations.organization_id', '=', 'organizations.id')
            ->where(
                [
                    'voter_organizations.voter_id' => $this->editId
                ]
            )
            ->get();
    }

    public function openOrganizationModal(Voter $voter)
    {
        $this->editId = $voter->id;
        $this->voterorganization_votername = $voter->fname . ' ' . $voter->lname;

        $this->organizations = Organization::where('municipality_id', auth()->user()->municipality_id)->get();
        $this->getOrganization();

        $this->isOrganizationModalOpen = true;
    }

    public function createVoterOrganization()
    {
        VoterOrganization::create(
            [
                'voter_id' => $this->editId,
                'organization_id' => $this->selectedorganization
            ]
        );
        session()->flash('message', 'Voter Organization created successfully');
        $this->getOrganization();
    }

    public function deleteVoterOrganization(VoterOrganization $voterorganization)
    {
        $voterorganization->delete();
        session()->flash('message', 'Voter Organization deleted successfully');
        $this->getOrganization();
    }


    // For Voter Designation

    public function getDesignation()
    {
        $this->voterdesignations = [];
        $this->voterdesignations = VoterDesignation::select(
            'designations.name',
            'voter_designations.voter_id',
            'voter_designations.id',
            'voter_designations.designation_id'
        )
            ->join('designations', 'voter_designations.designation_id', '=', 'designations.id')
            ->where(
                [
                    'voter_designations.voter_id' => $this->editId
                ]
            )
            ->get();
    }

    public function openDesignationModal(Voter $voter)
    {
        $this->editId = $voter->id;
        $this->voterdesignation_votername = $voter->fname . ' ' . $voter->lname;

        $this->designations = Designation::where('municipality_id', auth()->user()->municipality_id)->get();
        $this->getDesignation();

        $this->isDesignationModalOpen = true;
    }

    public function createVoterDesignation()
    {
        VoterDesignation::create(
            [
                'voter_id' => $this->editId,
                'designation_id' => $this->selecteddesignation
            ]
        );
        session()->flash('message', 'Voter Designation created successfully');
        $this->getDesignation();
    }

    public function deleteVoterDesignation(VoterDesignation $voterdesignation)
    {
        $voterdesignation->delete();
        session()->flash('message', 'Voter Designation deleted successfully');
        $this->getDesignation();
    }
}
