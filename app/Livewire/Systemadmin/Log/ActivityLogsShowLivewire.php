<?php

namespace App\Livewire\Systemadmin\Log;

use App\Models\Log;
use App\Models\Municipality;
use Livewire\Component;

class ActivityLogsShowLivewire extends Component
{

    public $search = "";
    public $municipalId = "";

    public function mount($municipalId)
    {
        if (!$municipalId) {
            abort(404, 'Municipality not found.');
        }
        $this->municipalId = $municipalId;
    }

    public function render()
    {
        $logs = Log::select('activity_log.*', 'users.name', 'users.role')
            ->join('users', 'users.id', '=', 'activity_log.causer_id')
            ->where('users.municipality_id', $this->municipalId)
            ->where(function ($query) {
                $query->where('activity_log.description', 'like', '%' . $this->search . '%')
                    ->orWhere('activity_log.subject_type', 'like', '%' . $this->search . '%');
            })
            ->orderBy('activity_log.id', 'desc')
            ->paginate(100);


        return view('livewire.systemadmin.log.activity-logs-show-livewire', ['logs' => $logs]);
    }
}
