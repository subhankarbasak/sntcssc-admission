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
        'category', 'cat_cert_no', 'cat_issue_date', 'cat_issue_by', 'highest_qualification', 'email', 'mobile', 'password', 'password_text'
    ];

    protected $hidden = ['password'];


    protected $casts = [
        'uuid' => 'string',
    ];

    // 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $student->registration_no = self::generateRegistrationNo();
        });
    }

    private static function generateRegistrationNo()
    {
        $date = date('Ymd'); // Current date in YYYYMMDD format

        // Generate a random number and pad with zeros to ensure it's 4 digits
        $random_number = sprintf("%04d", rand(0, 9999)); 

        // Create the initial registration number
        $registration_no = $date . $random_number; 

        // Ensure uniqueness
        while (self::where('registration_no', $registration_no)->exists()) {
            $random_number = sprintf("%04d", rand(0, 9999)); 
            $registration_no = $date . $random_number; 
        }

        return $registration_no;
    }

    // 

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
