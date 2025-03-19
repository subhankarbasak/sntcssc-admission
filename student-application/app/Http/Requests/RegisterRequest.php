<?php

// app/Http/Requests/RegisterRequest.php (New)
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [

            'secondary_roll' => 'required|regex:/^[A-Za-z0-9]+$/|string|max:255|unique:students',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'category' => 'required|string|max:50',
            'cat_cert_no' => 'nullable|string|max:50',
            'cat_issue_date' => 'nullable|date|before:today',
            'cat_issue_by' => 'nullable|string|max:50',
            'highest_qualification' => 'required|string|max:50',
            'mobile' => 'required|string|digits:10|unique:students',
            'addresses' => 'required|array|min:2',
            'addresses.*.type' => 'required|in:present,permanent',
            'addresses.*.state' => 'required|string',
            'addresses.*.district' => 'required|string',
            'addresses.*.address_line1' => 'required|string',
            'addresses.*.post_office' => 'required|string',
            'addresses.*.pin_code' => 'required|digits:6',
            'academic_qualifications' => 'required|array|min:2',
            'academic_qualifications.*.level' => 'required|in:Secondary,Higher Secondary,Graduation,Post Graduation,Other',
            'academic_qualifications.*.institute' => 'required|string',
            'academic_qualifications.*.board_university' => 'required|string',
            'academic_qualifications.*.year_passed' => 'nullable|digits:4|before_or_equal:' . date('Y'),
            'academic_qualifications.*.subjects' => 'required|string',
            'academic_qualifications.*.total_marks' => 'nullable|string',
            'academic_qualifications.*.marks_obtained' => 'nullable|string',
            'academic_qualifications.*.cgpa' => 'nullable|string',
            'academic_qualifications.*.division' => 'nullable|string',
        ];
    }
}