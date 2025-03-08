<?php

// app/Domain/Repositories/ApplicationRepositoryInterface.php
namespace App\Domain\Repositories;

interface ApplicationRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}