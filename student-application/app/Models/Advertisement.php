<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'title', 'code', 'application_start', 'application_end', 'status', 'instructions'];
    protected $casts = [
        'application_start' => 'datetime',
        'application_end' => 'datetime',
        'status' => 'string',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function programs()
    {
        return $this->hasMany(AdvertisementProgram::class);
    }

    public function advertisementPrograms()
    {
        return $this->hasMany(AdvertisementProgram::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
