<?php

// app/Http/Requests/PaymentRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:UPI,Bank Transfer',
            'transaction_date' => 'required|date|before_or_equal:today',
            'transaction_id' => 'required|string|max:255|unique:payments,transaction_id',
            'screenshot' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
        ];
    }
}