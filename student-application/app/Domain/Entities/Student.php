<?php

// app/Domain/Entities/Student.php
namespace App\Domain\Entities;

class Student
{
    public $id;
    public string $secondaryRoll;
    public string $firstName;
    public string $lastName;
    public string $dob;
    public string $gender;
    public string $category;
    public string $email;
    public string $mobile;
    // ... other properties
    
    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'] ?? null;
        $this->secondaryRoll = $attributes['secondary_roll'];
        $this->firstName = $attributes['first_name'];
        $this->lastName = $attributes['last_name'];
        $this->dob = $attributes['dob'];
        $this->gender = $attributes['gender'];
        $this->category = $attributes['category'];
        $this->email = $attributes['email'];
        $this->mobile = $attributes['mobile'];
        // ... set other properties
    }
}