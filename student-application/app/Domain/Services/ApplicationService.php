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
use App\Domain\Repositories\DocumentRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use App\Domain\Repositories\PaymentRepositoryInterface;

class ApplicationService
{
    private $applicationRepository;
    private $profileRepository;

    private $addressRepository;
    private $academicRepository;

    private $employmentRepository;
    private $enrollmentRepository;
    private $upscRepository;
    private $documentRepository;
    private $paymentRepository;

    public function __construct(
        ApplicationRepositoryInterface $applicationRepository,
        StudentProfileRepositoryInterface $profileRepository,
        ApplicationAddressRepositoryInterface $addressRepository,
        ApplicationAcademicQualificationRepositoryInterface $academicRepository,
        EmploymentHistoryRepositoryInterface $employmentRepository,
        CurrentEnrollmentRepositoryInterface $enrollmentRepository,
        UpscAttemptRepositoryInterface $upscRepository,
        DocumentRepositoryInterface $documentRepository,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->profileRepository = $profileRepository;
        $this->addressRepository = $addressRepository;
        $this->academicRepository = $academicRepository;
        $this->employmentRepository = $employmentRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->upscRepository = $upscRepository;
        $this->documentRepository = $documentRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function startApplication($studentId, $advertisementId, array $data)
    {
        // dd($data);
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

                    'cat_cert_no' => $data['cat_cert_no'],
                    'cat_issue_date' => $data['cat_issue_date'],
                    'cat_issue_by' => $data['cat_issue_by'],
                    'highest_qualification' => $data['highest_qualification'],

                    'student_profile_id' => $profileId,
                    'application_number' => 'APP' . time(),
                    'status' => 'draft',

                    'optional_subject' => $data['optional_subject'],
                    'is_appearing_upsc_cse' => $data['is_appearing_upsc_cse'],
                    'upsc_attempts_count' => $data['upsc_attempts_count']
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
                    'cat_cert_no' => $profileData['cat_cert_no'],
                    'cat_issue_date' => $profileData['cat_issue_date'],
                    'cat_issue_by' => $profileData['cat_issue_by'],
                    'highest_qualification' => $profileData['highest_qualification'],
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

    // ./ End Step 3 Here
    public function saveStep4($application, array $files)
    {
        $applicationId = $application->id;
        try {
            DB::beginTransaction();
    
            $existingDocs = $this->getDocuments($applicationId);
    
            foreach ($files as $type => $file) {
                $existing = $existingDocs->where('type', $type)->first();
                // Generate custom filename: applicationId_photo_timestamp.extension
                $timestamp = now()->format('YmdHis'); // e.g., 20250314123456
                $extension = $file->getClientOriginalExtension(); // Get file extension
                $customFileName = "{$application->application_number}_{$type}_{$timestamp}.{$extension}";
                $path = 'documents/' . $application->application_number . '/' . $customFileName;
    
                if ($existing) {
                    // Update existing document
                    Storage::disk('public')->delete($existing->file_path); // Delete old file
                    $file->storeAs('documents/' . $application->application_number, $customFileName, 'public');
    
                    $this->documentRepository->update($existing->id, [
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'file_mime' => $file->getMimeType(),
                        'verification_status' => 'pending',
                        'uploaded_at' => now()
                    ]);
                } else {
                    // Create new document
                    $file->storeAs('documents/' . $application->application_number, $customFileName, 'public');
                    $this->documentRepository->create([
                        'application_id' => $applicationId,
                        'type' => $type,
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'file_mime' => $file->getMimeType(),
                        'verification_status' => 'pending',
                        'uploaded_at' => now()
                    ]);
                }
            }
    
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Step 4 save failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function getDocuments($applicationId)
    {
        return $this->documentRepository->getByApplicationId($applicationId);
    }
    // ./End Step 4

    // Start Step 5
    public function submitApplication($applicationId)
    {
        // dd($applicationId);
        try {
            \DB::beginTransaction();

            $application = $this->applicationRepository->find($applicationId);
            if (!$application) {
                throw new \Exception('Application not found');
            }

            // Validate all required steps are completed
            $this->validateApplicationCompletion($applicationId);

            // Update application status
            $application->update([
                'status' => 'submitted',
                'applied_at' => now()
            ]);

            \DB::commit();
            return $application;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Application submission failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function validateApplicationCompletion($applicationId)
    {
        $requiredDocs = ['photo', 'signature'];
        $documents = $this->documentRepository->getByApplicationId($applicationId);
        $docTypes = $documents->pluck('type')->toArray();

        foreach ($requiredDocs as $type) {
            if (!in_array($type, $docTypes)) {
                throw new \Exception("Missing required document: {$type}");
            }
        }

        $addresses = $this->addressRepository->getByApplicationId($applicationId);
        if ($addresses->count() < 2) {
            throw new \Exception('Both present and permanent addresses are required');
        }

        $academics = $this->academicRepository->getByApplicationId($applicationId);
        $requiredLevels = ['Secondary', 'Higher Secondary'];
        $levels = $academics->pluck('level')->toArray();
        foreach ($requiredLevels as $level) {
            if (!in_array($level, $levels)) {
                throw new \Exception("Missing required academic qualification: {$level}");
            }
        }
    }

    public function getApplicationDetails($applicationId)
    {
        $application = $this->applicationRepository->find($applicationId);
        return [
            'profile' => $application->profile,
            'addresses' => $this->addressRepository->getByApplicationId($applicationId),
            'academics' => $this->academicRepository->getByApplicationId($applicationId),
            'employment' => $this->employmentRepository->getByApplicationId($applicationId),
            'enrollment' => $this->enrollmentRepository->getByApplicationId($applicationId),
            'upsc_attempts' => $this->upscRepository->getByApplicationId($applicationId),
            'documents' => $this->documentRepository->getByApplicationId($applicationId),
            'application' => $application
        ];
    }

    // ./ Submit Application End

    // Payment process step starts
    public function processPayment($application, array $paymentData, $screenshot = null)
    {
        $applicationId = $application->id;
        try {
            \DB::beginTransaction();
    
            $application = $this->applicationRepository->find($applicationId);
            if (!$application || $application->status !== 'submitted') {
                throw new \Exception('Application not eligible for payment');
            }
    
            $screenshotId = null;
            if ($screenshot) {
                // Generate custom filename
                $timestamp = now()->format('YmdHis'); // e.g., 20250314123456
                $randomString = \Str::random(6); // e.g., X7K9P2
                $customFileName = "{$application->application_number}_payment_{$timestamp}_{$randomString}";
    
                // Get the original file extension
                $extension = $screenshot->getClientOriginalExtension();
    
                // Store the file with the custom name
                $path = $screenshot->storeAs('documents/payments', "{$customFileName}.{$extension}", 'public');
    
                $document = $this->documentRepository->create([
                    'application_id' => $applicationId,
                    'type' => 'payment_ss',
                    'file_path' => $path,
                    'verification_status' => 'pending'
                ]);
                $screenshotId = $document->id;
            }
    
            $paymentData = array_merge($paymentData, [
                'application_id' => $applicationId,
                'screenshot_document_id' => $screenshotId,
                'status' => 'pending'
            ]);
    
            $payment = $this->paymentRepository->create($paymentData);
    
            // Update application payment status
            $application->update(['payment_status' => 'pending']);
    
            \DB::commit();
            return $payment;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Payment processing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getPaymentDetails($applicationId)
    {
        $payment = $this->paymentRepository->findByApplicationId($applicationId);
        return $payment;
    }
}