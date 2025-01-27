<?php

namespace App\Http\Controllers\systemadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\systemadmin\AddMunicipalityRequest;
use App\Http\Requests\systemadmin\UpdateMunicipalityRequest;
use App\Models\Barangay;
use App\Models\District;
use App\Models\Municipality;
use App\Models\Voter;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function index()
    {
        return view('systemadmin.municipality.index');
    }

    public function create()
    {
        return view('systemadmin.municipality.create', [
            'districts' => District::all()
        ]);
    }

    public function store(AddMunicipalityRequest $request)
    {
        Municipality::create(
            [
                'name' => $request->municipality,
                'district_id' => $request->district,
            ]
        );

        return redirect()->route('admin-manage-municipality')->with('message', 'Municipality created successfully.');
    }

    public function edit(Municipality $municipality)
    {
        $municipalityData = Municipality::select('municipalities.id', 'municipalities.name', 'districts.name as district_name', 'districts.id as district_id')
            ->join('districts', 'districts.id', '=', 'municipalities.district_id')
            ->where('municipalities.id', $municipality->id)
            ->first();


        return view('systemadmin.municipality.edit', [
            'municipality' => $municipalityData,
            'districts' => District::all()
        ]);
    }

    public function update(UpdateMunicipalityRequest $request, Municipality $municipality)
    {
        Municipality::where('id', $municipality->id)->update(
            [
                'name' => $request->municipality,
                'district_id' => $request->district,
            ]
        );

        return redirect()->route('admin-manage-municipality')->with('message', 'Municipality updated successfully.');
    }

    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return redirect()->route('admin-manage-municipality')->with('message', 'Municipality deleted successfully.');
    }


    // Method to get Barangays based on Municipality
    public function getBarangays(Request $request)
    {
        if ($request->ajax()) {
            // Retrieve Barangays based on the Municipality ID
            $barangays = Barangay::where('municipality_id', $request->municipality_id)->get();
            return response()->json($barangays);
        }
    }

    public function getMunicipalities()
    {
        $voterFactions = Municipality::select('municipalities.name as municipality_name')
            // Ensure a count even when no voters are present
            ->selectRaw('COALESCE(COUNT(voters.id), 0) as total_voters')
            ->selectRaw('COALESCE(SUM(voters.remarks = "ally"), 0) as ally_count')
            ->selectRaw('COALESCE(SUM(voters.remarks = "opponent"), 0) as opponent_count')
            ->selectRaw('COALESCE(SUM(voters.remarks = "undecided"), 0) as undecided_count')
            // Left join to include all municipalities
            ->leftJoin('voters', 'municipalities.id', '=', 'voters.municipality_id')
            ->where(function ($query) {
                // Include voters only if active
                $query->whereNull('voters.status')
                    ->orWhere('voters.status', 'Active');
            })
            ->groupBy('municipalities.name')
            ->orderBy('municipalities.name', 'asc')
            ->get();

        // Calculate percentages
        $voterFactions = $voterFactions->map(function ($record) {
            $totalVoters = $record->total_voters;

            // Calculate the percentage for each category
            $record->ally_percentage = $totalVoters ? round(($record->ally_count / $totalVoters) * 100, 2) : 0;
            $record->opponent_percentage = $totalVoters ? round(($record->opponent_count / $totalVoters) * 100, 2) : 0;
            $record->undecided_percentage = $totalVoters ? round(($record->undecided_count / $totalVoters) * 100, 2) : 0;

            return $record;
        });


        return response()->json($voterFactions);
    }
}
