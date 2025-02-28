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
    use LogsActivity;

    protected static $logAttributes = [
        'fname',
        'mname',
        'lname',
        'suffix',
        'precinct_no',
        'gender',
        'dob',
        'remarks'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->logOnly([
                'fname',
                'mname',
                'lname',
                'suffix',
                'precinct_no',
                'gender',
                'dob',
                'remarks'
            ])
            ->logOnlyDirty();

        if (Auth::check() && Auth::user()->role === 'Admin') {
            activity()->disableLogging();
        }

        return $logOptions;
    }

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


    // protected $casts = [
    //     'fname' => EncryptedCast::class,
    //     'lname' => EncryptedCast::class,
    //     'mname' => EncryptedCast::class
    // ];
}
