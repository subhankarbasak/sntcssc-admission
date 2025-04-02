<?php

namespace App\Http\Controllers;

use App\Models\Unsubscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnsubscribeController extends Controller
{
    public function index(Request $request)
    {
        // Validate the email and optional type from the query string
        $request->validate([
            'email' => 'required|email',
            'type' => 'nullable|string|in:registration,login,application_status,payment_status,status', // Add more types as needed
        ]);

        $email = $request->query('email');
        $emailType = $request->query('type', 'unknown'); // Default to 'unknown' if not provided

        try {
            // Check if already unsubscribed
            if (Unsubscribe::where('email', $email)->exists()) {
                return view('unsubscribe.success', [
                    'message' => 'You have already unsubscribed from our emails.',
                    'email' => $email,
                ]);
            }

            // Record the unsubscribe
            Unsubscribe::create([
                'email' => $email,
                'email_type' => ($emailType === 'status') ? 'application_status' : $emailType,
                'ip_address' => $request->ip(),
            ]);

            Log::info('User unsubscribed', [
                'email' => $email,
                'email_type' => $emailType,
                'ip_address' => $request->ip(),
            ]);

            return view('unsubscribe.success', [
                'message' => 'You have successfully unsubscribed from our emails.',
                'email' => $email,
            ]);
        } catch (\Exception $e) {
            Log::error('Unsubscribe failed: ' . $e->getMessage());
            return view('unsubscribe.error', [
                'message' => 'There was an error processing your request. Please try again later.',
            ]);
        }
    }
}