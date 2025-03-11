<?php

// app/Http/Requests/ApplicationStep3Request.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationStep3Request extends FormRequest
{
    // public function rules()
    // {
    //     return [
    //         'employment.is_employed' => 'required|boolean',
    //         'employment.designation' => 'nullable|string|max:255',
    //         'employment.employer' => 'nullable|string|max:255',
    //         'employment.location' => 'nullable|string|max:255',
            
    //         'enrollment.course_name' => 'nullable|string|max:255',
    //         'enrollment.institute' => 'nullable|string|max:255',
            
    //         'upsc_attempts' => 'nullable|array',
    //         'upsc_attempts.*.exam_year' => 'required_with:upsc_attempts|digits:4|before_or_equal:' . date('Y'),
    //         'upsc_attempts.*.roll_number' => 'required_with:upsc_attempts|string|max:20',
    //         'upsc_attempts.*.prelims_cleared' => 'boolean',
    //         'upsc_attempts.*.mains_cleared' => 'boolean',
    //     ];
    // }

    public function rules(): array
    {
        return [
            'employment' => 'required|array',
            'employment.is_employed' => 'required|boolean',
            'employment.designation' => 'nullable|string|max:255',
            'employment.employer' => 'nullable|string|max:255',
            'employment.location' => 'nullable|string|max:255',
            
            'enrollment' => 'nullable|array',
            'enrollment.course_name' => 'nullable|string|max:255',
            'enrollment.institute' => 'nullable|string|max:255',
            
            'upsc_attempts' => 'nullable|array',
            'upsc_attempts.*.id' => 'nullable|exists:upsc_attempts,id',
            'upsc_attempts.*.exam_year' => [
                'required_with:upsc_attempts',
                'digits:4',
                'before_or_equal:' . date('Y'),
                function ($attribute, $value, $fail) {
                    // Extract the index from the attribute (e.g., "upsc_attempts.0.exam_year" -> 0)
                    preg_match('/upsc_attempts\.(\d+)\.exam_year/', $attribute, $matches);
                    $index = $matches[1] ?? null;

                    // Get the ID of the current attempt being validated
                    $attemptId = $this->input("upsc_attempts.$index.id");

                    // Check uniqueness for this exam_year, ignoring the current attempt's ID
                    $exists = \DB::table('upsc_attempts')
                        ->where('student_id', auth()->id())
                        ->where('exam_year', $value)
                        ->where('id', '!=', $attemptId) // Ignore the current attempt
                        ->exists();

                    if ($exists) {
                        $fail("You have already entered an attempt for the year $value.");
                    }
                },
            ],
            'upsc_attempts.*.roll_number' => 'required_with:upsc_attempts|string|max:20',
            'upsc_attempts.*.prelims_cleared' => 'boolean',
            'upsc_attempts.*.mains_cleared' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'employment.designation.required_if' => 'Designation is required when employed',
            'upsc_attempts.*.exam_year.unique' => 'You have already entered an attempt for this year',
        ];
    }
}