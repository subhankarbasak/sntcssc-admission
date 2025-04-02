<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Application;
use App\Models\ApplicationAddress;
use App\Models\ApplicationAcademicQualification;
use App\Models\EmploymentHistory;
use App\Models\CurrentEnrollment;
use App\Models\UpscAttempt;
use App\Models\Document;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Domain\Services\ApplicationService;

class ApplicationDownloadController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'admin']);
    }


    public function getApplicationDetails($applicationId)
    {
        $application = Application::findOrFail($applicationId);
        return [
            'profile' => $application->profile,
            'addresses' => ApplicationAddress::where('application_id', $applicationId)->get(),
            'academics' => ApplicationAcademicQualification::where('application_id', $applicationId)->get(),
            'employment' => EmploymentHistory::where('application_id', $applicationId)->first(),
            'enrollment' => CurrentEnrollment::where('application_id', $applicationId)->first(),
            'upsc_attempts' => UpscAttempt::where('application_id', $applicationId)->get(),
            'documents' => Document::where('application_id', $applicationId)->select('id', 'application_id', 'type', 'file_path', 'verification_status', 'uploaded_at')->get(),
            'application' => $application
        ];
    }

    public function download(Application $application)
    {
        
        $applicationId = $application->id;
        // dd($applicationId);
        // $application = Application::findOrFail($applicationId);

        
        try {
            $application = Application::with([
                'advertisement',
                'profile',
                'payment',
                'payment.screenshot'
            ])->findOrFail($applicationId);

            // if ($application->student_id !== auth()->id()) {
            //     abort(403, 'Unauthorized access to this application');
            // }

            $details = $this->getApplicationDetails($applicationId);
            // $logoPath = public_path('images/logo.png');
            $logoPath = 'images/logo.png';
            // dd($logoPath);

            // Prepare image data with fallback
            $photo = $details['documents']->where('type', 'photo')->first();
            $signature = $details['documents']->where('type', 'signature')->first();

            $photo_base64 = $this->processImage($photo?->file_path, 150, 150);
            $signature_base64 = $this->processImage($signature?->file_path, 200, 80);
            // $photo_base64 = $this->processImage($photo?->file_path, 100, 100); // Reduced from 150x150
            // $signature_base64 = $this->processImage($signature?->file_path, 150, 60); // Reduced from 200x80
            $logo_base64 = $this->processImage($logoPath, 200, 200, false);

            $data = [
                'application' => $application,
                'details' => $details,
                'photo_base64' => $photo_base64,
                'signature_base64' => $signature_base64,
                'logo_base64' => $logo_base64,
                'institute_name' => 'Satyendra Nath Tagore Civil Services Study Centre',
                'institute_type' => 'Government of West Bengal',
                'institute_address' => 'NSATI Campus, FC Block, Sector-III, Salt Lake, Kolkata-700106'
            ];

            $pdf = PDF::loadView('applications.pdf', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'dpi' => 96 // Optimize for faster rendering
                ]);

            return $pdf->download('application_' . $application->application_number . '.pdf');
            // return $pdf->stream();
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            abort(500, 'Unable to generate PDF. Please try again later.');
        }
    }

    private function processImage(?string $filePath, int $maxWidth, int $maxHeight, bool $useStorage = true): ?string
    {
        try {
            // Resolve full path based on storage type
            // $fullPath = $useStorage && $filePath 
            //     ? Storage::path($filePath) 
            //     : $filePath;

            $fullPath = storage_path('app/public/' . $filePath);

                // \URL::to(Storage::disk()->url($filePath))

            if (!$fullPath || !file_exists($fullPath)) {
                Log::warning("Image not found at path: {$fullPath}");
                return null;
            }

            $image = @imagecreatefromstring(file_get_contents($fullPath));
            if ($image === false) {
                Log::warning("Failed to create image from: {$fullPath}");
                return null;
            }

            // Get original dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Calculate new dimensions maintaining aspect ratio
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = max(1, (int)($width * $ratio));  // Ensure minimum 1px
            $newHeight = max(1, (int)($height * $ratio));

            // Create optimized image
            $optimized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNG
            imagealphablending($optimized, false);
            imagesavealpha($optimized, true);

            imagecopyresampled(
                $optimized, 
                $image, 
                0, 0, 0, 0, 
                $newWidth, 
                $newHeight, 
                $width, 
                $height
            );

            // Output to buffer
            ob_start();
            imagejpeg($optimized, null, 75); // 75% quality
            $data = ob_get_clean();

            // Clean up
            imagedestroy($image);
            imagedestroy($optimized);

            return base64_encode($data);
        } catch (\Exception $e) {
            Log::error("Image processing failed for {$filePath}: " . $e->getMessage());
            return null;
        }
    }
}