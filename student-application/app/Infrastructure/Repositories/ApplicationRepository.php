<?php

// app/Infrastructure/Repositories/ApplicationRepository.php (Update if not already implemented)
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ApplicationRepositoryInterface;
use App\Models\Application;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function create(array $data)
    {
        return Application::create($data);
    }

    public function find($id)
    {
        return Application::find($id);
    }

    // ... other methods as needed ...
    
    // public function create(array $data)
    // {
    //     return Application::create($data);
    // }

    // public function find($id)
    // {
    //     return Application::find($id);
    // }

    public function update($id, array $data)
    {
        $application = Application::findOrFail($id);
        $application->update($data);
        return $application;
    }

    public function delete($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        return true;
    }

    // 
    // public function findApplications($id)
    // {
    //     return Application::find($id);
    // }

    public static function findApplications($studentId, $advertisementId)
    {
        return Application::where('student_id', $studentId)
            ->where('advertisement_id', $advertisementId)
            ->first();
    }
}