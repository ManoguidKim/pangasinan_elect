<?php

namespace App\Livewire\Guiconsulta;

use App\Models\Barangay;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProfiledAndNotPerBarangay extends Component
{
    public $search;

    public function render()
    {
        $voters = Barangay::select(
            'barangays.name as barangay_name',
            DB::raw("SUM(CASE WHEN is_guiconsulta IS NULL OR is_guiconsulta = '' THEN 1 ELSE 0 END) as total_yes"),
            DB::raw("SUM(CASE WHEN is_guiconsulta = 'No' THEN 1 ELSE 0 END) as total_no")
        )
            ->join('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')
            ->where('voters.status', 'Active')
            ->whereIn('voters.remarks', ['Ally', 'Undecided'])
            ->where('municipalities.id', auth()->user()->municipality_id)
            ->when($this->search, function ($query) {
                $query->where('barangays.name', 'like', '%' . $this->search . '%');
            })
            ->groupBy('barangays.name')
            ->orderBy('barangays.name')
            ->get();


        return view('livewire.guiconsulta.profiled-and-not-per-barangay', ['voters' => $voters]);
    }
}
