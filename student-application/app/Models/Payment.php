<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'amount', 'method', 'transaction_date', 'transaction_id',
        'remarks', 'screenshot_document_id', 'status'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'method' => 'string',
        'status' => 'string',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function screenshotDocument()
    {
        return $this->belongsTo(Document::class, 'screenshot_document_id');
    }
    
    public function screenshot()
    {
        return $this->belongsTo(Document::class, 'screenshot_document_id');
    }

    // Add scope for filtering
    public function scopeByStatus($query, $status) {
        return $query->where('status', $status);
    }
}
