<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'advertisement_id',
        'advertisement_program_id',
        'student_profile_id',
        'application_number',
        'optional_subject',
        'is_appearing_upsc_cse',
        'upsc_attempts_count',
        'status',
        'payment_status',
        'applied_at'
    ];

    protected $casts = [
        'is_appearing_upsc_cse' => 'boolean',
        'upsc_attempts_count' => 'integer',
        'applied_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function advertisementProgram()
    {
        return $this->belongsTo(AdvertisementProgram::class);
    }

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class);
    }

    public function profile()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }

    public function addresses()
    {
        return $this->hasMany(ApplicationAddress::class);
    }

    public function academicQualifications()
    {
        return $this->hasMany(ApplicationAcademicQualification::class);
    }

    public function upscAttempts()
    {
        return $this->hasMany(UpscAttempt::class);
    }

    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function currentEnrollments()
    {
        return $this->hasMany(CurrentEnrollment::class);
    }

    public function timelines()
    {
        return $this->hasMany(ApplicationTimeline::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function findApplications($studentId, $advertisementId)
    {
        return self::where('student_id', $studentId)
            ->where('advertisement_id', $advertisementId)
            ->first();
    }

    // public function payment()
    // {
    //     return $this->belongsTo(Payment::class);
    // }
    
    // Admin 

// Add scopes for filtering and searching
    public function scopeByStatus($query, $status) {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $paymentStatus) {
        return $query->where('payment_status', $paymentStatus);
    }

    public function scopeSearch($query, $search) {
        return $query->where(function ($q) use ($search) {
            $q->where('application_number', 'like', "%{$search}%")
              ->orWhereHas('studentProfile', function ($q) use ($search) {
                  $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
              });
        });
    }

    // Fix the payment relationship (it was incorrectly set as belongsTo)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Add permanent address relationship
    public function permanentAddress()
    {
        return $this->hasOne(ApplicationAddress::class)
            ->where('type', 'permanent');
    }
}
