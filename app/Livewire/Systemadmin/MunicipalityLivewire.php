<?php

namespace App\Livewire\Systemadmin;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Livewire\Component;

class MunicipalityLivewire extends Component
{
    public $search;

    public function render()
    {
        $municipality = Municipality::select('municipalities.id', 'municipalities.name', 'districts.name as district_name')
            ->join('districts', 'districts.id', '=', 'municipalities.district_id')
            ->when($this->search, function ($query) {
                return $query->where('municipalities.name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.systemadmin.municipality-livewire', [
            'municipalities' => $municipality
        ]);
    }
}
