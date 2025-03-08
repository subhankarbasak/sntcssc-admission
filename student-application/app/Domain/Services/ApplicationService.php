<?php

// app/Domain/Services/ApplicationService.php
namespace App\Domain\Services;

use App\Domain\Repositories\ApplicationRepositoryInterface;
use App\Domain\Repositories\StudentProfileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Domain\Repositories\ApplicationAddressRepositoryInterface;
use App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface;
use App\Domain\Repositories\EmploymentHistoryRepositoryInterface;
use App\Domain\Repositories\CurrentEnrollmentRepositoryInterface;
use App\Domain\Repositories\UpscAttemptRepositoryInterface;
use Exception;
use App\Models\EmploymentHistory;
use App\Models\CurrentEnrollment;
use App\Models\UpscAttempt;

class ApplicationService
{
    private $applicationRepository;
    private $profileRepository;

    private $addressRepository;
    private $academicRepository;

    private $employmentRepository;
    private $enrollmentRepository;
    private $upscRepository;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        StudentProfileRepositoryInterface $profileRepository,
        ApplicationAddressRepositoryInterface $addressRepository,
        ApplicationAcademicQualificationRepositoryInterface $academicRepository,
        EmploymentHistoryRepositoryInterface $employmentRepository,
        CurrentEnrollmentRepositoryInterface $enrollmentRepository,
        UpscAttemptRepositoryInterface $upscRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->profileRepository = $profileRepository;
        $this->addressRepository = $addressRepository;
        $this->academicRepository = $academicRepository;
        $this->employmentRepository = $employmentRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->upscRepository = $upscRepository;
    }

    public function startApplication($studentId, $advertisementId, array $data)
    {
        try {
            DB::beginTransaction();

            $currentProfile = $this->profileRepository->getCurrentProfile($studentId);
            $profileData = $this->prepareProfileData($data);
            
            // 
            $applicationData = $this->applicationRepository->findApplications($studentId, $advertisementId);
            // if exists applicationData then fetch student profile id and update it withspecific fields, otherwise create new application record.
            if(!$applicationData){
                // Means there are no applications with this student ID and Advertisement ID, so need to create applications and update Student Profile accordingly.
                // 1. : Fetch Current Profile ($currentProfile)
                // 2. : Update Current Profile with the current Step1 Application form Data ($profileData).
                // 3. Create Application and link profile id 
                $updateProfile = $this->profileRepository->update($currentProfile->id, $profileData);
                $profileId = $updateProfile->id;
                // create Application
                $application = $this->applicationRepository->create([
                    'student_id' => $studentId,
                    'advertisement_id' => $advertisementId,
                    'advertisement_program_id' => $data['advertisement_program_id'],
                    'student_profile_id' => $profileId,
                    'application_number' => 'APP' . time(),
                    'status' => 'draft'
                ]);
            }else{
                // Means there are application found with this Student ID and Advertisement ID, so need to Update Applications and Student Profile Accordingly
                // First: need to fetch Student Profile with Applications student profile id
                // Second: Update Student profile
                // Third: Update Applications.
                // dd('Todo: Need to update');
                $updateProfile = $this->profileRepository->update($applicationData->student_profile_id, $profileData);
                $profileId = $updateProfile->id;
                // Update the Application but make sure not to update application_number and others
                $application = $this->applicationRepository->update($applicationData->id, [
                    // 'student_id' => $studentId,
                    // 'advertisement_id' => $advertisementId,
                    // 'advertisement_program_id' => $data['advertisement_program_id'],
                    // 'student_profile_id' => $profileId,
                    // 'application_number' => 'APP' . time(),
                    'optional_subject' => $profileData['optional_subject'],
                    'is_appearing_upsc_cse' => $profileData['is_appearing_upsc_cse'],
                    'upsc_attempts_count' => $profileData['upsc_attempts_count'],
                    'status' => 'draft'
                ]);
            }
            // dd($profileData);
            // 

            // if ($currentProfile) {
            //     // Todo: here need to check if advertisement_id and advertisement_program_id same in currentProfile and profileData then update and link $profileId = $currentProfile->id if not same then create new  
            //     if ($this->hasChanges($currentProfile, $profileData)) {
            //         $currentProfile->update(['valid_until' => now(), 'is_current' => false]);
            //         $newProfile = $this->profileRepository->create($profileData);
            //         $profileId = $newProfile->id;
            //     } else {
            //         $profileId = $currentProfile->id;
            //     }
            // } else {
            //     // dd($profileData);
            //     $newProfile = $this->profileRepository->create($profileData);
            //     $profileId = $newProfile->id;
            // }

            // $application = $this->applicationRepository->create([
            //     'student_id' => $studentId,
            //     'advertisement_id' => $advertisementId,
            //     'advertisement_program_id' => $data['advertisement_program_id'],
            //     'student_profile_id' => $profileId,
            //     'application_number' => 'APP' . time(),
            //     'status' => 'draft'
            // ]);

            DB::commit();
            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Application start failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function hasChanges($currentProfile, $newData)
    {
        return collect($currentProfile->toArray())->except(['id', 'created_at', 'updated_at'])
            ->diffAssoc($newData)
            ->isNotEmpty();
    }

    private function prepareProfileData($data)
    {
        return array_merge($data, [
            'valid_from' => now(),
            'is_current' => true
        ]);
    }

    // public function saveStep2($applicationId, array $data)
    // {
    //     // dd($data);
    //     try {
    //         \DB::beginTransaction();

    //         // Save Addresses
    //         foreach ($data['addresses'] as $address) {
    //             $address['application_id'] = $applicationId;
    //             $this->addressRepository->createOrUpdate($address, $applicationId);
    //         }

    //         // Save Academic Qualifications
    //         foreach ($data['academic_qualifications'] as $academic) {
    //             $academic['application_id'] = $applicationId;
    //             $this->academicRepository->createOrUpdate($academic, $applicationId);
    //         }

    //         \DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         \DB::rollBack();
    //         \Log::error('Step 2 save failed: ' . $e->getMessage());
    //         throw $e;
    //     }
    // }

    public function saveStep2($applicationId, array $data)
    {
        try {
            DB::beginTransaction();
    
            // Fetch existing records
            $existingAddresses = $this->addressRepository->getByApplicationId($applicationId);
            $existingAcademics = $this->academicRepository->getByApplicationId($applicationId);
    
            // Process Addresses
            $submittedAddressIds = array_filter(array_column($data['addresses'], 'id')); // Filter out null/empty IDs
            foreach ($existingAddresses as $existing) {
                if (!in_array($existing->id, $submittedAddressIds)) {
                    $this->addressRepository->delete($existing->id); // Delete removed addresses
                }
            }
            foreach ($data['addresses'] as $address) {
                $address['application_id'] = $applicationId;
                $this->addressRepository->createOrUpdate($address, $applicationId);
            }
    
            // Process Academic Qualifications
            $submittedAcademicIds = array_filter(array_column($data['academic_qualifications'], 'id'));
            foreach ($existingAcademics as $existing) {
                if (!in_array($existing->id, $submittedAcademicIds)) {
                    $this->academicRepository->delete($existing->id); // Delete removed academics
                }
            }
            foreach ($data['academic_qualifications'] as $academic) {
                $academic['application_id'] = $applicationId;
                $this->academicRepository->createOrUpdate($academic, $applicationId);
            }
    
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Step 2 save failed: ' . $e->getMessage());
            throw new \Exception('Failed to save step 2: ' . $e->getMessage());
        }
    }

    public function getAddressByApplicationId($applicationId){
        return $this->addressRepository->getByApplicationId($applicationId);
    }

    public function getAcademicByApplicationId($applicationId){
        return $this->academicRepository->getByApplicationId($applicationId);
    }

    // ./Step2 End

    public function saveStep3($applicationId, array $data)
    {
        try {
            \DB::beginTransaction();

            // Save Employment History
            if (isset($data['employment'])) {
                $employmentData = array_merge($data['employment'], ['application_id' => $applicationId]);
                $this->employmentRepository->createOrUpdate($employmentData, $applicationId);
            }

            // Save Current Enrollment
            if (isset($data['enrollment'])) {
                $enrollmentData = array_merge($data['enrollment'], ['application_id' => $applicationId]);
                $this->enrollmentRepository->createOrUpdate($enrollmentData, $applicationId);
            }

            // Save UPSC Attempts
            if (isset($data['upsc_attempts'])) {
                foreach ($data['upsc_attempts'] as $attempt) {
                    $attemptData = array_merge($attempt, [
                        'application_id' => $applicationId,
                        'student_id' => auth()->id()
                    ]);
                    $this->upscRepository->createOrUpdate($attemptData, $applicationId);
                }
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Step 3 save failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getEmploymentbyApplicationId($applicationId){
        return $this->employmentRepository->getByApplicationId($applicationId);
    }

    public function getEnrollmentbyApplicationId($applicationId){
        $this->enrollmentRepository->getByApplicationId($applicationId);
    }

    public function getUpscbyApplicationId($applicationId){
        return $this->upscRepository->getByApplicationId($applicationId);
    }

// 
    // public function saveEmploymentHistory(int $applicationId, array $data): EmploymentHistory
    // {
    //     try {
    //         DB::beginTransaction();
            
    //         $employmentData = array_merge($data, ['application_id' => $applicationId]);
    //         $existing = $this->employmentRepository->getByApplicationId($applicationId);
            
    //         $employment = $existing 
    //             ? $this->employmentRepository->update($existing->id, $employmentData)
    //             : $this->employmentRepository->create($employmentData);
                
    //         DB::commit();
    //         return $employment;
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error("Employment save failed: {$e->getMessage()}");
    //         throw $e;
    //     }
    // }

    public function saveEmploymentHistory(int $applicationId, array $data): \App\Models\EmploymentHistory
    {
        try {
            DB::beginTransaction();
            
            $employmentData = array_merge($data, ['application_id' => $applicationId]);
            $existing = $this->employmentRepository->getByApplicationId($applicationId);
            
            $employment = $existing 
                ? $this->employmentRepository->update($existing->id, $employmentData)
                : $this->employmentRepository->create($employmentData);
                
            DB::commit();
            return $employment;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Employment save failed: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Save or update the current enrollment for an application.
     *
     * @param int $applicationId
     * @param array $data
     * @return CurrentEnrollment
     * @throws Exception
     */
    public function saveCurrentEnrollment(int $applicationId, array $data): \App\Models\CurrentEnrollment
    {
        try {
            DB::beginTransaction();

            $enrollmentData = array_merge($data, ['application_id' => $applicationId]);
            $existing = $this->enrollmentRepository->getByApplicationId($applicationId);

            if ($existing) {
                // Update existing record
                $enrollment = $this->enrollmentRepository->update($existing->id, $enrollmentData);
            } else {
                // Create new record
                $enrollment = $this->enrollmentRepository->create($enrollmentData);
            }

            DB::commit();
            return $enrollment;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Current enrollment save failed for application ID {$applicationId}: {$e->getMessage()}");
            throw $e;
        }
    }

    public function manageUpscAttempts(int $applicationId, array $attempts): void
    {
        try {
            DB::beginTransaction();
            
            $existingAttempts = $this->upscRepository->getByApplicationId($applicationId)
                ->pluck('id')->toArray();
                
            $submittedIds = [];
            
            foreach ($attempts as $attemptData) {
                $attemptData['application_id'] = $applicationId;
                $attemptData['student_id'] = auth()->id();
                
                if (isset($attemptData['id']) && $attemptData['id']) {
                    $this->upscRepository->update($attemptData['id'], $attemptData);
                    $submittedIds[] = $attemptData['id'];
                } else {
                    $newAttempt = $this->upscRepository->create($attemptData);
                    $submittedIds[] = $newAttempt->id;
                }
            }

            // Delete removed attempts
            $toDelete = array_diff($existingAttempts, $submittedIds);
            foreach ($toDelete as $id) {
                $this->upscRepository->delete($id);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("UPSC attempts save failed: {$e->getMessage()}");
            throw $e;
        }
    }
}