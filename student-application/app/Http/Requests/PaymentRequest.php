<?php

// app/Http/Requests/PaymentRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function rules()
    {
        // Check if this is an update request
        $isUpdate = $this->method() === 'PATCH';
        
        $rules = [
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:UPI,NEFT,IMPS,Direct Account Transfer',
            'transaction_date' => 'required|date|before_or_equal:today',
            'transaction_id' => [
                'required',
                'string',
                'max:255',
            ],
            'screenshot' => [
                'file',
                'mimes:jpg,png,pdf',
                'max:2048'
            ]
        ];

        // For new payment (POST)
        if (!$isUpdate) {
            $rules['screenshot'][] = 'required';
            $rules['transaction_id'][] = Rule::unique('payments', 'transaction_id');
        } else {
            // For update (PATCH), make screenshot optional and ignore current transaction_id
            $paymentId = $this->route('application')->payment->id ?? null;
            $rules['transaction_id'][] = Rule::unique('payments', 'transaction_id')->ignore($paymentId);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'transaction_id.unique' => 'This transaction ID has already been used for another payment.',
            'screenshot.required' => 'Please upload a payment screenshot.',
            'screenshot.mimes' => 'The screenshot must be a file of type: jpg, png, or pdf.',
            'screenshot.max' => 'The screenshot may not be greater than 2MB.'
        ];
    }
}