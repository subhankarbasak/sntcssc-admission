<?php

// app/Domain/Services/StudentService.php
namespace App\Domain\Services;

use App\Domain\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use App\Domain\Entities\Student;
use App\Models\Student;

use App\Domain\Repositories\StudentProfileRepositoryInterface;
// use App\Domain\Repositories\ApplicationAddressRepositoryInterface;
// use App\Domain\Repositories\ApplicationAcademicQualificationRepositoryInterface;
// Student Address
use App\Domain\Repositories\AddressRepositoryInterface;
use App\Domain\Repositories\AcademicQualificationRepositoryInterface;

class StudentService
{
    private $studentRepository;
    private $profileRepository;
    private $addressRepository;
    private $academicRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
        StudentProfileRepositoryInterface $profileRepository,
        // ApplicationAddressRepositoryInterface $addressRepository,
        // ApplicationAcademicQualificationRepositoryInterface $academicRepository
        // For Students Address
        AddressRepositoryInterface $addressRepository,
        AcademicQualificationRepositoryInterface $academicRepository
    
    )
    {
        $this->studentRepository = $studentRepository;
        $this->profileRepository = $profileRepository;
        $this->addressRepository = $addressRepository;
        $this->academicRepository = $academicRepository;
    }

    public function register(array $data): Student
    {
        try {
            DB::beginTransaction();
            
            // $studentData = array_merge($data, [
            //     'uuid' => \Str::uuid(),
            //     'password' => bcrypt($data['password'])
            // ]);
            
            // $student = $this->studentRepository->create($studentData);

// Create Student
            // $studentData = [
            //     'first_name' => $data['first_name'],
            //     'last_name' => $data['last_name'],
            //     'email' => $data['email'],
            //     'password' => bcrypt($data['password']),
            // ];
            $studentData = array_merge($data, [
                'uuid' => \Str::uuid(),
                'password' => bcrypt($data['password'])
            ]);
            
            $student = $this->studentRepository->create($studentData);
            // dd($student->id);

            // Create Student Profile
            $profileData = [
                'student_id' => $student->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'dob' => $data['dob'],
                'gender' => $data['gender'],
                'category' => $data['category'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'secondary_roll' => $data['secondary_roll'],
                'cat_cert_no' => $data['cat_cert_no'],
                'cat_issue_date' => $data['cat_issue_date'],
                'cat_issue_by' => $data['cat_issue_by'],
                'highest_qualification' => $data['highest_qualification'],
                'valid_from' => now(),
                'is_current' => true,
            ];
            $this->profileRepository->create($profileData);

            // Create Addresses
            foreach ($data['addresses'] as $address) {
                $address['student_id'] = $student->id; // Assuming we add student_id to ApplicationAddress
                $this->addressRepository->createOrUpdate($address, null); // null application_id for registration
            }

            // Create Academic Qualifications
            foreach ($data['academic_qualifications'] as $academic) {
                $academic['student_id'] = $student->id; // Assuming we add student_id to ApplicationAcademicQualification
                $this->academicRepository->createOrUpdate($academic, null); // null application_id for registration
            }
            
            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student registration failed: ' . $e->getMessage());
            throw $e;
        }
    }
}