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

    protected $rules = [
        'fname' => 'required',
        'mname' => 'nullable',
        'lname' => 'required',
        'suffix' => 'nullable',
        'precinct_no' => 'required',
        'barangay' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'remarks' => 'string',
    ];

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
            ->join('municipalities', 'municipalities.id', '=', 'voters.municipality_id')
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->where('voters.barangay_id', $this->searchBarangay)
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

    public function editVoter(Voter $voter)
    {
        $voter = Voter::findOrFail($voter->id);
        $this->voter_id = $voter->id;
        $this->fname = $voter->fname;
        $this->mname = $voter->mname;
        $this->lname = $voter->lname;
        $this->precinct_no = $voter->precinct_no;
        $this->gender = $voter->gender;
        $this->dob = $voter->dob;
        $this->remarks = $voter->remarks;

        $this->currentVoterBarangayID = $voter->barangay_id;
        $this->voterBarangayDetails = Barangay::where(
            [
                'id' => $this->currentVoterBarangayID
            ]
        )->get();

        $this->isEdit = true;
    }

    public function updateVoter()
    {
        $this->validate();

        $voter = Voter::findOrFail($this->voter_id);

        $this->authorize('update', $voter);

        $voter->update([
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'precinct_no' => $this->precinct_no,
            'barangay_id' => $this->barangay,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'remarks' => $this->remarks
        ]);

        session()->flash('message', 'Voter updated successfully');

        $this->resetForm();
    }

    public function deleteVoter(Voter $voter)
    {
        $this->authorize('delete', $voter);
        $voter->delete();

        session()->flash('message', 'Voter deleted successfully');
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
}
