<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = "activity_log";

    protected $casts = [
        'properties' => 'array', // or 'object' if you prefer
    ];
}
