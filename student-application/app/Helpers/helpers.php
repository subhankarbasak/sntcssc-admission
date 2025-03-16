<?php

if (!function_exists('formatFieldName')) {
    function formatFieldName($fieldName) {
        return Str::title(str_replace(['_', '-'], ' ', $fieldName));
    }
}


if (!function_exists('getFieldLabel')) {
    function getFieldLabel($fieldName) {
        $fieldMap = [
            // Personal Information
            'first_name' => 'Student First Name',
            'last_name' => 'Student Last Name',
            'dob' => 'Date of Birth',
            'father_name' => "Father's Name",
            'father_occupation' => "Father's Occupation",
            'mother_name' => "Mother's Name",
            // 
            'level' => "Level",
            'category_cert' => "Category Certificate",
            'payment_ss' => "Payment Screenshot"
        ];

        return $fieldMap[$fieldName] ?? Str::title(str_replace('_', ' ', $fieldName));
    }
}