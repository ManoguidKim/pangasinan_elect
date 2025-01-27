<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoterDesignation extends Model
{
    use HasFactory;

    protected $fillable = [
        'voter_id',
        'designation_id'
    ];
}
