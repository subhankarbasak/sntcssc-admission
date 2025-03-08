<?php

// app/Infrastructure/Repositories/EmploymentHistoryRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\EmploymentHistoryRepositoryInterface;
use App\Models\EmploymentHistory;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class EmploymentHistoryRepository implements EmploymentHistoryRepositoryInterface
{
    public function create(array $data): EmploymentHistory
    {
        $this->validate($data);
        return EmploymentHistory::create($data);
    }

    public function update(int $id, array $data): EmploymentHistory
    {
        $this->validate($data, $id);
        $record = EmploymentHistory::findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id): bool
    {
        return EmploymentHistory::destroy($id) > 0;
    }

    public function getByApplicationId(int $applicationId): ?EmploymentHistory
    {
        return EmploymentHistory::where('application_id', $applicationId)->first();
    }

    private function validate(array $data, ?int $id = null): void
    {
        $rules = [
            'application_id' => 'required|exists:applications,id',
            'is_employed' => 'required|boolean',
            'designation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ];

        if ($id) {
            $rules['application_id'] .= "|unique:employment_histories,application_id,{$id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }
}

// Similar implementations for CurrentEnrollmentRepository and UpscAttemptRepository with appropriate validation