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


    protected $encrypt = ['fname', 'mname', 'lname', 'dob', 'gender'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt)) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->encrypt) && !empty($this->attributes[$key])) {
            return decrypt($this->attributes[$key]);
        }

        return parent::getAttribute($key);
    }
}
