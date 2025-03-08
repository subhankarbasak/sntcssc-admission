<?php

// app/Domain/Services/ApplicationService.php
namespace App\Domain\Services;

use App\Domain\Repositories\ApplicationRepositoryInterface;
use App\Domain\Repositories\StudentProfileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Domain\Repositories\ApplicationAddressRepositoryInterface;
use App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface;

class ApplicationService
{
    private $applicationRepository;
    private $profileRepository;

    private $addressRepository;
    private $academicRepository;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        StudentProfileRepositoryInterface $profileRepository,
        ApplicationAddressRepositoryInterface $addressRepository,
        ApplicationAcademicQualificationRepositoryInterface $academicRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->profileRepository = $profileRepository;
        $this->addressRepository = $addressRepository;
        $this->academicRepository = $academicRepository;
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
}