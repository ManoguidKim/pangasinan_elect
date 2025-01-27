<?php

namespace App\Livewire\Systemadmin;

use App\Models\District;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\DistributionValidations;

class DistrictLivewire extends Component
{
    public $search;

    public function render()
    {
        // Check if $search is empty and adjust the query accordingly
        $districts = District::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->get();

        return view('livewire.systemadmin.district-livewire', [
            'districts' => $districts
        ]);
    }
}
