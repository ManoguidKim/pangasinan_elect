<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Organization;
use Illuminate\Http\Request;

class DynamicController extends Controller
{
    public function getSubType(Request $request)
    {
        $type = $request->type;
        $data = [];
        if ($type == "Active Voter of Organization") {
            $data['subtype'] = Organization::all();
        } else if ($type == "Active Voter of Barangay Staff") {
            $data['subtype'] = Designation::all();
        }

        return response()->json($data);
    }
}
