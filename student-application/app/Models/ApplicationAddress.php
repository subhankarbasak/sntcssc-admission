<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAddress extends Model
{
    protected $fillable = [
        'application_id', 'type', 'state', 'district', 'subdistrict', 'address_line1',
        'address_line2', 'post_office', 'police_station', 'pin_code', 'is_verified'
    ];
    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function getByApplicationId($applicationId)
    {
        return self::where('application_id', $applicationId)->get();
    }
}
