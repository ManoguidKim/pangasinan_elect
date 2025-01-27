<?php

namespace App\Livewire;

use App\Models\Log;
use Livewire\Component;

class LogsLivewire extends Component
{
    public $search = "";

    public function render()
    {
        $logs = Log::select('activity_log.*', 'users.name', 'users.role')
            ->join('users', 'users.id', '=', 'activity_log.causer_id')
            ->where('users.municipality_id', auth()->user()->municipality_id)
            ->where(function ($query) {
                $query->where('activity_log.description', 'like', '%' . $this->search . '%')
                    ->orWhere('activity_log.subject_type', 'like', '%' . $this->search . '%');
            })
            ->orderBy('activity_log.id', 'desc')
            ->paginate(100);


        return view('livewire.logs-livewire', ['logs' => $logs]);
    }
}
