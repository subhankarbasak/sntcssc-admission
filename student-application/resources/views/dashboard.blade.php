<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Dashboard</h4>
                        <button class="btn btn-danger btn-sm logout-btn float-end" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Available Advertisements</h5>
                    <div class="row">
                        @foreach($advertisements as $advertisement)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $advertisement->title }}</h5>
                                        <p class="card-text">
                                            Code: {{ $advertisement->code }}<br>
                                            Batch: {{ $advertisement->batch->name }}<br>
                                            Ends: {{ $advertisement->application_end->format('d M Y') }}
                                        </p>
                                        <a href="{{ route('application.create', $advertisement->id) }}" 
                                           class="btn btn-primary">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Applications</h4>
                </div>
                <div class="card-body">
                    @if($applications->isEmpty())
                        <p>No applications submitted yet.</p>
                    @else
                        <table class="table table-striped">
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
                                            <span class="badge {{ $application->payment_status === 'paid' ? 'bg-success' : ($application->payment_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ ucfirst($application->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('application.status', $application->id) }}" 
                                               class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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
                Are you sure you want to log out? You will be redirected to the login page.
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
@endpush
@endsection