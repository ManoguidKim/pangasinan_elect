<?php

namespace App\Livewire\Upload;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadCardLayout extends Component
{
    use WithFileUploads;

    public $photo;
    public $photoPreview;

    public function uploadCardFile()
    {
        $this->validate([
            'photo' => 'required|image|max:1024',
        ]);

        $filePath = $this->photo->store('uploads', 'public');
        session()->flash('message', 'Photo uploaded successfully: ' . $filePath);
    }

    public function updatedPhoto()
    {
        $this->photoPreview = $this->photo->temporaryUrl();
    }

    public function render()
    {
        return view('livewire.upload.upload-card-layout');
    }
}
