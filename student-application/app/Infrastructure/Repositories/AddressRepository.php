<?php

// app/Infrastructure/Repositories/AddressRepository.php (Update)
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function createOrUpdate(array $data, $studentId)
    {
        $conditions = ['type' => $data['type']];
        if ($studentId) {
            $conditions['student_id'] = $studentId;
        } else {
            $conditions['student_id'] = $data['student_id'];
        }

        return Address::updateOrCreate($conditions, $data);
    }

    public function getByStudentId($studentId)
    {
        return Address::where('student_id', $studentId)->get();
    }
}