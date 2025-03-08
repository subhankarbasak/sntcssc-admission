<?php

// app/Infrastructure/Repositories/StudentProfileRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\StudentProfileRepositoryInterface;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class StudentProfileRepository implements StudentProfileRepositoryInterface
{
    // public function create(array $data)
    // {
    //     return StudentProfile::create($data);
    // }

    public function create(array $data)
    {
        try {
            // Begin database transaction
            DB::beginTransaction();
            
            // Attempt to create the student profile
            $studentProfile = StudentProfile::create($data);
            
            // Commit the transaction if successful
            DB::commit();
            
            // Log success (assuming you have a Log facade configured)
            Log::info('Student profile created successfully', [
                'student_id' => $studentProfile->id,
                'data' => $data
            ]);
            
            return $studentProfile;
            
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            
            // Log the error
            Log::error('Failed to create student profile', [
                'error' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Optionally re-throw the exception if you want it to be handled upstream
            throw $e;
            
            // Or return a custom error response
            // return null;
            // return false;
        }
    }

    public function getCurrentProfile($studentId)
    {
        return StudentProfile::where('student_id', $studentId)
            ->where('is_current', true)
            ->first();
    }

    public function update($id, array $data)
    {
        $profile = StudentProfile::findOrFail($id);
        $profile->update($data);
        return $profile;
    }
}