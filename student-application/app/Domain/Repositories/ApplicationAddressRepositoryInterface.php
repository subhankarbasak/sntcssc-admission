<?php

// app/Domain/Repositories/ApplicationAddressRepositoryInterface.php
namespace App\Domain\Repositories;

interface ApplicationAddressRepositoryInterface
{
    public function createOrUpdate(array $data, $applicationId);
    public function getByApplicationId($applicationId);
}