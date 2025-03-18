<?php
// app/Http/Controllers/Auth/StudentForgotPasswordController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class StudentForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.student.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:students,email'
            ]);

            $token = Str::random(64);

            DB::beginTransaction();

            DB::table('student_password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );

            $student = Student::where('email', $request->email)->first();

            Mail::send('emails.student.password-reset', [
                'token' => $token,
                'student' => $student
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Your Password');
            });

            DB::commit();

            Log::info('Password reset link sent successfully', ['email' => $request->email]);

            return back()->with('success', 'We have emailed you a password reset link!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to send password reset link', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send reset link. Please try again later.');
        }
    }

    public function showResetForm($token)
    {
        try {
            $reset = DB::table('student_password_reset_tokens')
                ->where('token', $token)
                ->first();

            if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
                Log::warning('Invalid or expired password reset token attempted', ['token' => $token]);
                return redirect()->route('student.password.request')
                    ->with('error', 'This password reset token is invalid or has expired.');
            }

            return view('auth.student.reset-password', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('Error showing password reset form', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('student.password.request')
                ->with('error', 'Something went wrong. Please request a new reset link.');
        }
    }

    public function reset(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            DB::beginTransaction();

            $reset = DB::table('student_password_reset_tokens')
                ->where('token', $request->token)
                ->first();

            if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
                DB::rollBack();
                Log::warning('Invalid or expired token used for password reset', [
                    'token' => $request->token
                ]);
                return back()->with('error', 'Invalid or expired token');
            }

            $student = Student::where('email', $reset->email)->first();
            if (!$student) {
                DB::rollBack();
                Log::error('Student not found for password reset', ['email' => $reset->email]);
                return back()->with('error', 'Student not found');
            }

            $student->update([
                'password' => bcrypt($request->password)
            ]);

            DB::table('student_password_reset_tokens')->where('email', $reset->email)->delete();

            DB::commit();

            Log::info('Password reset successful', ['email' => $reset->email]);

            return redirect()->route('login')
                // ->with('success', 'Your password has been reset successfully!');
                ->with('toastr', ['type' => 'success', 'message' => 'Your password has been reset successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to reset password', [
                'token' => $request->token,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }
}