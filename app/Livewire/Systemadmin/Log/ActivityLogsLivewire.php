<?php

namespace App\Livewire\Systemadmin\Log;

use App\Models\Municipality;
use Livewire\Component;

class ActivityLogsLivewire extends Component
{
    public $search; // Corrected the typo from 'seach' to 'search'

    public function render()
    {
        // Add `get()` to execute the query and fetch data
        $municipalities = Municipality::where('name', 'like', '%' . $this->search . '%')
            ->limit(15)
            ->get();

        return view('livewire.systemadmin.log.activity-logs-livewire', [
            'municipalities' => $municipalities
        ]);
    }
}
