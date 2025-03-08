<?php

// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStep1Request;
use App\Domain\Services\ApplicationService;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function create($advertisementId)
    {
        // Enable query logging
        \DB::enableQueryLog();

        $advertisement = Advertisement::with('programs')->findOrFail($advertisementId);
        $student = Auth::user();
        // $profile = $student->profiles()->where('is_current', true)->first();
        // 
        $application = $student->applications()
        ->where('advertisement_id', $advertisementId)
        ->first();
        
        // dd($application);
        if($application === null){
            // dd('No rows found Means Need to Create');
            // If no application record was found of that advertisement Id, that means applying for first time and will be create, not update
            $profile = $student->profiles()->where('is_current', true)->first();
        }else{
            // dd('Rows found Means need to Update');
            $profile = $student->profiles()->where('id', $application->student_profile_id)->first();
            // dd($profile);
        }
        // dd($application);
        
        // dd($advertisement->programs);


        // Get the logged queries
        $queries = \DB::getQueryLog();
    
        // dd($advertisement); // Output all executed queries

        return view('applications.step1', compact('advertisement', 'student', 'profile', 'application'));
    }

    public function storeStep1(ApplicationStep1Request $request, $advertisementId)
    {
        try {
            $application = $this->applicationService->startApplication(
                Auth::id(),
                $advertisementId,
                $request->validated()
            );

            return redirect()->route('application.step2', $application->id)
                ->with('toastr', ['type' => 'success', 'message' => 'Step 1 completed!']);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Failed to save step 1']);
        }
    }
}