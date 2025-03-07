<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'type', 'file_path', 'uploaded_at', 'verified_at', 'verification_status'];
    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'type' => 'string',
        'verification_status' => 'string',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
