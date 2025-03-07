<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAcademicQualification extends Model
{
    protected $fillable = [
        'application_id', 'level', 'institute', 'board_university', 'subjects', 'year_passed',
        'total_marks', 'marks_obtained', 'percentage', 'cgpa', 'division', 'is_completed',
        'verification_status'
    ];
    protected $casts = [
        'year_passed' => 'integer',
        'total_marks' => 'decimal:2',
        'marks_obtained' => 'decimal:2',
        'percentage' => 'decimal:2',
        'cgpa' => 'decimal:2',
        'is_completed' => 'boolean',
        'verification_status' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
