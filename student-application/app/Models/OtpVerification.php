<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'email', 'mobile', 'otp_code', 'type', 'expires_at', 'attempts'];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'attempts' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
