<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribe extends Model
{
    protected $fillable = [
        'email',
        'email_type',
        'ip_address',
    ];

    protected $dates = [
        'unsubscribed_at',
    ];
}