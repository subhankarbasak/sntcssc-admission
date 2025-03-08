<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'is_employed', 'designation', 'employer', 'location'];
    protected $casts = [
        'is_employed' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_employed === false) {
                $model->designation = null;
                $model->employer = null;
                $model->location = null;
            }
        });
    }
}
