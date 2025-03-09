<?php

// app/Infrastructure/Repositories/DocumentRepository.php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\DocumentRepositoryInterface;
use App\Models\Document;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function create(array $data)
    {
        return Document::create($data);
    }

    public function getByApplicationId($applicationId)
    {
        return Document::where('application_id', $applicationId)->get();
    }

    public function update($id, array $data)
    {
        $document = Document::findOrFail($id);
        $document->update($data);
        return $document;
    }
}