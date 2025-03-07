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
        'batch_program_id',
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
}
