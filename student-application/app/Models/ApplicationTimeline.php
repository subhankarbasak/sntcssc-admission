<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'event_type', 'event_data', 'event_context'];
    protected $casts = [
        'event_data' => 'array',
        'event_context' => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
