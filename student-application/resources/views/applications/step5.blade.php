@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-check2-circle me-2"></i>Step 5: Final Preview & Submission</h4>
    <form method="POST" action="{{ route('application.submit', $details['application']->id) }}" enctype="multipart/form-data" id="applicationForm">
        @csrf

        <!-- Personal Details -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Personal Details</h5>
            <div class="table-responsive rounded shadow-sm">
                <table class="table table-bordered bg-white mb-0 table-hover">
                    <tbody>
                        <tr>
                            <th class="bg-light fw-medium w-25">Full Name</th>
                            <td colspan="3">{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light fw-medium">Date of Birth</th>
                            <td>{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</td>
                            <th class="bg-light fw-medium">Gender</th>
                            <td>{{ $details['profile']->gender }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light fw-medium">Email</th>
                            <td>{{ $details['profile']->email }}</td>
                            <th class="bg-light fw-medium">Mobile</th>
                            <td>{{ $details['profile']->mobile }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light fw-medium">Category</th>
                            <td colspan="3">{{ $details['profile']->category }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Photo and Signature -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Photo & Signature</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="fw-medium text-dark mb-2">Student Photo</label>
                    @if($details['documents']->where('type', 'photo')->first())
                        <div class="position-relative overflow-hidden rounded border shadow-sm">
                            <img src="{{ Storage::url($details['documents']->where('type', 'photo')->first()->file_path) }}"
                                 class="img-fluid w-100 transition-scale"
                                 alt="Student Photo"
                                 style="max-height: 180px; object-fit: cover;">
                        </div>
                    @else
                        <div class="alert alert-light border text-muted text-center py-3 rounded">No photo uploaded</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="fw-medium text-dark mb-2">Signature</label>
                    @if($details['documents']->where('type', 'signature')->first())
                        <div class="position-relative overflow-hidden rounded border shadow-sm">
                            <img src="{{ Storage::url($details['documents']->where('type', 'signature')->first()->file_path) }}"
                                 class="img-fluid w-100 transition-scale"
                                 alt="Signature"
                                 style="max-height: 120px; object-fit: cover;">
                        </div>
                    @else
                        <div class="alert alert-light border text-muted text-center py-3 rounded">No signature uploaded</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Addresses -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Addresses</h5>
            <div class="row g-4">
                @foreach($details['addresses'] as $address)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 transition-hover">
                            <div class="card-body">
                                <h6 class="fw-semibold text-secondary mb-2">{{ ucfirst($address->type) }} Address</h6>
                                <p class="text-muted mb-0 small">
                                    {{ $address->address_line1 }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Academic Qualifications -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Academic Qualifications</h5>
            <div class="table-responsive rounded shadow-sm">
                <table class="table table-striped table-bordered bg-white mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="fw-medium">Level</th>
                            <th scope="col" class="fw-medium">Institute</th>
                            <th scope="col" class="fw-medium">Board/University</th>
                            <th scope="col" class="fw-medium">Year Passed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details['academics'] as $academic)
                            <tr>
                                <td>{{ $academic->level }}</td>
                                <td>{{ $academic->institute }}</td>
                                <td>{{ $academic->board_university }}</td>
                                <td>{{ $academic->year_passed }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Employment History -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Employment History</h5>
            <div class="card border-0 shadow-sm transition-hover">
                <div class="card-body">
                    @if($details['employment'])
                        <dl class="row mb-0 text-muted small">
                            <dt class="col-md-3 fw-medium text-dark">Employed</dt>
                            <dd class="col-md-9">{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</dd>
                            @if($details['employment']->is_employed)
                                <dt class="col-md-3 fw-medium text-dark">Designation</dt>
                                <dd class="col-md-9">{{ $details['employment']->designation }}</dd>
                                <dt class="col-md-3 fw-medium text-dark">Employer</dt>
                                <dd class="col-md-9">{{ $details['employment']->employer }}</dd>
                                <dt class="col-md-3 fw-medium text-dark">Location</dt>
                                <dd class="col-md-9">{{ $details['employment']->location }}</dd>
                            @endif
                        </dl>
                    @else
                        <div class="alert alert-light border text-muted text-center py-3 rounded">No employment details provided</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Current Enrollment -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Current Enrollment</h5>
            <div class="card border-0 shadow-sm transition-hover">
                <div class="card-body">
                    @if($details['enrollment'] && ($details['enrollment']->course_name || $details['enrollment']->institute))
                        <dl class="row mb-0 text-muted small">
                            <dt class="col-md-3 fw-medium text-dark">Course</dt>
                            <dd class="col-md-9">{{ $details['enrollment']->course_name }}</dd>
                            <dt class="col-md-3 fw-medium text-dark">Institute</dt>
                            <dd class="col-md-9">{{ $details['enrollment']->institute }}</dd>
                        </dl>
                    @else
                        <div class="alert alert-light border text-muted text-center py-3 rounded">No enrollment details provided</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- UPSC Attempts -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">UPSC Attempts</h5>
            <div class="table-responsive rounded shadow-sm">
                <table class="table table-striped table-bordered bg-white mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="fw-medium">Year</th>
                            <th scope="col" class="fw-medium">Roll Number</th>
                            <th scope="col" class="fw-medium">Prelims Cleared</th>
                            <th scope="col" class="fw-medium">Mains Cleared</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details['upsc_attempts'] as $attempt)
                            <tr>
                                <td>{{ $attempt->exam_year }}</td>
                                <td>{{ $attempt->roll_number }}</td>
                                <td>{{ $attempt->prelims_cleared ? 'Yes' : 'No' }}</td>
                                <td>{{ $attempt->mains_cleared ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No UPSC attempts recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Documents -->
        <section class="mb-5">
            <h5 class="fw-semibold text-primary mb-3 border-bottom pb-2">Uploaded Documents</h5>
            <div class="row g-4">
                @foreach($details['documents'] as $document)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm transition-hover">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="fw-medium text-dark small">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</span>
                                <a href="{{ Storage::url($document->file_path) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm rounded-pill px-3 transition-hover">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.step4', $details['application']->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Previous
            </a>
            <div>
                <button type="submit" form="applicationForm" class="btn btn-primary shadow-sm position-relative overflow-hidden">
                    <span class="position-relative z-1">Submit Application <i class="bi bi-arrow-right ms-2"></i></span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f1f5f9;
        color: #374151;
        font-weight: 500;
        padding: 12px 16px;
    }
    .table td {
        vertical-align: middle;
        color: #6b7280;
        padding: 12px 16px;
    }
    .table-hover tbody tr:hover {
        background-color: #f9fafb;
        transition: background-color 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border: none;
    }
    .btn-primary::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }
    .btn-primary:hover::after {
        width: 300px;
        height: 300px;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #1e40af, #2563eb);
    }
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .transition-scale {
        transition: transform 0.3s ease;
    }
    .transition-scale:hover {
        transform: scale(1.05);
    }
    .z-1 {
        z-index: 1;
    }
    .small {
        font-size: 0.875rem;
    }
    .border-bottom {
        border-bottom: 2px solid #e5e7eb;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    toastr.options = {
        "positionClass": "toast-top-right",
        "progressBar": true,
        "timeOut": 5000,
        "closeButton": true,
        "preventDuplicates": true
    };

    @if(session('toastr'))
        toastr[{{ session('toastr.type') }}]('{{ session('toastr.message') }}', 'Notification');
    @endif

    const form = document.getElementById('applicationForm');
    form.addEventListener('submit', (e) => {
        if (!confirm('Are you sure you want to submit your application? This action cannot be undone.')) {
            e.preventDefault();
        } else {
            toastr.success('Application submitted successfully!');
        }
    });
});
</script>
@endpush

@php
    $step = 5;
@endphp