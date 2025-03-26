@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filter Applications</h5>
            </div>
            <form method="GET" class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select rounded-3">
                            <option value="">All Payment Status</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under review" {{ request('payment_status') === 'under review' ? 'selected' : '' }}>Under Review</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Search</label>
                        <input type="text" name="search" class="form-control rounded-3" placeholder="Search by name, ID..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 rounded-3">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Applications Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Applications List</h5>
                <span class="badge bg-light text-dark">{{ $applications->total() }} Total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="ps-4">Sl No.</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">District</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment SS</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $key => $application)
                                <tr>
                                    <td class="ps-4">{{ $key + 1 }}</td>
                                    <td>{{ $application->application_number }}</td>
                                    <td>{{ $application->studentProfile?->first_name }} {{ $application->studentProfile?->last_name }}</td>
                                    <td>{{ $application->studentProfile?->email }}</td>
                                    <td>{{ $application->studentProfile?->mobile }}</td>
                                    <td>{{ $application->permanentAddress?->district }}</td>
                                    <td>
                                        <form action="{{ route('applications.update-status', $application) }}" method="POST" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm rounded-3 status-select">
                                                <option value="draft" {{ $application->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="submitted" {{ $application->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($application->payment)
                                            <form action="{{ route('applications.update-payment-status', $application->payment) }}" method="POST" class="status-form">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm rounded-3 status-select">
                                                    <option value="pending" {{ $application->payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="under review" {{ $application->payment->status === 'under review' ? 'selected' : '' }}>Under Review</option>
                                                    <option value="paid" {{ $application->payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="failed" {{ $application->payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->payment?->amount ?? 'N/A' }}</td>
                                    <td>
                                        @if ($application->documents->isNotEmpty())
                                            @if (app()->environment('live'))
                                            <a href="{{ url('public/storage/' . $application->documents->first()->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                                            @else
                                            <a href="{{ Storage::url($application->documents->first()->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                                            @endif
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('applications.show', $application) }}" 
                                           class="btn btn-sm btn-outline-secondary rounded-pill">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">No applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $applications->links('pagination::bootstrap-5') }}
        </div>
    </div>


@push('styles')
    <style>
        .card { border: none; border-radius: 10px; }
        .table th, .table td { vertical-align: middle; }
        .status-select { 
            min-width: 100px; 
            padding: 0.25rem 0.5rem; 
            font-size: 0.875rem; 
            background-color: #f8f9fa; 
            border-color: #ced4da; 
        }
        .status-select:focus { box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); }
        .table-hover tbody tr:hover { background-color: #f1f3f5; }
        .btn-outline-primary, .btn-outline-secondary { 
            transition: all 0.2s ease; 
        }
        .btn-outline-primary:hover, .btn-outline-secondary:hover { 
            transform: translateY(-1px); 
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                if (confirm('Are you sure you want to update the status?')) {
                    this.closest('.status-form').submit();
                }
            });
        });
    </script>
@endpush
@endsection