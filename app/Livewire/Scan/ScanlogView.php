<?php

namespace App\Livewire\Scan;

use App\Models\Scanlog;
use Livewire\Component;

class ScanlogView extends Component
{
    public $search;

    public function render()
    {
        $scanlogs = Scanlog::select(
            'scanlogs.id',
            'voters.fname',
            'voters.mname',
            'voters.lname',
            'voters.suffix',
            'events.name as event_name',
            'barangays.name as barangay_name',
            'users.name as user_name',
            'scanlogs.created_at'
        )
            ->join('voters', 'voters.id', '=', 'scanlogs.voter_id')
            ->join('barangays', 'barangays.id', '=', 'voters.barangay_id')
            ->join('users', 'users.id', '=', 'scanlogs.user_id')
            ->join('events', 'events.id', '=', 'scanlogs.event_id')

            ->where('voters.municipality_id', auth()->user()->municipality_id)
            ->where(function ($query) {
                $query->where('voters.lname', 'like', '%' . $this->search . '%')
                    ->orWhere('voters.fname', 'like', '%' . $this->search . '%');
            })
            ->orderBy(scanlogs.created_at)
            ->limit(200)
            ->get();

        return view('livewire.scan.scanlog-view', [
            'scanlogs' => $scanlogs,
        ]);
    }

    public function deleteLog($logid)
    {
        Scanlog::where('id', $logid)->delete();
    }
}
