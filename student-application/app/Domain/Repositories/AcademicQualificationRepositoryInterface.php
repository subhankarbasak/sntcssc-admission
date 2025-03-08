<?php

// app/Domain/Repositories/AcademicQualificationRepositoryInterface.php
namespace App\Domain\Repositories;

interface AcademicQualificationRepositoryInterface
{
    public function createOrUpdate(array $data, $studentId);
    public function getByStudentId($studentId);
}