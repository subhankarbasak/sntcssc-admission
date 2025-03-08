<?php

// app/Domain/Repositories/StudentProfileRepositoryInterface.php
namespace App\Domain\Repositories;

interface StudentProfileRepositoryInterface
{
    public function create(array $data);
    public function getCurrentProfile($studentId);
    public function update($id, array $data);
}