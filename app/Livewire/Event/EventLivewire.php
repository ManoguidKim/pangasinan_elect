<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Component;

class EventLivewire extends Component
{
    public $isModalOpen = false;
    public $editId;

    public $eventName;

    public function render()
    {
        $events = Event::query()->get();
        return view('livewire.event.event-livewire', ['events' => $events]);
    }

    public function save()
    {
        if (!$this->editId) {
            $this->validate([
                'eventName' => 'required|max:255',
            ]);

            Event::create([
                'name' => $this->eventName
            ]);
        } else {
            $this->validate([
                'eventName' => 'required|max:255',
            ]);

            Event::where('id', $this->editId)->update([
                'name' => $this->eventName
            ]);
        }

        $this->closeModal();
        $this->reset();
    }

    public function editEvent($id)
    {
        $eventDetails = Event::where('id', $id)->first();
        $this->eventName = $eventDetails->name;
        $this->editId = $eventDetails->id;

        $this->isModalOpen = true;
    }

    public function deleteEvent($id)
    {
        Event::where('id', $id)->delete();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetValidation();
        $this->resetData();
    }

    public function resetData()
    {
        $this->reset([
            'isModalOpen',
            'editId',
            'eventName'
        ]);
    }
}
