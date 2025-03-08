<?php

// app/Http/Requests/ApplicationStep1Request.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStep1Request extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'advertisement_id' => 'required|exists:advertisements,id',
            'advertisement_program_id' => 'required|exists:advertisement_programs,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'category' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|digits:10',
            // 
            'optional_subject' => 'required|string|max:255',
            'is_appearing_upsc_cse' => 'required',
            'upsc_attempts_count' => 'required',
        ];
    }
}