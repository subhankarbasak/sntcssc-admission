<?php

// app/Domain/Repositories/DocumentRepositoryInterface.php
namespace App\Domain\Repositories;

interface DocumentRepositoryInterface
{
    public function create(array $data);
    public function getByApplicationId($applicationId);
    public function update($id, array $data);
}