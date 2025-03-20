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
        return Document::where('application_id', $applicationId)
            ->select('id', 'application_id', 'type', 'file_path', 'verification_status', 'uploaded_at')
            ->get();
    }

    public function update($id, array $data)
    {
        $document = Document::findOrFail($id);
        $document->update($data);
        return $document;
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        return $document->delete();
    }

    // Add this method
    public function find($id)
    {
        return Document::find($id);
    }
}