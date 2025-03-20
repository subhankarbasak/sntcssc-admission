@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="h4 mb-0">Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h2>
                            <p class="text-muted mb-0">Logged in as {{ Auth::user()->email }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-danger btn-sm logout-btn me-2" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Available Advertisements Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Available Notifications</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($advertisements as $advertisement)
                            <div class="col-md-6">
                                <div class="card h-100 border-0 hover-shadow">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $advertisement->title }}</h5>
                                        <p class="card-text">
                                            <strong>Code:</strong> {{ $advertisement->code }}<br>
                                            <strong>Batch:</strong> {{ $advertisement->batch->name }}<br>
                                            <strong>Registration Ends on:</strong> {{ $advertisement->application_end->format('F d, Y, l, g:i A') }}
                                        </p>
                                        <div class="mt-3">
                                            <form id="applicationForm" action="{{ route('application.create', $advertisement) }}" method="GET">
                                                @csrf
                                                <button href="#" class="btn btn-primary w-100" id="applyBtn">
                                                    @if(!$applications->isEmpty() && $applications[0]->status === 'submitted')
                                                    Apply Now
                                                    @else
                                                    Continue your application
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Applications Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Applications</h4>
                </div>
                <div class="card-body">
                    @if($applications->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">No applications submitted yet.</p>
                            <a href="#" class="btn btn-primary d-none">Create Your First Application</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Application Number</th>
                                        <th>Advertisement</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->application_number }}</td>
                                            <td>{{ $application->advertisement->title }}</td>
                                            <td>
                                                <span class="badge {{ $application->status === 'submitted' ? 'bg-success' : ($application->status === 'draft' ? 'bg-warning' : 'bg-info') }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $application->payment_status === 'paid' ? 'bg-success' : ($application->payment_status === 'pending' ? 'bg-warning' : ($application->payment_status === 'under review' ? 'bg-info' : 'bg-danger')) }}">
                                                    {{ ucfirst($application->payment_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('application.status', $application) }}" 
                                                       class="btn btn-sm btn-info">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row d-none">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card h-100 border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                                    <h5 class="mb-1">New Application</h5>
                                    <p class="text-muted">Create a new application</p>
                                    <a href="#" class="btn btn-primary btn-sm">Start Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                                    <h5 class="mb-1">My Applications</h5>
                                    <p class="text-muted">View your applications</p>
                                    <a href="#" class="btn btn-success btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-user fa-3x text-info mb-3"></i>
                                    <h5 class="mb-1">Profile Settings</h5>
                                    <p class="text-muted">Manage your profile</p>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                                    <h5 class="mb-1">Notifications</h5>
                                    <p class="text-muted">View alerts and notifications</p>
                                    <a href="#" class="btn btn-warning btn-sm">Check</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Logout Confirmation Modal -->
<div class="modal" tabindex="-1" id="logoutModal" aria-labelledby="logoutModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    Are you sure you want to log out? You will be redirected to the Home page.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Confirm Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmLogout() {
            $('#logoutModal').modal('show');
        }
    </script>

<script>
        const toastMessage = @json(session('toastr'));
    </script>
    <script>
        $(document).ready(function () {
            if (toastMessage) {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr[toastMessage.type](toastMessage.message);
            }
        });
    </script>

    <script>
        // document.getElementById('applyBtn').addEventListener('click', function(event) {
        //     event.preventDefault(); // Prevent the default anchor action
            
        //     var applyBtn = this; // Reference to the button
        //     var form = document.getElementById('applicationForm'); // Reference to the form

        //     // Add spinner and disable button
        //     applyBtn.disabled = true;
        //     applyBtn.innerHTML = '<span class="spinner"></span>Processing...';
            
        //     // Submit the form after a small delay (optional, to see spinner)
        //     setTimeout(function() {
        //         form.submit();
        //     }, 500); // Adjust the delay as needed
        // });

        const applyBtn = document.getElementById('applyBtn');

        applyBtn.addEventListener('click', function() {
            // Add spinner and disable button
            applyBtn.disabled = true;
            applyBtn.innerHTML = '<span class="spinner"></span>Processing...';
            
            // Submit the form
            document.getElementById('applicationForm').submit();
        });
    </script>
@endpush
@endsection