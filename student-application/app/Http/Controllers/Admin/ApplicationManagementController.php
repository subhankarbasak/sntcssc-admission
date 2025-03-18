<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use App\Mail\ApplicationStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplicationManagementController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('can:manage-applications');
    }

    public function index(Request $request)
    {
        try {
            $query = Application::with([
                'studentProfile',
                'payment',
                'permanentAddress',
                'documents' => fn($q) => $q->where('type', 'payment_ss')
            ]);

            // Apply filters
            if ($request->status) {
                $query->byStatus($request->status);
            }

            if ($request->payment_status) {
                $query->byPaymentStatus($request->payment_status);
            }

            if ($request->search) {
                $query->search($request->search);
            }

            $applications = $query->paginate(20);

            return view('admin.applications.index', compact('applications'));
        } catch (\Exception $e) {
            Log::error('Failed to load applications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load applications');
        }
    }

    public function updateStatus(Request $request, Application $application)
    {
        try {
            $request->validate([
                'status' => 'required|in:draft,submitted, approved,rejected'
            ]);

            DB::transaction(function () use ($application, $request) {
                $oldStatus = $application->status;
                $application->update([
                    'status' => $request->status
                ]);

                // Log the change
                Log::info('Application status updated', [
                    'application_id' => $application->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'updated_by' => auth()->id()
                ]);

                dd($application->studentProfile->email);

                // Send email notification
                if ($application->studentProfile->email) {
                    Mail::to($application->studentProfile->email)
                        ->send(new ApplicationStatusUpdated($application, 'status'));
                }
            });

            return redirect()->back()->with('success', 'Application status updated successfully');
        } catch (\Exception $e) {
            Log::error('Application status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update application status');
        }
    }

    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,paid,failed'
            ]);

            DB::transaction(function () use ($payment, $request) {
                $oldStatus = $payment->status;
                
                $payment->update([
                    'status' => $request->status
                ]);

                $payment->application->update([
                    'payment_status' => $request->status
                ]);

                // Log the change
                Log::info('Payment status updated', [
                    'payment_id' => $payment->id,
                    'application_id' => $payment->application->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'updated_by' => auth()->id()
                ]);

                // Send email notification
                if ($payment->application->studentProfile->email) {
                    Mail::to($payment->application->studentProfile->email)
                        ->send(new ApplicationStatusUpdated($payment->application, 'payment_status'));
                }
            });

            return redirect()->back()->with('success', 'Payment status updated successfully');
        } catch (\Exception $e) {
            Log::error('Payment status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update payment status');
        }
    }
}