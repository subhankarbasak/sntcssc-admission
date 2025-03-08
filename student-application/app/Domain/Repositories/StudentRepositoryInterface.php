<?php

// app/Domain/Repositories/StudentRepositoryInterface.php
namespace App\Domain\Repositories;
// use App\Domain\Entities\Student;
use App\Models\Student;

interface StudentRepositoryInterface
{
    public function create(array $data): Student;
    public function findByEmail(string $email);
}