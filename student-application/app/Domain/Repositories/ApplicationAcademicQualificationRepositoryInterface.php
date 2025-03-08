<?php

// app/Domain/Repositories/ApplicationAcademicQualificationRepositoryInterface.php
namespace App\Domain\Repositories;

interface ApplicationAcademicQualificationRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId);
    public function getByApplicationId($applicationId);
}