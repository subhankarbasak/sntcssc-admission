<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicationsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Application::query()
            ->join('students', 'applications.student_id', '=', 'students.id')
            ->join('student_profiles', 'applications.student_profile_id', '=', 'student_profiles.id')
            ->leftJoin('application_addresses', 'applications.id', '=', 'application_addresses.application_id')
            ->with(['student', 'studentProfile', 'addresses']);

        if ($this->request->filled('date_from')) {
            $query->whereDate('applied_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $query->whereDate('applied_at', '<=', $this->request->date_to);
        }
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        if ($this->request->filled('district')) {
            $query->where('application_addresses.district', $this->request->district);
        }
        if ($this->request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $search = '%' . $this->request->search . '%';
                $q->where('applications.application_number', 'like', $search)
                  ->orWhere('students.email', 'like', $search)
                  ->orWhere('student_profiles.mobile', 'like', $search)
                  ->orWhereRaw("CONCAT(student_profiles.first_name, ' ', student_profiles.last_name) LIKE ?", [$search]);
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Application #',
            'Full Name',
            'Email',
            'Phone',
            'District',
            'Status',
            'Applied Date'
        ];
    }

    public function map($application): array
    {
        $district = $application->addresses->first()->district ?? 'N/A';
        return [
            $application->application_number,
            $application->student_profile->first_name . ' ' . $application->student_profile->last_name,
            $application->student->email,
            $application->student_profile->mobile,
            $district,
            ucfirst($application->status),
            $application->applied_at->format('Y-m-d H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E5E5E5']]],
            'A' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}