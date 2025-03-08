<?php

// app/Domain/Repositories/EmploymentHistoryRepositoryInterface.php
namespace App\Domain\Repositories;
use App\Models\EmploymentHistory;

interface EmploymentHistoryRepositoryInterface
{
    public function create(array $data): EmploymentHistory;
    public function update(int $id, array $data): EmploymentHistory;
    public function delete(int $id): bool;
    public function getByApplicationId(int $applicationId): ?EmploymentHistory;
}