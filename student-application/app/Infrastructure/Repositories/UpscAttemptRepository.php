<?php

// app/Infrastructure/Repositories/UpscAttemptRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\UpscAttemptRepositoryInterface;
use App\Models\UpscAttempt;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UpscAttemptRepository implements UpscAttemptRepositoryInterface
{
    /**
     * Create a new UPSC Attempt record.
     *
     * @param array $data
     * @return UpscAttempt
     * @throws InvalidArgumentException
     */
    public function create(array $data): UpscAttempt
    {
        $this->validate($data);
        return UpscAttempt::create($data);
    }

    /**
     * Update an existing UPSC Attempt record.
     *
     * @param int $id
     * @param array $data
     * @return UpscAttempt
     * @throws InvalidArgumentException|ModelNotFoundException
     */
    public function update(int $id, array $data): UpscAttempt
    {
        $this->validate($data, $id);
        $record = UpscAttempt::findOrFail($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete a UPSC Attempt record by ID.
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        $record = UpscAttempt::findOrFail($id);
        return $record->delete();
    }

    /**
     * Retrieve all UPSC Attempts by application ID.
     *
     * @param int $applicationId
     * @return Collection
     */
    // public function getByApplicationId(int $applicationId): Collection
    // {
    //     return UpscAttempt::where('application_id', $applicationId)->get();
    // }

    public function getByApplicationId(int $applicationId): Collection
    {
        return UpscAttempt::where('application_id', $applicationId)->get();
    }

    /**
     * Validate the data for UPSC Attempt.
     *
     * @param array $data
     * @param int|null $id
     * @throws InvalidArgumentException
     */
    private function validate(array $data, ?int $id = null): void
    {
        $rules = [
            'student_id' => 'required|exists:students,id',
            'application_id' => 'required|exists:applications,id',
            'exam_year' => [
                'required',
                'digits:4',
                'before_or_equal:' . date('Y'),
                function ($attribute, $value, $fail) use ($data, $id) {
                    $exists = UpscAttempt::where('student_id', $data['student_id'])
                        ->where('exam_year', $value)
                        ->where('id', '!=', $id)
                        ->exists();
                    if ($exists) {
                        $fail('You have already recorded an attempt for this year.');
                    }
                },
            ],
            'roll_number' => 'required|string|max:20',
            'prelims_cleared' => 'boolean',
            'mains_cleared' => 'boolean',
            'attempt_number' => 'nullable|integer|min:1',
        ];

        $validator = Validator::make($data, $rules, [
            'student_id.required' => 'The student ID is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'application_id.required' => 'The application ID is required.',
            'application_id.exists' => 'The selected application does not exist.',
            'exam_year.required' => 'The exam year is required.',
            'exam_year.digits' => 'The exam year must be a 4-digit number.',
            'exam_year.before_or_equal' => 'The exam year cannot be in the future.',
            'roll_number.required' => 'The roll number is required.',
            'roll_number.max' => 'The roll number must not exceed 20 characters.',
            'attempt_number.min' => 'The attempt number must be at least 1.',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }
}