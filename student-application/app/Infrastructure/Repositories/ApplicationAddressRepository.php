<?php

// app/Infrastructure/Repositories/ApplicationAddressRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ApplicationAddressRepositoryInterface;
use App\Models\ApplicationAddress;

class ApplicationAddressRepository implements ApplicationAddressRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId)
    {
        // If an ID is provided, update the specific record
        if (isset($data['id']) && $data['id']) {
            $address = ApplicationAddress::findOrFail($data['id']);
            $address->update($data);
            return $address;
        }

        // Otherwise, create a new record
        $conditions = ['application_id' => $applicationId];
        $data['application_id'] = $applicationId;
        return ApplicationAddress::create($data); // No `type` in conditions to allow duplicates
    }

    public function getByApplicationId($applicationId)
    {
        return ApplicationAddress::where('application_id', $applicationId)->get();
    }

    public function delete($id)
    {
        $address = ApplicationAddress::findOrFail($id);
        return $address->delete();
    }
}