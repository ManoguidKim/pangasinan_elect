<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountLivewire extends Component
{
    public $name;
    public $email;
    public $password;
    public $role;
    public $barangay;
    public $municipality;

    public $barangayData = [];
    public $municipalityData = [];

    public $account_id;

    public $search = '';

    protected $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'barangay' => 'nullable',
        'role' => 'required',
    ];

    public function render()
    {
        if (auth()->user()->role == "Admin") {
            $users = User::select('users.id', 'users.name', 'users.email', 'users.role', 'barangays.name as barangay_name', 'municipalities.name as municipality_name')
                ->leftJoin('municipalities', 'municipalities.id', '=', 'users.municipality_id')
                ->leftJoin('barangays', 'barangays.id', '=', 'users.barangay_id')
                ->where('users.municipality_id', auth()->user()->municipality_id)
                ->where('users.role', '!=', 'Super Admin')
                ->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.role', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%');
                })
                ->orderBy('users.id', 'desc')
                ->paginate(50);
        } else {
            $users = User::select('users.id', 'users.name', 'users.email', 'users.role', 'barangays.name as barangay_name', 'municipalities.name as municipality_name')
                ->leftJoin('municipalities', 'municipalities.id', '=', 'users.municipality_id')
                ->leftJoin('barangays', 'barangays.id', '=', 'users.barangay_id')
                ->where('users.role', 'Admin')
                ->orWhere('users.role', 'Super Admin')
                ->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.role', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%');
                })
                ->orderBy('users.id', 'desc')
                ->paginate(50);
        }


        $barangays = Barangay::all();

        return view(
            'livewire.account-livewire',
            [
                'users' => $users,
                'barangays' => $barangays
            ]
        );
    }

    public function createUser()
    {
        // $this->authorize('createUser', User::class);
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'barangay_id' => $this->barangay,
        ]);

        session()->flash('message', 'User created successfully');
        $this->resetFields();
    }

    public function deleteUser(User $user)
    {
        // $this->authorize('deleteUser', User::class);
        $user->delete();

        session()->flash('message', 'User deleted successfully');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->barangay = '';
        $this->account_id = null;
    }
}
