<?php

namespace App\Models;

use App\Casts\EncryptedCast;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Voter extends Model
{
    use HasFactory;

    // protected static $logAttributes = [
    //     'fname',
    //     'mname',
    //     'lname',
    //     'suffix',
    //     'precinct_no',
    //     'gender',
    //     'dob',
    //     'remarks'
    // ];

    // protected static $logOnlyDirty = true; // Log changes only

    // protected static $logEvents = ['created', 'updated', 'deleted']; // Enable delete logging

    // public function getActivitylogOptions(): LogOptions
    // {
    //     // Check if the user is an admin
    //     if (Auth::check() && Auth::user()->role === 'Admin') {
    //         return LogOptions::defaults()->disableLogging(); // Disable logging for admins
    //     }

    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'fname',
    //             'mname',
    //             'lname',
    //             'suffix',
    //             'precinct_no',
    //             'gender',
    //             'dob',
    //             'remarks'
    //         ])
    //         ->logOnlyDirty()
    //         ->useLogName('voter_activity'); // Name the log for easier filtering
    // }

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'suffix',
        'precinct_no',
        'barangay_id',
        'municipality_id',
        'gender',
        'dob',
        'remarks',
        'image_path'
    ];
}
