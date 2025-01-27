<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function create()
    {
        return view('designation.create');
    }

    public function store(AddDesignationRequest $request)
    {
        $arr = [
            'name' => $request->designation,
            'municipality_id' => auth()->user()->municipality_id
        ];

        Designation::create($arr);

        return redirect()->route('system-admin-designation')->with('message', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('designation.edit', compact('designation'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $designation->update([
            'name' => $request->designation
        ]);

        return redirect()->route('system-admin-designation')->with('message', 'Designation updated successfully.');
    }
}
