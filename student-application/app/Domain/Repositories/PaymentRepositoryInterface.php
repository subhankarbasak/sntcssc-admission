<?php

// app/Domain/Repositories/PaymentRepositoryInterface.php
namespace App\Domain\Repositories;

interface PaymentRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function findByApplicationId($applicationId);
}