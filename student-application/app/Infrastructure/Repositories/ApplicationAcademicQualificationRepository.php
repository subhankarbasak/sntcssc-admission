<?php

// app/Infrastructure/Repositories/ApplicationAcademicQualificationRepository.php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface;
use App\Models\ApplicationAcademicQualification;

class ApplicationAcademicQualificationRepository implements ApplicationAcademicQualificationRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId)
    {
        // If an ID is provided, update the specific record
        if (isset($data['id']) && $data['id']) {
            $academic = ApplicationAcademicQualification::findOrFail($data['id']);
            $academic->update($data);
            return $academic;
        }

        // Otherwise, create a new record
        $data['application_id'] = $applicationId;
        return ApplicationAcademicQualification::create($data); // No `level` in conditions to allow duplicates
    }

    public function getByApplicationId($applicationId)
    {
        return ApplicationAcademicQualification::where('application_id', $applicationId)->get();
    }

    public function delete($id)
    {
        $academic = ApplicationAcademicQualification::findOrFail($id);
        return $academic->delete();
    }
}