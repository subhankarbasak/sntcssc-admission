<?php

// app/Domain/Repositories/CurrentEnrollmentRepositoryInterface.php
namespace App\Domain\Repositories;
use App\Models\CurrentEnrollment;

interface CurrentEnrollmentRepositoryInterface
{
    public function create(array $data): CurrentEnrollment;
    public function update(int $id, array $data): CurrentEnrollment;
    public function delete(int $id): bool;
    public function getByApplicationId(int $applicationId): ?CurrentEnrollment;
}