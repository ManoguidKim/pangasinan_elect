<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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


    protected $encrypt = ['fname', 'mname', 'lname', 'dob'];

    // Mutator for encrypting attributes before saving
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt) && !is_null($value)) {
            $value = Crypt::encryptString($value);
        }

        parent::setAttribute($key, $value);
    }

    // Accessor for decrypting attributes when retrieving
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encrypt) && !empty($value)) {
            try {
                return Crypt::decryptString($value);
            } catch (Exception $e) {
                // Handle potential decryption failures
                report($e);
                return null; // Return null instead of crashing
            }
        }

        return $value;
    }
}
