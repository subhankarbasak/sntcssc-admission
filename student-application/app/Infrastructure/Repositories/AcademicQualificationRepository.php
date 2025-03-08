<?php

// app/Infrastructure/Repositories/AcademicQualificationRepository.php (Update)
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\AcademicQualificationRepositoryInterface;
use App\Models\AcademicQualification;

class AcademicQualificationRepository implements AcademicQualificationRepositoryInterface
{
    public function createOrUpdate(array $data, $studentId)
    {
        $conditions = ['level' => $data['level']];
        if ($studentId) {
            $conditions['student_id'] = $studentId;
        } else {
            $conditions['student_id'] = $data['student_id'];
        }

        return AcademicQualification::updateOrCreate($conditions, $data);
    }

    public function getByStudentId($studentId)
    {
        return AcademicQualification::where('student_id', $studentId)->get();
    }
}