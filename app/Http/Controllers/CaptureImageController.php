<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaptureImageController extends Controller
{
    public function showCamera(Voter $voter)
    {
        return view(
            'camera.index',
            [
                'voterId' => $voter->id
            ]
        );
    }

    public function updateVoterImage(Request $request, Voter $voter)
    {

        $image = $request->image_data;

        // Ensure that the image is not null or empty
        if (strpos($image, 'data:image/png;base64,') !== false) {

            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);

            $filename = 'photo_' . substr(md5(time()), 0, 8) . '.png';

            Voter::where(
                'id',
                $voter->id
            )->update(
                [
                    'image_path' => $filename
                ]
            );

            Storage::disk('public')->put($filename, $image_base64);

            session()->flash('message', 'Photo saved successfully!');
        } else {
            session()->flash('error', 'Invalid image data!');
        }

        return redirect()->route('system-validator-barangay-voter-list')->with('message', 'Voter image updated successfully.');
    }
}
