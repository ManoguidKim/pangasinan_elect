<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function create()
    {
        return view('organization.create');
    }

    public function store(AddOrganizationRequest $request)
    {
        $arr = [
            'name' => $request->organization,
            'municipality_id' => auth()->user()->municipality_id
        ];

        Organization::create($arr);

        return redirect()->route('system-admin-organization')->with('message', 'Organization created successfully.');
    }

    public function edit(Organization $organization)
    {
        return view('organization.edit', compact('organization'));
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $org = Organization::findOrFail($organization->id);

        $arr = [
            'name' => $request->organization
        ];
        $org->update($arr);

        return redirect()->route('system-admin-organization')->with('message', 'Organization updated successfully.');
    }
}
