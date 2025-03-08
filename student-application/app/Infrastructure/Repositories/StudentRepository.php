<?php

// app/Infrastructure/Repositories/StudentRepository.php
namespace App\Infrastructure\Repositories;

// use App\Domain\Entities\Student;
use App\Models\Student;
use App\Domain\Repositories\StudentRepositoryInterface;
use App\Models\Student as StudentModel;

class StudentRepository implements StudentRepositoryInterface
{
    public function create(array $data): Student
    {
        $student = StudentModel::create($data);
        // return new Student($student->toArray());
        return $student ?? new Student($student->toArray());
    }

    public function findByEmail(string $email)
    {
        $student = StudentModel::where('email', $email)->first();
        return $student ? new Student($student->toArray()) : null;
    }
}