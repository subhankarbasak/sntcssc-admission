<?php

// app/Infrastructure/Repositories/ApplicationAcademicQualificationRepository.php (Update)
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface;
use App\Models\ApplicationAcademicQualification;

class ApplicationAcademicQualificationRepository implements ApplicationAcademicQualificationRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId)
    {
        $conditions = ['level' => $data['level']];
        if ($applicationId) {
            $conditions['application_id'] = $applicationId;
        } else {
            $conditions['student_id'] = $data['student_id'];
        }

        return ApplicationAcademicQualification::updateOrCreate($conditions, $data);
    }

    public function getByApplicationId($applicationId)
    {
        return ApplicationAcademicQualification::where('application_id', $applicationId)->get();
    }
}