<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangepasswordRequest;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function create()
    {
        $barangays = [];
        if (auth()->user()->role == "Admin") {
            $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        }

        return view('user.create', [
            'municipalities' => Municipality::all(),
            'barangays' => $barangays
        ]);
    }

    public function store(AddUserRequest $request)
    {

        if (auth()->user()->role == "Admin") {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'barangay_id' => $request->barangay,
                'municipality_id' => auth()->user()->municipality_id,
            ]);
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'barangay_id' => $request->barangay,
                'municipality_id' => $request->municipality,
            ]);
        }



        return redirect()->route('system-admin-accounts')->with('status', 'New user has been added');
    }

    public function changePasswordView()
    {
        return view('change-password');
    }

    public function changePassword(ChangepasswordRequest $request)
    {

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::invalidate();
        Session::regenerate();

        return redirect()->route('login')->with('status', 'Password successfully changed. Please log in again.');
    }
}
