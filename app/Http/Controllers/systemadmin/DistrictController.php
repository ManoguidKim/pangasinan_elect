<?php

namespace App\Http\Controllers\systemadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\systemadmin\AddDistrictRequest;
use App\Http\Requests\systemadmin\UpdateDistrictRequest;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        return view('systemadmin.district.index');
    }

    public function create()
    {
        return view('systemadmin.district.create');
    }

    public function store(AddDistrictRequest $request)
    {
        District::create(
            [
                'name' => $request->district
            ]
        );

        return redirect()->route('admin-manage-district')->with('message', 'District created successfully.');
    }

    public function edit(District $district)
    {
        return view('systemadmin.district.edit', compact('district'));
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        District::where('id', $district->id)
            ->update([
                'name' => $request->district
            ]);

        return redirect()->route('admin-manage-district')->with('message', 'District updated successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('admin-manage-district')->with('message', 'District updated successfully.');
    }
}
