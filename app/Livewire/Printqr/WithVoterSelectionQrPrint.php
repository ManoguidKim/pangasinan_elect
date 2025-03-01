<?php

namespace App\Livewire\Printqr;

use App\Models\Barangay;
use App\Models\CardLayout;
use App\Models\Voter;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class WithVoterSelectionQrPrint extends Component
{
    public $voters = [];
    public $barangays = [];
    public $checkedVoters = [];
    public $selectAll = false;

    public $search;
    public $searchBarangay;

    public function mount($barangays)
    {
        $this->checkedVoters = [];
        $this->barangays = $barangays;
    }

    public $allVotersSelected = false;

    public function toggleSelectAll()
    {
        if ($this->allVotersSelected) {
            $this->checkedVoters = [];
        } else {
            $this->checkedVoters = $this->voters->pluck('id')->toArray();
        }
        $this->allVotersSelected = !$this->allVotersSelected;
    }

    public function updatedCheckedVoters()
    {
        // Remove non-numeric values
        $this->checkedVoters = array_filter($this->checkedVoters, 'is_numeric');

        // Check if all are selected
        $this->allVotersSelected = count($this->checkedVoters) === $this->voters->count();
    }

    public function printSelected()
    {

        $cardLayout = CardLayout::where('municipality_id', auth()->user()->municipality_id)
            ->first()
            ->image_path;

        $voters = Voter::whereIn('id', $this->checkedVoters)
            ->orderBy('lname')
            ->get();

        // This is not livewire is it posible?
        Session::put('voters', $voters);
        Session::put('card', $cardLayout);

        return redirect()->route('system-admin-print-selected-voters');
    }

    public function removeSelected()
    {
        $this->checkedVoters = [];
    }

    public function render()
    {
        $this->voters = Voter::select(
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
            ->limit(50)
            ->get();


        return view(
            'livewire.printqr.with-voter-selection-qr-print',
            [
                'voters' => $this->voters,
                'barangays' => $this->barangays
            ]
        );
    }
}
