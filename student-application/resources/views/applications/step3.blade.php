<!-- resources/views/applications/step3.blade.php -->
@extends('layouts.app')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-4 px-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 fw-bold">Step 3: Professional & Examination Details</h4>
                        <span class="badge bg-white text-primary fw-medium px-3 py-2 rounded-pill">Step 3 of 3</span>
                    </div>
                </div>
                <div class="card-body p-5 bg-light-subtle">
                    <form method="POST" action="{{ route('application.store.step3', $application->id) }}" id="step3Form" class="needs-validation" novalidate>
                        @csrf

                        <!-- Employment History -->
                        <section class="card mb-4 shadow-sm rounded-3">
                            <div class="card-header bg-white py-3 px-4 fw-semibold border-bottom">Employment History</div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label fw-medium mb-2">Are you currently employed? <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employment[is_employed]" 
                                                   value="1" {{ old('employment.is_employed', $employment?->is_employed) ? 'checked' : '' }} 
                                                   id="employedYes" required>
                                            <label class="form-check-label" for="employedYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employment[is_employed]" 
                                                   value="0" {{ old('employment.is_employed', $employment?->is_employed ?? true) ? '' : 'checked' }} 
                                                   id="employedNo" required>
                                            <label class="form-check-label" for="employedNo">No</label>
                                        </div>
                                    </div>
                                    @error('employment.is_employed')
                                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="employmentDetails" class="{{ old('employment.is_employed', $employment?->is_employed) ? '' : 'd-none' }}">
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">Designation</label>
                                            <input type="text" name="employment[designation]" class="form-control rounded-3 shadow-sm" 
                                                   value="{{ old('employment.designation', $employment?->designation) }}" 
                                                   placeholder="Enter designation">
                                            @error('employment.designation')
                                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">Employer</label>
                                            <input type="text" name="employment[employer]" class="form-control rounded-3 shadow-sm" 
                                                   value="{{ old('employment.employer', $employment?->employer) }}" 
                                                   placeholder="Enter employer name">
                                            @error('employment.employer')
                                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">Location</label>
                                            <input type="text" name="employment[location]" class="form-control rounded-3 shadow-sm" 
                                                   value="{{ old('employment.location', $employment?->location) }}" 
                                                   placeholder="Enter location">
                                            @error('employment.location')
                                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Current Enrollment -->
                        <section class="card mb-4 shadow-sm rounded-3">
                            <div class="card-header bg-white py-3 px-4 fw-semibold border-bottom">Current Enrollment</div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Course Name</label>
                                        <input type="text" name="enrollment[course_name]" class="form-control rounded-3 shadow-sm" 
                                               value="{{ old('enrollment.course_name', $enrollment?->course_name) }}" 
                                               placeholder="Enter course name">
                                        @error('enrollment.course_name')
                                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Institute</label>
                                        <input type="text" name="enrollment[institute]" class="form-control rounded-3 shadow-sm" 
                                               value="{{ old('enrollment.institute', $enrollment?->institute) }}" 
                                               placeholder="Enter institute name">
                                        @error('enrollment.institute')
                                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- UPSC Attempts -->
                        <section class="card mb-4 shadow-sm rounded-3">
                            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                                <span class="fw-semibold">UPSC Attempts</span>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="addUpscAttempt()">
                                    <i class="fas fa-plus me-1"></i> Add Attempt
                                </button>
                            </div>
                            <div class="card-body p-4" id="upscContainer">
                                @foreach($upscAttempts as $index => $attempt)
                                    @include('applications.partials.upsc_attempt', [
                                        'index' => $index,
                                        'attempt' => $attempt
                                    ])
                                @endforeach
                            </div>
                        </section>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('application.step2', $application->id) }}" 
                               class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-medium">
                                <i class="fas fa-arrow-left me-2"></i>Previous
                            </a>
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-outline-info rounded-pill px-4 py-2 fw-medium" 
                                        data-bs-toggle="modal" data-bs-target="#previewModal">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-medium">
                                    Save and Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-gradient-primary text-white border-0 py-4 px-5">
                <h5 class="modal-title fw-bold" id="previewModalLabel">
                    <i class="fas fa-file-alt me-2"></i>Application Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 bg-light-subtle">
                <div class="accordion accordion-flush" id="previewAccordion">
                    <!-- Employment Preview -->
                    <div class="accordion-item mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold py-3" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#employmentPreview" aria-expanded="true">
                                <i class="fas fa-briefcase me-2"></i>Employment History
                            </button>
                        </h2>
                        <div id="employmentPreview" class="accordion-collapse collapse show" data-bs-parent="#previewAccordion">
                            <div class="accordion-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle">
                                        <tbody id="employmentTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Preview -->
                    <div class="accordion-item mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#enrollmentPreview">
                                <i class="fas fa-graduation-cap me-2"></i>Current Enrollment
                            </button>
                        </h2>
                        <div id="enrollmentPreview" class="accordion-collapse collapse" data-bs-parent="#previewAccordion">
                            <div class="accordion-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle">
                                        <tbody id="enrollmentTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- UPSC Attempts Preview -->
                    <div class="accordion-item shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#upscPreview">
                                <i class="fas fa-clipboard-list me-2"></i>UPSC Attempts
                            </button>
                        </h2>
                        <div id="upscPreview" class="accordion-collapse collapse" data-bs-parent="#previewAccordion">
                            <div class="accordion-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Attempt #</th>
                                                <th scope="col">Year</th>
                                                <th scope="col">Roll Number</th>
                                            </tr>
                                        </thead>
                                        <tbody id="upscTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-5 py-4">
                <button type="button" class="btn btn-secondary rounded-pill px-5 py-2 fw-medium" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #00b4ff);
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #007bff;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
    }
    .invalid-feedback {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Employment details toggle
    const employmentRadios = document.querySelectorAll('input[name="employment[is_employed]"]');
    const employmentDetails = document.getElementById('employmentDetails');
    employmentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            employmentDetails.classList.toggle('d-none', this.value === '0');
        });
    });

    // Preview modal population
    const previewModal = document.getElementById('previewModal');
    previewModal.addEventListener('show.bs.modal', function() {
        const form = document.getElementById('step3Form');
        const formData = new FormData(form);

        // Employment Section
        const employmentTableBody = document.getElementById('employmentTableBody');
        employmentTableBody.innerHTML = '';
        const isEmployed = formData.get('employment[is_employed]') === '1';
        employmentTableBody.innerHTML = `
            <tr>
                <th scope="row" class="fw-medium text-muted" style="width: 30%;">Currently Employed</th>
                <td>${isEmployed ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'}</td>
            </tr>
        `;
        if (isEmployed) {
            employmentTableBody.innerHTML += `
                <tr>
                    <th scope="row" class="fw-medium text-muted">Designation</th>
                    <td>${formData.get('employment[designation]') || '<span class="text-muted">Not provided</span>'}</td>
                </tr>
                <tr>
                    <th scope="row" class="fw-medium text-muted">Employer</th>
                    <td>${formData.get('employment[employer]') || '<span class="text-muted">Not provided</span>'}</td>
                </tr>
                <tr>
                    <th scope="row" class="fw-medium text-muted">Location</th>
                    <td>${formData.get('employment[location]') || '<span class="text-muted">Not provided</span>'}</td>
                </tr>
            `;
        }

        // Enrollment Section
        const enrollmentTableBody = document.getElementById('enrollmentTableBody');
        enrollmentTableBody.innerHTML = `
            <tr>
                <th scope="row" class="fw-medium text-muted" style="width: 30%;">Course Name</th>
                <td>${formData.get('enrollment[course_name]') || '<span class="text-muted">Not provided</span>'}</td>
            </tr>
            <tr>
                <th scope="row" class="fw-medium text-muted">Institute</th>
                <td>${formData.get('enrollment[institute]') || '<span class="text-muted">Not provided</span>'}</td>
            </tr>
        `;

        // UPSC Attempts Section
        const upscTableBody = document.getElementById('upscTableBody');
        upscTableBody.innerHTML = '';
        const upscAttempts = document.querySelectorAll('.upsc-attempt');
        if (upscAttempts.length === 0) {
            upscTableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-muted py-3">No UPSC attempts recorded</td>
                </tr>
            `;
        } else {
            upscAttempts.forEach((attempt, index) => {
                const year = attempt.querySelector(`[name="upsc_attempts[${index}][exam_year]"]`)?.value || '-';
                const rollNo = attempt.querySelector(`[name="upsc_attempts[${index}][roll_number]"]`)?.value || '-';
                upscTableBody.innerHTML += `
                    <tr>
                        <td class="fw-medium">Attempt ${index + 1}</td>
                        <td>${year !== '-' ? year : '<span class="text-muted">Not provided</span>'}</td>
                        <td>${rollNo !== '-' ? rollNo : '<span class="text-muted">Not provided</span>'}</td>
                    </tr>
                `;
            });
        }
    });

    // Toastr configuration
    toastr.options = {
        positionClass: 'toast-top-right',
        progressBar: true,
        timeOut: 5000,
        closeButton: true
    };

    @if(session('toastr'))
        toastr['{{ session('toastr.type') }}']('{{ session('toastr.message') }}', 'Notification');
    @endif
});

function addUpscAttempt() {
    const container = document.getElementById('upscContainer');
    const index = container.querySelectorAll('.upsc-attempt').length;
    
    fetch('{{ route('application.upsc-attempt-template') }}?index=' + index)
        .then(response => response.text())
        .then(html => {
            container.insertAdjacentHTML('beforeend', html);
            toastr.success('New UPSC attempt added successfully');
        })
        .catch(error => {
            toastr.error('Failed to add UPSC attempt');
            console.error(error);
        });
}

function removeUpscAttempt(element) {
    element.closest('.upsc-attempt').remove();
    toastr.info('UPSC attempt removed');
}
</script>
@endpush
@endsection