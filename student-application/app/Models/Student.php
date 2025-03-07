<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'uuid', 'secondary_roll', 'first_name', 'last_name', 'dob', 'gender',
        'category', 'email', 'mobile', 'password'
    ];

    protected $hidden = ['password'];


    protected $casts = [
        'uuid' => 'string',
    ];

    public function profile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function profiles()
    {
        return $this->hasMany(StudentProfile::class);
    }

    public function academicQualifications()
    {
        return $this->hasMany(AcademicQualification::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function upscAttempts()
    {
        return $this->hasMany(UpscAttempt::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class);
    }
}
