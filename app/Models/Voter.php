<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return LogOptions::defaults()
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
}
