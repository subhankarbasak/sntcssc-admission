<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Application;
use App\Models\ApplicationAddress;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        try {
            $stats = Cache::remember('admin_dashboard_stats', 1800, function () {
                return [
                    'total_students' => Student::count(),
                    'status_counts' => Application::groupBy('status')
                        ->selectRaw('status, count(*) as count')
                        ->pluck('count', 'status')
                        ->all(),
                    'districts' => ApplicationAddress::distinct()
                        ->pluck('district')
                        ->filter()
                        ->sort()
                        ->values()
                        ->all()
                ];
            });
    
            $perPage = $request->input('per_page', 10);
            
            // Use a subquery to get only one address per application
            $applicationsQuery = Application::query()
                ->join('students', 'applications.student_id', '=', 'students.id')
                ->join('student_profiles', 'applications.student_profile_id', '=', 'student_profiles.id')
                ->leftJoin('application_addresses', function ($join) {
                    $join->on('applications.id', '=', 'application_addresses.application_id')
                         ->where('application_addresses.type', '=', 'permanent') // Adjust type as needed
                        //  ->where('application_addresses.is_verified', '=', true) // Optional: filter by verified
                         ->orderBy('application_addresses.id', 'asc') // Ensure consistent ordering
                         ->limit(1); // Limit to one address
                })
                ->select(
                    'applications.id as application_id',
                    'applications.status',
                    'applications.payment_status',
                    'applications.applied_at',
                    'applications.application_number',
                    'students.email',
                    'student_profiles.first_name',
                    'student_profiles.last_name',
                    'student_profiles.mobile',
                    'application_addresses.district'
                )
                ->with(['student', 'studentProfile', 'addresses'])
                ->distinct('applications.id'); // Ensure unique applications
    
            $this->applyFilters($applicationsQuery, $request);
    
            $sortBy = $request->input('sort_by', 'applied_at');
            $sortDir = $request->input('sort_dir', 'desc');
            $validSortColumns = ['application_number', 'applied_at', 'status', 'district'];
            $sortBy = in_array($sortBy, $validSortColumns) ? $sortBy : 'applied_at';
            $applicationsQuery->orderBy($sortBy, $sortDir);
    
            $applications = $applicationsQuery->paginate($perPage)->withQueryString();
    
            $chartData = $this->getChartData();
    
            return view('admin.dashboard', [
                'totalStudents' => $stats['total_students'],
                'applications' => $applications,
                'districts' => $stats['districts'],
                'statusCounts' => $stats['status_counts'],
                'perPage' => $perPage,
                'chartData' => $chartData,
                'sortBy' => $sortBy,
                'sortDir' => $sortDir
            ]);
        } catch (\Exception $e) {
            Log::error('Dashboard loading failed: ' . $e->getMessage());
            return back()->withError('An error occurred while loading the dashboard');
        }
    }

    private function applyFilters($query, Request $request)
    {
        $query->when($request->filled('date_from'), fn($q) => 
            $q->whereDate('applied_at', '>=', $request->date_from));
        
        $query->when($request->filled('date_to'), fn($q) => 
            $q->whereDate('applied_at', '<=', $request->date_to));
        
        $query->when($request->filled('status'), fn($q) => 
            $q->where('applications.status', $request->status));
        
        $query->when($request->filled('district'), fn($q) => 
            $q->where('application_addresses.district', $request->district));
        
        $query->when($request->filled('search'), fn($q) => 
            $q->where(function ($q) use ($request) {
                $search = '%' . $request->search . '%';
                $q->where('applications.application_number', 'like', $search)
                  ->orWhere('students.email', 'like', $search)
                  ->orWhere('student_profiles.mobile', 'like', $search)
                  ->orWhereRaw("CONCAT(student_profiles.first_name, ' ', student_profiles.last_name) LIKE ?", [$search]);
            }));
    }

    private function getChartData()
    {
        return Cache::remember('application_chart_data', 3600, function () {
            $data = Application::select(
                    DB::raw('DATE(applied_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('applied_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->all();

            $dates = [];
            $counts = [];
            $currentDate = now()->subDays(30)->startOfDay();
            $endDate = now()->startOfDay();

            while ($currentDate <= $endDate) {
                $dateStr = $currentDate->format('Y-m-d');
                $dates[] = $dateStr;
                $counts[] = $data[$dateStr] ?? 0;
                $currentDate->addDay();
            }

            return ['dates' => $dates, 'counts' => $counts];
        });
    }

    public function export(Request $request)
    {
        try {
            $export = new ApplicationsExport($request);
            $fileName = 'applications_' . now()->format('Y-m-d_H-i') . '.xlsx';
            
            // Test if query returns data
            $data = $export->query()->get();
            if ($data->isEmpty()) {
                return back()->withError('No data available to export');
            }
    
            return Excel::download($export, $fileName);
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withError('Failed to export applications: ' . $e->getMessage());
        }
    }

    public function bulkUpdate(Request $request)
    {
        try {
            $request->validate([
                'application_ids' => 'required|array',
                'status' => 'required|in:submitted,approved,rejected'
            ]);

            DB::beginTransaction();
            $updated = Application::whereIn('id', $request->application_ids)
                ->update(['status' => $request->status, 'updated_at' => now()]);
            DB::commit();

            Cache::forget('admin_dashboard_stats');
            Cache::forget('application_chart_data');

            return redirect()->back()
                ->with('success', "$updated applications updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk update failed: ' . $e->getMessage());
            return back()->withError('Failed to update applications');
        }
    }
}