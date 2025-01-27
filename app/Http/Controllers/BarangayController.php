<?php

namespace App\Http\Controllers;

use App\Http\Requests\Barangay\AddBarangayRequest;
use App\Http\Requests\Barangay\UpdateBarangayRequest;
use App\Models\Barangay;
use App\Models\Voter;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function create()
    {
        return view('barangay.create');
    }

    public function store(AddBarangayRequest $request)
    {
        $arr = [
            'name' => $request->barangay,
            'municipality_id' => auth()->user()->municipality_id
        ];

        Barangay::create($arr);

        return redirect()->route('system-admin-barangay-list')->with('message', 'Barangay created successfully.');
    }

    public function edit(Barangay $barangay)
    {
        return view('barangay.edit', compact('barangay'));
    }

    public function update(UpdateBarangayRequest $request, Barangay $barangay)
    {
        $arr = [
            'name' => $request->barangay,
            'municipality_id' => auth()->user()->municipality_id
        ];

        $barangayData = Barangay::findOrFail($barangay->id);
        $barangayData->update($arr);

        return redirect()->route('system-admin-barangay-list')->with('message', 'Barangay created successfully.');
    }

    public function destroy(Barangay $barangay) {}

    public function getBarangays()
    {
        $voterFactions = Barangay::select('barangays.name')

            // Count voters and their remarks categories
            ->selectRaw('COUNT(voters.id) as total_voters')
            ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
            ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
            ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

            // Join with voters and municipalities
            ->leftJoin('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')

            // Filter by active voters and current user's municipality
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->where(function ($query) {
                $query->where('voters.status', 'Active')
                    ->orWhereNull('voters.id'); // Include barangays with no voters
            })

            // Group and order by barangay name
            ->groupBy('barangays.name')
            ->orderBy('barangays.name', 'asc')
            ->get();

        // Calculate percentages and handle zero voters
        $voterFactions = $voterFactions->map(function ($barangay) {
            $totalVoters = $barangay->total_voters;

            $barangay->ally_percentage = $totalVoters ? round(($barangay->ally_count / $totalVoters) * 100, 2) : 0;
            $barangay->opponent_percentage = $totalVoters ? round(($barangay->opponent_count / $totalVoters) * 100, 2) : 0;
            $barangay->undecided_percentage = $totalVoters ? round(($barangay->undecided_count / $totalVoters) * 100, 2) : 0;

            return $barangay;
        });


        return response()->json($voterFactions);
    }
}
