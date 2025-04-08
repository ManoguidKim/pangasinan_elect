<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryVoter extends Model
{
    protected $table = "temporary_voters";
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
        'image_path',
        'is_uiconsulta'
    ];
}
