<?php

// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
    // If already authenticated, redirect to dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        // Otherwise, show login form
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        

        try {
            
            \Log::info('Login attempt with email: ' . $credentials['email']);

            // if (Auth::attempt($credentials)) {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();

                \Log::info('Login successful for: ' . $credentials['email']);
                
                return redirect()->route('dashboard')
                    ->with('toastr', ['type' => 'success', 'message' => 'Logged in successfully!']);
            }

            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Invalid credentials']);
        } catch (\Exception $e) {
            \Log::error('Login failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Login failed']);
        }
    }

    // public function logout(Request $request)
    // {
    //     // Auth::logout();
    //     Auth::guard('web')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/')
    //         ->with('toastr', ['type' => 'success', 'message' => 'Logged out successfully!']);
    // }

    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
    
            // Set the Toastr message before invalidating the session
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => 'Logged out successfully!'
            ]);
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Logout Error: ' . $e->getMessage());
    
            return redirect()->back()
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'Error occurred while logging out. Please try again.'
                ]);
        }
    }
}