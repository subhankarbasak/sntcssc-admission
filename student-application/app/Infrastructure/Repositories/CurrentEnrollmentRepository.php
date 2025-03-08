<?php

// app/Infrastructure/Repositories/CurrentEnrollmentRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\CurrentEnrollmentRepositoryInterface;
use App\Models\CurrentEnrollment;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurrentEnrollmentRepository implements CurrentEnrollmentRepositoryInterface
{
    /**
     * Create a new CurrentEnrollment record.
     *
     * @param array $data
     * @return CurrentEnrollment
     * @throws InvalidArgumentException
     */
    public function create(array $data): CurrentEnrollment
    {
        $this->validate($data);
        return CurrentEnrollment::create($data);
    }

    /**
     * Update an existing CurrentEnrollment record.
     *
     * @param int $id
     * @param array $data
     * @return CurrentEnrollment
     * @throws InvalidArgumentException|ModelNotFoundException
     */
    public function update(int $id, array $data): CurrentEnrollment
    {
        $this->validate($data, $id);
        $record = CurrentEnrollment::findOrFail($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete a CurrentEnrollment record by ID.
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        $record = CurrentEnrollment::findOrFail($id);
        return $record->delete();
    }

    /**
     * Retrieve CurrentEnrollment by application ID.
     *
     * @param int $applicationId
     * @return CurrentEnrollment|null
     */
    public function getByApplicationId(int $applicationId): ?CurrentEnrollment
    {
        return CurrentEnrollment::where('application_id', $applicationId)->first();
    }

    /**
     * Validate the data for CurrentEnrollment.
     *
     * @param array $data
     * @param int|null $id
     * @throws InvalidArgumentException
     */
    private function validate(array $data, ?int $id = null): void
    {
        $rules = [
            'application_id' => 'required|exists:applications,id',
            'course_name' => 'nullable|string|max:255',
            'institute' => 'required_with:course_name|string|max:255',
        ];

        if ($id) {
            $rules['application_id'] .= "|unique:current_enrollments,application_id,{$id}";
        } else {
            $rules['application_id'] .= '|unique:current_enrollments,application_id';
        }

        $validator = Validator::make($data, $rules, [
            'application_id.required' => 'The application ID is required.',
            'application_id.exists' => 'The selected application does not exist.',
            'application_id.unique' => 'This application already has an enrollment record.',
            'course_name.max' => 'The course name must not exceed 255 characters.',
            'institute.required_with' => 'The institute is required when a course name is provided.',
            'institute.max' => 'The institute name must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }
}