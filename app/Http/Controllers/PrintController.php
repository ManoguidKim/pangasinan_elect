<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\CardLayout;
use App\Models\Designation;
use App\Models\Organization;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view(
            'print.index',
            [
                'barangays' => $barangays
            ]
        );
    }

    public function print(Request $request)
    {
        $barangay               = $request->input('barangay');
        $type                   = $request->input('type');
        $sub_type               = $request->input('sub_type');

        $cardLayout             = CardLayout::where('municipality_id', auth()->user()->municipality_id)->first()->image_path;

        if ($type == "Active Voter of Organization") {

            $voters = Voter::select(
                'voters.id as voter_id',
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                DB::raw("GROUP_CONCAT(organizations.name ORDER BY organizations.name SEPARATOR ', ') as organization_names") // Concatenate organization names
            )
                ->join('voter_organizations', 'voter_organizations.voter_id', '=', 'voters.id')
                ->join('organizations', 'organizations.id', '=', 'voter_organizations.organization_id')
                ->where([
                    ['voters.municipality_id', auth()->user()->municipality_id],
                    ['voters.barangay_id', $barangay],
                    ['voters.status', 'Active']
                ]);

            if ($sub_type) {
                $voters->where('organizations.id', $sub_type);
            }

            $voters = $voters->groupBy('voters.id') // Ensures one row per voter
                ->orderBy('voters.lname', 'ASC')
                ->get();

            return view('print.qr', compact('voters', 'cardLayout'));
        } else if ($type == "Active Voter of Barangay Staff") {

            $voters = Voter::select(
                'voters.id as voter_id',
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                DB::raw("GROUP_CONCAT(designations.name ORDER BY designations.name SEPARATOR ', ') as designation_names") // Concatenate designation names
            )
                ->join('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
                ->join('designations', 'designations.id', '=', 'voter_designations.designation_id')
                ->where([
                    ['voters.municipality_id', auth()->user()->municipality_id],
                    ['voters.barangay_id', $barangay],
                    ['voters.status', 'Active']
                ]);

            if ($sub_type) {
                $voters->where('designations.id', $sub_type);
            }

            $voters = $voters->groupBy('voters.id') // Ensures one row per voter
                ->orderBy('voters.lname', 'ASC')
                ->get();

            return view('print.qr', compact('voters', 'cardLayout'));
        } else {
            $voters = Voter::where('barangay_id', $barangay)
                ->where('municipality_id', auth()->user()->municipality_id)
                ->orderBy('lname')
                ->get();

            return view('print.qr', compact('voters', 'cardLayout'));
        }
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
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
