<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVoterRequest;
use App\Http\Requests\UpdateVoterRequest;
use App\Http\Requests\validator\UpdateValidatorRequest;
use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view(
            'voter.create',
            [
                'barangays' => $barangays
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddVoterRequest $request)
    {
        try {
            Voter::create(
                [
                    'fname' => $request->validated()['fname'],
                    'mname' => $request->validated()['mname'],
                    'lname' => $request->validated()['lname'],
                    'suffix' => $request->validated()['suffix'],
                    'dob' => $request->validated()['dob'],
                    'gender' => $request->validated()['gender'],
                    'municipality_id' => auth()->user()->municipality_id,
                    'barangay_id' => $request->validated()['barangay'],
                    'precinct_no' => $request->validated()['precinct_no'],
                    'remarks' => $request->validated()['remarks'] ?? "Undecided"
                ]
            );

            return redirect()->route('system-admin-voters')->with('message', 'Voter added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add voter. Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voter $voter)
    {
        $voterDetails = Voter::where('id', $voter->id)->first();
        $voterBarangayDetails = Barangay::where('id', $voterDetails->barangay_id)->first();

        $barangays = Barangay::all();

        return view(
            'voter.edit',
            [
                'barangays' => $barangays,
                'voterDetails' => $voterDetails,
                'voterBarangayDetails' => $voterBarangayDetails
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoterRequest $request, Voter $voter)
    {
        try {
            $voter = Voter::findOrFail($voter->id);

            // Update the voter record with validated data
            $voter->update([
                'fname' => $request->validated()['fname'],
                'mname' => $request->validated()['mname'],
                'lname' => $request->validated()['lname'],
                'suffix' => $request->validated()['suffix'],
                'dob' => $request->validated()['dob'],
                'gender' => $request->validated()['gender'],
                'municipality_id' => auth()->user()->municipality_id,
                'barangay_id' => $request->validated()['barangay'],
                'precinct_no' => $request->validated()['precinct_no'],
                'remarks' => $request->validated()['remarks']
            ]);

            return redirect()->route('system-admin-voters')->with('message', 'Voter updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add voter. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validatorEdit(Voter $voter)
    {
        return view(
            'validator.edit',
            [
                'voter' => $voter
            ]
        );
    }

    public function validatorUpdate(UpdateValidatorRequest $request, Voter $voter)
    {
        $voter->update(
            [
                'gender' => $request->gender,
                'dob' => $request->dob,
                'remarks' => $request->remarks,
                'status' => $request->status
            ]
        );

        return redirect()->route('system-validator-barangay-voter-list')->with('message', 'Voter updated successfully!');
    }
}
