<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddingCardLayoutRequest;
use App\Models\CardLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = CardLayout::where('municipality_id', auth()->user()->municipality_id)->get();
        return view(
            'card.index',
            [
                'cards' => $cards
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddingCardLayoutRequest $request)
    {
        if ($request->hasFile('cardFile') && $request->file('cardFile')->isValid()) {

            // Check if there's an existing card design and delete it
            $existingCard = CardLayout::where('municipality_id', auth()->user()->municipality_id)->first(); // Assuming only one card design can exist at a time
            if ($existingCard) {
                // Delete the old file from storage
                Storage::disk('public')->delete($existingCard->image_path);

                // Delete the record from the database
                $existingCard->delete();
            }

            // Store the file (in public or storage)
            $path = $request->file('cardFile')->store('card_design', 'public');

            // You can access the filename using $request->file('cardFile')->getClientOriginalName()
            $filename = $request->file('cardFile')->getClientOriginalName();

            // Insert data into the database
            $cardFile = CardLayout::create([
                'image_path' => $path,
                'municipality_id' => auth()->user()->municipality_id
            ]);

            // Redirect or return a response
            return redirect()->route('system-admin-upload-card')->with('message', 'Card design uploaded successfully.');
        } else {
            return redirect()->route('system-admin-upload-card')->with('error', 'There was an error uploading the file.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CardLayout $cardLayout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CardLayout $cardLayout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardLayout $cardLayout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardLayout $cardLayout)
    {
        //
    }
}
