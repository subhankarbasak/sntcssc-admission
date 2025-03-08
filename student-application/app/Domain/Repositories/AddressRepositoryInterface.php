<?php

// app/Domain/Repositories/AddressRepositoryInterface.php
namespace App\Domain\Repositories;

interface AddressRepositoryInterface
{
    public function createOrUpdate(array $data, $studentId);
    public function getByStudentId($studentId);
}