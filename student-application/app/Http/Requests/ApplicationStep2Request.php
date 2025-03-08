<?php

// app/Http/Requests/ApplicationStep2Request.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStep2Request extends FormRequest
{
    public function rules()
    {
        return [
            // 'addresses' => 'required|array|min:2',
            // 'addresses.*.type' => 'required|in:present,permanent',
            // 'addresses.*.state' => 'required|string',
            // 'addresses.*.district' => 'required|string',
            // 'addresses.*.address_line1' => 'required|string',
            // 'addresses.*.pin_code' => 'required|digits:6',
            
            // 'academic_qualifications' => 'required|array|min:2',
            // 'academic_qualifications.*.level' => 'required|in:Secondary,Higher Secondary,Graduation,Post Graduation,Other',
            // 'academic_qualifications.*.institute' => 'required|string',
            // 'academic_qualifications.*.board_university' => 'required|string',
            // 'academic_qualifications.*.year_passed' => 'required|digits:4|before_or_equal:' . date('Y'),


        'addresses.*.type' => 'required|in:present,permanent',
        'addresses.*.state' => 'required|string',
        'addresses.*.district' => 'required|string',
        'addresses.*.address_line1' => 'required|string|max:255',
        'addresses.*.pin_code' => 'required|string|max:10',
        'academic_qualifications.*.level' => 'required|in:Secondary,Higher Secondary,Graduation,Post Graduation,Other',
        'academic_qualifications.*.institute' => 'required|string|max:255',
        'academic_qualifications.*.board_university' => 'required|string|max:255',
        'academic_qualifications.*.year_passed' => 'required|integer|min:1900|max:' . date('Y'),
        ];
    }
}