<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentEnrollment extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'course_name', 'institute'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->course_name)) {
                $model->institute = null;
            }
        });
    }

    public static function getEnrollmentbyApplicationId(int $applicationId)
    {
        return self::where('application_id', $applicationId)->first();
    }
}
