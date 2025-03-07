<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_duration',
        'min_qualification'
    ];

    public function batchPrograms()
    {
        return $this->hasMany(BatchProgram::class);
    }
}
