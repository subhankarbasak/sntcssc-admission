<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'academic_year', 'code', 'start_date', 'end_date', 'status'];
    
    protected $casts = [
        'academic_year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
    ];

    public function batchPrograms()
    {
        return $this->hasMany(BatchProgram::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
