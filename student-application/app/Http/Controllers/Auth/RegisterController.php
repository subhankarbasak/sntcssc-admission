<?php

// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRegistrationRequest;
use App\Http\Requests\RegisterRequest;
use App\Domain\Services\StudentService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        // $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) //StudentRegistrationRequest
    {
        // dd($request);
        try {
            $student = $this->studentService->register($request->validated());
            
            // Auth::loginUsingId($student->id);
            // Auth::guard('student')->login($student);
            Auth::guard('web')->login($student);
            $request->session()->regenerate();
            \Log::info('Login successful for: ' . $student->first_name);
            
            return redirect()->route('dashboard')
                ->with('toastr', ['type' => 'success', 'message' => 'Registration successful!']);
        } catch (\Exception $e) {
            // return back()
            //     ->withInput()
            //     ->with('toastr', ['type' => 'error', 'message' => 'Registration failed!']);

            return redirect()->back()
            ->withInput()
            ->with('toastr', [
                'type' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
        }
    }

    // Add these new validation methods
    public function validateSecondaryRoll(Request $request)
    {
        $exists = Student::where('secondary_roll', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function validateEmail(Request $request)
    {
        $exists = Student::where('email', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function validateMobile(Request $request)
    {
        $exists = Student::where('mobile', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }
}