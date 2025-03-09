<?php

// app/Infrastructure/Repositories/PaymentRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\PaymentRepositoryInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function update($id, array $data)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data);
        return $payment;
    }

    public function findByApplicationId($applicationId)
    {
        return Payment::where('application_id', $applicationId)->first();
    }
}