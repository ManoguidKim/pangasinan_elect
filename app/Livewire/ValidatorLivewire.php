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
        return view('livewire.validator-livewire', [
            'voters' => Voter::select(
                'voters.id',
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'barangays.name as barangay_name',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path'
            )
                ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
                ->where('voters.municipality_id', auth()->user()->municipality_id)
                ->where('voters.barangay_id', auth()->user()->barangay_id)
                ->when($this->search, function ($query, $search) {
                    $search = strtolower($search);
                    $query->whereRaw('LOWER(voters.lname) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(voters.fname) LIKE ?', ["%{$search}%"]);
                })
                ->orderBy('voters.lname')
                ->get()
        ]);
    }

    public function resetFields()
    {
        $this->search = '';
        $this->remarks = '';
        $this->type = '';
        $this->isEdit = false;
    }
}
