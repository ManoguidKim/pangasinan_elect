<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

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

    public $barangays = [];

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
            ->orderBy('voters.lname')

            ->orderBy('voters.lname')
            ->get()

            ->filter(function ($voter) {
                return !is_null($voter->lname) && str_contains(strtolower($voter->lname), $this->search) ||
                    !is_null($voter->fname) && str_contains(strtolower($voter->fname), $this->search);
            });

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

                'isModalOpen'
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
}
