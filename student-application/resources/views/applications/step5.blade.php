@extends('layouts.form')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4 text-dark fw-semibold border-bottom pb-2"><i class="bi bi-check2-circle me-2 text-success"></i>Step 5: Final Preview & Submission</h4>
        <form method="POST" action="{{ route('application.submit', $details['application']) }}" enctype="multipart/form-data" id="applicationForm" class="needs-validation" novalidate>
            @csrf

            <!-- Personal Details with Photo and Signature -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Personal Details</h5>
                <div class="row g-3">
                    <div class="col-12 col-md-10">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="fw-medium bg-light py-2 w-25">Full Name</th>
                                        <td class="py-2">{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Date of Birth (DD/MM/YYYY)</th>
                                        <td class="py-2">{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Gender</th>
                                        <td class="py-2">{{ ucfirst($details['profile']->gender) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Email</th>
                                        <td class="py-2">{{ $details['profile']->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Mobile /Whatsapp No.</th>
                                        <td class="py-2">{{ $details['profile']->mobile }} / {{ $details['profile']->whatsapp }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Category</th>
                                        <td class="py-2">
                                            @if(is_null($details['profile']->category))
                                                {{-- Do not print anything if the category is null --}}
                                            @elseif($details['profile']->category == 'Unreserved' || $details['profile']->category == 'UR')
                                                <span>Unreserved</span>
                                            @elseif(in_array($details['profile']->category, ['SC', 'ST', 'OBC']))
                                                <span>Reserved</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Father's Name</th>
                                        <td class="py-2">{{ $details['profile']->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Father's Occupation</th>
                                        <td class="py-2">{{ $details['profile']->father_occupation }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Mother's Name</th>
                                        <td class="py-2">{{ $details['profile']->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Mother's Occupation</th>
                                        <td class="py-2">{{ $details['profile']->mother_occupation }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Family's Annual Income</th>
                                        <td class="py-2">{{ $details['profile']->family_income }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Medium of Language</th>
                                        <td class="py-2">{{ $details['profile']->school_language }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Highest Qualifcation</th>
                                        <td class="py-2">{{ $details['profile']->highest_qualification }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="d-flex flex-column gap-3">
                            <!-- Photograph -->
                            <div>
                                <label class="fw-medium text-muted small d-block mb-1">Photograph</label>
                                @if($details['documents']->where('type', 'photo')->first())
                                    <div class="border rounded p-2 bg-light">
                                        @if (app()->environment('live'))
                                            <img src="{{ url('public/storage/' . $details['documents']->where('type', 'photo')->first()->file_path) }}"
                                                class="img-fluid w-100 rounded"
                                                alt="Student Photo"
                                                style="max-height: 180px; object-fit: contain;">
                                        @else
                                            <img src="{{ Storage::url($details['documents']->where('type', 'photo')->first()->file_path) }}"
                                                class="img-fluid w-100 rounded"
                                                alt="Student Photo"
                                                style="max-height: 180px; object-fit: contain;">
                                        @endif
                                    </div>
                                @else
                                    <div class="border rounded p-2 bg-light text-center d-flex align-items-center justify-content-center" style="height: 180px;">
                                        <span class="text-muted fw-medium">Photo</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Signature -->
                            <div>
                                <label class="fw-medium text-muted small d-block mb-1">Signature</label>
                                @if($details['documents']->where('type', 'signature')->first())
                                    <div class="border rounded p-2 bg-light">
                                        <div class="signature-wrapper" style="max-height: 100px; overflow: hidden;">
                                            @if (app()->environment('live'))
                                                <img src="{{ url('public/storage/' . $details['documents']->where('type', 'signature')->first()->file_path) }}"
                                                    class="img-fluid w-100 rounded"
                                                    alt="Signature"
                                                    style="object-fit: contain;">
                                            @else
                                                <img src="{{ Storage::url($details['documents']->where('type', 'signature')->first()->file_path) }}"
                                                    class="img-fluid w-100 rounded"
                                                    alt="Signature"
                                                    style="object-fit: contain;">
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="border rounded p-2 bg-light text-center d-flex align-items-center justify-content-center" style="height: 100px;">
                                        <span class="text-muted fw-medium">Signature</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Addresses -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Addresses</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="fw-medium py-2">Type</th>
                                <th class="fw-medium py-2">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details['addresses'] as $address)
                                <tr>
                                    <td class="py-2">{{ ucfirst($address->type) }}</td>
                                    <td class="py-2">{{ $address->address_line1 }}, {{ $address->post_office }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Academic Qualifications -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Academic Qualifications</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="fw-medium py-2">Examination</th>
                                <th class="fw-medium py-2">Institute</th>
                                <th class="fw-medium py-2">Board/University</th>
                                <th class="fw-medium py-2">Year Passed</th>
                                <th class="fw-medium py-2">Total Marks</th>
                                <th class="fw-medium py-2">Marks Obtained</th>
                                <th class="fw-medium py-2">CGPA/SGPA</th>
                                <th class="fw-medium py-2">Division/Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details['academics'] as $academic)
                                <tr>
                                    <td class="py-2">{{ ucfirst($academic->level) }}</td>
                                    <td class="py-2">{{ $academic->institute }}</td>
                                    <td class="py-2">{{ $academic->board_university }}</td>
                                    <td class="py-2">{{ $academic->year_passed }}</td>
                                    <td class="py-2">{{ number_format($academic->total_marks, 0) }}</td>
                                    <td class="py-2">{{ number_format($academic->marks_obtained, 0) }}</td>
                                    <td class="py-2">{{ $academic->cgpa }}</td>
                                    <td class="py-2">{{ $academic->division }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Employment History -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Employment History</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            @if($details['employment'])
                                <tr>
                                    <th class="fw-medium bg-light py-2 w-25">Are you currently employed?</th>
                                    <td class="py-2">{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</td>
                                </tr>
                                @if($details['employment']->is_employed)
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Designation</th>
                                        <td class="py-2">{{ $details['employment']->designation }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Employer</th>
                                        <td class="py-2">{{ $details['employment']->employer }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-medium bg-light py-2">Location</th>
                                        <td class="py-2">{{ $details['employment']->location }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="2" class="text-muted py-2 text-center">No employment details provided</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Current Enrollment -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Whether presently enrolled in any course at any Institute?</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            @if($details['enrollment'] && ($details['enrollment']->course_name || $details['enrollment']->institute))
                                <tr>
                                    <th class="fw-medium bg-light py-2 w-25">Course</th>
                                    <td class="py-2">{{ $details['enrollment']->course_name }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-medium bg-light py-2">Institute</th>
                                    <td class="py-2">{{ $details['enrollment']->institute }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2" class="text-muted py-2 text-center">No enrollment details provided</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- UPSC Attempts -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Have you appeared in UPSC CSE Exam earlier? if yes, give below the details in ascending chronological order:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="fw-medium py-2">Year</th>
                                <th class="fw-medium py-2">Roll Number</th>
                                <th class="fw-medium py-2 d-none d-md-table-cell">Prelims Cleared</th>
                                <th class="fw-medium py-2 d-none d-md-table-cell">Mains Cleared</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($details['upsc_attempts'] as $attempt)
                                <tr>
                                    <td class="py-2">{{ $attempt->exam_year }}</td>
                                    <td class="py-2">{{ $attempt->roll_number }}</td>
                                    <td class="py-2 d-none d-md-table-cell">{{ $attempt->prelims_cleared ? 'Yes' : 'No' }}</td>
                                    <td class="py-2 d-none d-md-table-cell">{{ $attempt->mains_cleared ? 'Yes' : 'No' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-2 text-center">No UPSC attempts recorded</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Documents -->
            <section class="mb-4 bg-white p-4 rounded-lg shadow-sm border-start border-success">
                <h5 class="fw-semibold text-dark mb-3">Uploaded Documents</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="fw-medium py-2">Uploaded Documents</th>
                                <th class="fw-medium py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details['documents'] as $document)
                                <tr>
                                    <td class="py-2">{{ getFieldLabel($document->type) }}</td>
                                    <td class="py-2">
                                        @if (app()->environment('live'))
                                            <a href="{{ url('public/storage/' . $document->file_path) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i> View
                                            </a>
                                        @else
                                            <a href="{{ Storage::url($document->file_path) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i> View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </form>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-lg shadow-lg">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-semibold text-dark" id="confirmSubmitModalLabel">
                            <i class="bi bi-exclamation-circle me-2 text-warning"></i>Confirm Submission ?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-muted mb-3 small">
                            Are you sure you want to submit your application? Once submitted, no further changes can be made. Please review all details carefully before proceeding.
                        </p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmCheckbox" required>
                            <label class="form-check-label text-dark fw-medium small" for="confirmCheckbox">
                                I have verified all information and agree to submit.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" id="finalSubmitBtn" disabled>Final Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="form-footer bg-light py-3 border-top">
        <div class="container">
            <div class="d-flex justify-content-between flex-column flex-md-row gap-3">
                <a href="{{ route('application.step4', $details['application']) }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm w-100 w-md-auto">
                    <i class="bi bi-arrow-left me-2"></i>Previous
                </a>
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm w-100 w-md-auto" id="submitApplicationBtn">
                    Submit Application <i class="bi bi-check-circle ms-2"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* General Layout */
    .container {
        max-width: 1200px;
    }
    section {
        background: #ffffff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #28a745;
    }
    h4 {
        font-size: 1.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    h5 {
        font-size: 1.25rem;
        /* color: #212529; */
    }

    /* Typography */
    .fw-medium {
        font-weight: 500;
    }
    .text-muted {
        color: #6c757d !important;
    }
    .small {
        font-size: 0.875rem;
    }

    /* Tables */
    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .table th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 500;
        padding: 0.75rem;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        padding: 0.75rem;
        color: #495057;
        vertical-align: middle;
    }
    .table .w-25 {
        width: 25%;
    }

    /* Photo and Signature */
    .img-fluid {
        border-radius: 0.25rem;
    }
    .bg-light {
        background: #f8f9fa !important;
    }
    .signature-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Buttons */
    .btn-primary {
        background: #007bff;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: background 0.3s ease;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
    .btn-outline-secondary {
        border-color: #ced4da;
        color: #495057;
        padding: 0.75rem 1.5rem;
        transition: background 0.3s ease, border-color 0.3s ease;
    }
    .btn-outline-secondary:hover {
        background: #f8f9aa;
        border-color: #adb5bd;
        color: blue;
    }
    .rounded-pill {
        border-radius: 2rem;
    }

    /* Modal */
    .modal-content {
        border-radius: 0.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-footer {
        padding: 1rem 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 767.98px) {
        body {
            padding-bottom: 100px;
        }
        .container {
            padding: 0 1rem;
        }
        h4 {
            font-size: 1.25rem;
        }
        h5 {
            font-size: 1.1rem;
        }
        section {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .table th, .table td {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
        .table .w-25 {
            width: 35%;
        }
        .btn-primary, .btn-outline-secondary {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            width: 100%;
        }
        .form-footer {
            /* position: fixed; */
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 0.75rem 1rem;
        }
        .modal-body {
            padding: 1rem;
        }
        .modal-footer {
            padding: 0.75rem 1rem;
        }
        .modal-title {
            font-size: 1.1rem;
        }
        .signature-wrapper img {
            max-height: 80px;
        }
    }
    @media (min-width: 768px) {
        .form-footer {
            padding: 1rem 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toastr configuration
    toastr.options = {
        positionClass: 'toast-top-right',
        progressBar: true,
        timeOut: 5000,
        closeButton: true,
        preventDuplicates: true
    };

    // Submit button handler
    const submitBtn = document.getElementById('submitApplicationBtn');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
    const confirmCheckbox = document.getElementById('confirmCheckbox');
    const finalSubmitBtn = document.getElementById('finalSubmitBtn');
    const form = document.getElementById('applicationForm');

    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        confirmCheckbox.checked = false; // Reset checkbox
        finalSubmitBtn.disabled = true; // Reset button state
        confirmModal.show();
    });

    // Enable Final Submit button when checkbox is checked
    confirmCheckbox.addEventListener('change', function() {
        finalSubmitBtn.disabled = !this.checked;
    });

    // Final submission
    finalSubmitBtn.addEventListener('click', function() {
        if (confirmCheckbox.checked) {
            toastr.warning('Processing your submission. Please wait a moment while we save your details.');
            // confirmModal.hide();
            form.submit();
        }
    });

    @if(session('toastr'))
        toastr['{{ session('toastr.type') }}']('{{ session('toastr.message') }}', 'Notification');
    @endif
});
</script>

<script>
    const form = document.getElementById('applicationForm');
    const nextBtn = document.getElementById('finalSubmitBtn');
    nextBtn.addEventListener('click', function() {
        // Add spinner and disable button
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<span class="spinner"></span>Processing...';
        
        // Submit the form
        form.submit();
    });
</script>
@endpush

@php
    $step = 5;
    $percentage = 80;
@endphp