<?php

// app/Http/Requests/ApplicationStep4Request.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStep4Request extends FormRequest
{
    public function rules()
    {
        return [
            'photo' => 'required|image|max:2048', // 2MB max
            'signature' => 'required|image|max:1024', // 1MB max
            'category_cert' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'pwbd_cert' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'photo.required' => 'Please upload a photograph.',
            'signature.required' => 'Please upload your signature.',
            'photo.image' => 'The photograph must be an image (jpeg, png, etc.).',
            'signature.image' => 'The signature must be an image (jpeg, png, etc.).',
            'category_cert.file' => 'The category certificate must be a valid document.',
            'category_cert.mimes' => 'The category certificate must be a file of type: pdf, jpg, png.',
            'category_cert.max' => 'The category certificate size must not exceed 2MB.',
            'pwbd_cert.file' => 'The PWBD certificate must be a valid document.',
            'pwbd_cert.mimes' => 'The PWBD certificate must be a file of type: pdf, jpg, png.',
            'pwbd_cert.max' => 'The PWBD certificate size must not exceed 2MB.',
        ];
    }
}