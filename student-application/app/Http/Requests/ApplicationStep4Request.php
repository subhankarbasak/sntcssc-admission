<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStep4Request extends FormRequest
{
    public function rules()
    {
        $application = $this->route('application'); // Get the application from the route
        $documents = $application->documents ?? collect(); // Fetch existing documents
        $profile = $application->profile; // Assuming profile is a relationship on the Application model

        return [
            'photo' => [
                // Required only if no photo exists
                function ($attribute, $value, $fail) use ($documents) {
                    if (!$documents->where('type', 'photo')->first() && !$this->hasFile('photo')) {
                        $fail('Please upload a photograph.');
                    }
                },
                'image',
                'max:2048', // 2MB max
            ],
            'signature' => [
                // Required only if no signature exists
                function ($attribute, $value, $fail) use ($documents) {
                    if (!$documents->where('type', 'signature')->first() && !$this->hasFile('signature')) {
                        $fail('Please upload your signature.');
                    }
                },
                'image',
                'max:1024', // 1MB max
            ],
            'category_cert' => [
                // Required if category is not 'UR' and no existing certificate
                function ($attribute, $value, $fail) use ($documents, $profile) {
                    if ($profile && $profile->category !== 'UR' && !$documents->where('type', 'category_cert')->first() && !$this->hasFile('category_cert')) {
                        $fail('Please upload a category certificate.');
                    }
                },
                'nullable',
                'file',
                'mimes:pdf,jpg,png',
                'max:2048',
            ],
            'pwbd_cert' => [
                // Required if is_pwbd is 1 and no existing certificate
                function ($attribute, $value, $fail) use ($documents, $profile) {
                    if ($profile && $profile->is_pwbd == 1 && !$documents->where('type', 'pwbd_cert')->first() && !$this->hasFile('pwbd_cert')) {
                        $fail('Please upload a PwBD certificate.');
                    }
                },
                'nullable',
                'file',
                'mimes:pdf,jpg,png',
                'max:2048',
            ],
        ];
    }

    public function messages()
    {
        return [
            'photo.image' => 'The photograph must be an image (jpeg, png, etc.).',
            'photo.max' => 'The photograph size must not exceed 2MB.',
            'signature.image' => 'The signature must be an image (jpeg, png, etc.).',
            'signature.max' => 'The signature size must not exceed 1MB.',
            'category_cert.file' => 'The category certificate must be a valid document.',
            'category_cert.mimes' => 'The category certificate must be a file of type: pdf, jpg, png.',
            'category_cert.max' => 'The category certificate size must not exceed 2MB.',
            'pwbd_cert.file' => 'The PwBD certificate must be a valid document.',
            'pwbd_cert.mimes' => 'The PwBD certificate must be a file of type: pdf, jpg, png.',
            'pwbd_cert.max' => 'The PwBD certificate size must not exceed 2MB.',
        ];
    }
}