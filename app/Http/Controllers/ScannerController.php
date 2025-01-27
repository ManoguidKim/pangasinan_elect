<?php

namespace App\Http\Controllers;

use App\Models\Scanlog;
use App\Models\Voter;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner.index');
    }

    public function show(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $scannerMunicipalityID = auth()->user()->municipality_id;

        $voterId = $request->voterid;

        $voterDetails = Voter::find($voterId);

        if (!$voterDetails) {
            return redirect()->route('admin-scanner')->with('error', 'Voter record not found.');
        }

        if ($scannerMunicipalityID != $voterDetails->municipality_id) {
            return redirect()->route('admin-scanner')->with('error', 'Warning! The scanner and the voter are associated with different municipality tags, which indicates a mismatch. This action is restricted and cannot be allowed due to permission constraints.');
        }

        $scanLogExists = ScanLog::where('voter_id', $voterId)->exists();

        if ($scanLogExists) {
            return redirect()->route('admin-scanner')->with('error', 'This QR code card has already been scanned.');
        }

        $scanLog = new ScanLog();
        $scanLog->voter_id = $voterId;
        $scanLog->user_id = auth()->user()->id;
        $scanLog->save();

        return redirect()->route('admin-scanner')->with('message', 'QR code scanned successfully!');
    }
}
