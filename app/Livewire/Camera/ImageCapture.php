<?php

namespace App\Livewire\Camera;

use App\Models\Voter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ImageCapture extends Component
{
    use WithFileUploads;

    public $image;
    public $imagePreview;
    public $voterId;

    protected $listeners = ['imageCaptured'];

    public function imageCaptured($dataUrl)
    {
        $this->image = $dataUrl; // Store the image data
    }

    public function savePhoto()
    {
        dd($this->image);
        if ($this->image) {

            // Ensure that the image is not null or empty
            if (strpos($this->image, 'data:image/png;base64,') !== false) {

                $image_parts = explode(";base64,", $this->image);
                $image_base64 = base64_decode($image_parts[1]);

                $filename = 'photo_' . substr(md5(time()), 0, 8) . '.png';

                Voter::where(
                    'id',
                    $this->voterId
                )->update(
                    [
                        'image_path' => $filename
                    ]
                );

                // Save the image
                Storage::disk('public')->put($filename, $image_base64);

                session()->flash('message', 'Photo saved successfully!');
            } else {
                session()->flash('error', 'Invalid image data!');
            }
        } else {
            session()->flash('error', 'No image captured!');
        }

        redirect()->route('system-validator-barangay-voter-list');
    }

    public function mount(Voter $voter)
    {
        $this->voterId = $voter->id;
    }

    public function render()
    {
        return view('livewire.camera.image-capture');
    }
}
