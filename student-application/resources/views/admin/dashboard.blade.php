@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats and Chart -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <h2 class="text-primary">{{ $totalStudents }}</h2>
                </div>
            </div>
        </div>
        @foreach($statusCounts as $status => $count)
        <div class="col-md-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($status) }} Applications</h5>
                    <h2 class="{{ $status == 'approved' ? 'text-success' : ($status == 'pending' ? 'text-warning' : 'text-danger') }}">
                        {{ $count }}
                    </h2>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-md-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="applicationsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" id="filterForm" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="date" name="date_from" class="form-control" 
                            value="{{ request('date_from') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="date" name="date_to" class="form-control" 
                            value="{{ request('date_to') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach(['submitted', 'draft', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">District</label>
                        <select name="district" class="form-select">
                            <option value="">All Districts</option>
                            @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" 
                            value="{{ request('search') }}" placeholder="Search...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Per Page</label>
                        <select name="per_page" class="form-select">
                            @foreach([10, 25, 50, 100] as $count)
                            <option value="{{ $count }}" {{ $perPage == $count ? 'selected' : '' }}>
                                {{ $count }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Applications</h4>
            <div>
                <form action="{{ route('admin.export') }}" method="POST" class="d-inline" id="exportForm">
                    @csrf
                    @foreach(request()->except('_token') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" class="btn btn-success" id="exportBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Export to Excel
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <form id="bulkUpdateForm" method="POST" action="{{ route('admin.bulk-update') }}">
                @csrf
                <div class="mb-3">
                    <div class="input-group" style="width: auto;">
                        <select name="status" class="form-select">
                            @foreach(['submitted', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary" id="bulkUpdateBtn" disabled>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Update Selected
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>App #</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>District</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>
                                    <a href="{{ route('admin.dashboard', array_merge(request()->all(), ['sort_by' => 'applied_at', 'sort_dir' => $sortDir == 'desc' ? 'asc' : 'desc'])) }}"
                                        class="text-dark text-decoration-none">
                                        Applied Date 
                                        @if($sortBy == 'applied_at')
                                            <i class="fas fa-sort-{{ $sortDir == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $application)
                            <tr>
                                <td><input type="checkbox" name="application_ids[]" 
                                    value="{{ $application->application_id }}" class="application-checkbox"></td>
                                <td>{{ $applications->firstItem() + $index }}</td>
                                <td>{{ $application->application_number }}</td>
                                <td>{{ $application->first_name . ' ' . $application->last_name }}</td>
                                <td>{{ $application->email }}</td>
                                <td>{{ $application->mobile }}</td>
                                <td>{{ $application->district ?? $application->addresses->first()->district ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ ($application->status == 'approved' || $application->status == 'submitted') ? 'success' : ($application->status == 'draft' ? 'warning' : 'danger') }}"
                                        data-bs-toggle="tooltip" title="Last updated: {{ $application->updated_at }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $application->payment_status == 'paid' ? 'success' : ($application->payment_status == 'pending' ? 'warning' : 'danger') }}"
                                        data-bs-toggle="tooltip" title="Last updated: {{ $application->updated_at }}">
                                        {{ ucfirst($application->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $application->applied_at?->format('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No applications found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $applications->links('pagination::bootstrap-5') }}
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter form handling
    const filterForm = document.getElementById('filterForm');
    filterForm.querySelectorAll('select, input').forEach(element => {
        element.addEventListener('change', () => filterForm.submit());
    });

    // Bulk actions
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.application-checkbox');
    const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
    const bulkForm = document.getElementById('bulkUpdateForm');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        updateBulkButtonState();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButtonState);
    });

    function updateBulkButtonState() {
        const checkedCount = document.querySelectorAll('.application-checkbox:checked').length;
        bulkUpdateBtn.disabled = checkedCount === 0;
    }

    bulkForm.addEventListener('submit', function(e) {
        const spinner = bulkUpdateBtn.querySelector('.spinner-border');
        spinner.classList.remove('d-none');
        bulkUpdateBtn.disabled = true;
    });

    // Export handling
    const exportForm = document.getElementById('exportForm');
    const exportBtn = document.getElementById('exportBtn');
    exportForm.addEventListener('submit', function() {
        const spinner = exportBtn.querySelector('.spinner-border');
        spinner.classList.remove('d-none');
        exportBtn.disabled = true;
    });

    // Chart
    const ctx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['dates']),
            datasets: [{
                label: 'Applications',
                data: @json($chartData['counts']),
                borderColor: '#0d6efd',
                tension: 0.1,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Applications' } },
                x: { title: { display: true, text: 'Date' } }
            }
        }
    });

    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});
</script>
<style>
.card { transition: transform 0.2s; }
.card:hover { transform: translateY(-5px); }
.table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>
@endpush
@endsection