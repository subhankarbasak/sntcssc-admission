<?php

// app/Domain/Repositories/UpscAttemptRepositoryInterface.php
namespace App\Domain\Repositories;
use App\Models\UpscAttempt;
use Illuminate\Support\Collection;

interface UpscAttemptRepositoryInterface
{
    public function create(array $data): UpscAttempt;
    public function update(int $id, array $data): UpscAttempt;
    public function delete(int $id): bool;
    public function getByApplicationId(int $applicationId): Collection;
}