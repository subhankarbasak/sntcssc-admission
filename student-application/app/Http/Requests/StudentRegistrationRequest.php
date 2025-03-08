<?php

// app/Http/Requests/StudentRegistrationRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            // 'secondary_roll' => 'required|string|max:255',
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'gender' => 'required|in:Male,Female,Others',
            // 'dob' => 'required|date|before:today',
            // 'category' => 'required|in:UR,SC,ST,OBC A,OBC B',
            // 'email' => 'required|email|unique:students,email',
            // 'mobile' => 'required|digits:10|unique:students,mobile',
            // 'password' => 'required|min:8|confirmed',
            // 'addresses' => 'required|array|min:2',
            // 'addresses.*.type' => 'required|in:present,permanent',
            // 'academic_qualifications' => 'required|array|min:2',
            // 'academic_qualifications.*.level' => 'required|in:Secondary,Higher Secondary,Graduation,Post Graduation,Other',
            // 
            'secondary_roll' => 'required|string|max:255|unique:students',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'required|date',
            'category' => 'required|in:UR,SC,ST,OBC A,OBC B',
            'email' => 'required|email|unique:students,email',
            'mobile' => 'required|string|max:10|unique:students',
            'password' => 'required|confirmed|min:8',
            'addresses.*.address_line1' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.district' => 'required|string|max:255',
            'addresses.*.pin_code' => 'required|string|max:10',
            'academic_qualifications.*.level' => 'required|string',
            'academic_qualifications.*.institute' => 'required|string|max:255',
            'academic_qualifications.*.board_university' => 'required|string|max:255',
            'academic_qualifications.*.year_passed' => 'required|integer|min:1900|max:' . date('Y'),
            //
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            // Add other custom messages as needed
        ];
    }
}
