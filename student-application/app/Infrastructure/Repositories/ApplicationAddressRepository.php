<?php

// app/Infrastructure/Repositories/ApplicationAddressRepository.php (Update)
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ApplicationAddressRepositoryInterface;
use App\Models\ApplicationAddress;

class ApplicationAddressRepository implements ApplicationAddressRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId)
    {
        $conditions = ['type' => $data['type']];
        if ($applicationId) {
            $conditions['application_id'] = $applicationId;
        } else {
            $conditions['student_id'] = $data['student_id'];
        }

        return ApplicationAddress::updateOrCreate($conditions, $data);
    }

    public function getByApplicationId($applicationId)
    {
        return ApplicationAddress::where('application_id', $applicationId)->get();
    }
}