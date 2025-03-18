@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Filters -->
        <form method="GET" class="card p-4 mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Applications Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Sl No.</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>District</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Amount</th>
                                <th>Payment SS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $key => $application)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td>{{ $application->application_number }}</td>
                                    <td>{{ $application->studentProfile?->first_name }} {{ $application->studentProfile?->last_name }}</td>
                                    <td>{{ $application->studentProfile?->email }}</td>
                                    <td>{{ $application->studentProfile?->mobile }}</td>
                                    <td>{{ $application->permanentAddress?->district }}</td>
                                    <td>
                                        <form action="{{ route('applications.update-status', $application) }}" 
                                              method="POST" 
                                              onsubmit="return confirmStatusChange(this)">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select" onchange="this.form.submit()">
                                                <option value="draft" {{ $application->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="submitted" {{ $application->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($application->payment)
                                            <form action="{{ route('applications.update-payment-status', $application->payment) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirmStatusChange(this)">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select" onchange="this.form.submit()">
                                                    <option value="pending" {{ $application->payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ $application->payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="failed" {{ $application->payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $application->payment?->amount }}</td>
                                    <td>
                                        @if ($application->documents->isNotEmpty())
                                            <a href="{{ Storage::url($application->documents->first()->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-primary">View</a>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Additional actions if needed -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>

@push('scripts')
    <script>
        function confirmStatusChange(form) {
            return confirm('Are you sure you want to update the status?');
        }
    </script>
@endpush
@endsection