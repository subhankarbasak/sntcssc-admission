@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-briefcase me-2"></i>Step 3: Professional & Examination Details</h4>
    <form method="POST" action="{{ route('application.store.step3', $application) }}" id="step3Form" class="needs-validation" novalidate>
        @csrf

        <!-- Employment History -->
        <section class="card mb-4 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 px-4 fw-semibold border-bottom">Employment History</div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label fw-medium mb-2 required">Are you currently employed?</label>
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
            <div class="card-header bg-white py-3 px-4 fw-semibold border-bottom">Whether presently enrolled in any course at any Institute?</div>
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
                <span class="fw-semibold">Have you appeared in UPSC CSE Exam earlier? if yes, give below the details in ascending chronological order:</span>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="addUpscAttempt()">
                    <i class="bi bi-plus me-1"></i> Add Attempt
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
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.step2', $application) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Previous
            </a>
            <button type="button" class="btn btn-primary shadow-sm" id="previewAndNextBtn">
                <i class="bi bi-eye me-2"></i>Preview and Next
            </button>
        </div>
    </div>
@endsection

@section('preview')
    <div class="accordion accordion-flush" id="previewAccordion">
        <!-- Employment Preview -->
        <div class="accordion-item mb-3 shadow-sm rounded-3">
            <h2 class="accordion-header">
                <button class="accordion-button fw-semibold py-3" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#employmentPreview" aria-expanded="true">
                    <i class="bi bi-briefcase me-2"></i>Employment History
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
                    <i class="bi bi-mortarboard me-2"></i>Current Enrollment
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
                    <i class="bi bi-clipboard-check me-2"></i>UPSC Attempts
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

        <!-- Declaration -->
        <div class="mt-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="declarationCheck" required>
                <label class="form-check-label" for="declarationCheck">
                    I hereby declare that all the information provided is true and correct to the best of my knowledge.
                </label>
            </div>
        </div>
    </div>
@endsection

@section('preview-footer')
    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
        <i class="bi bi-pencil me-2"></i>Edit
    </button>
    <button type="button" class="btn btn-primary shadow-sm" id="saveAndNextBtn" disabled>
        Save and Next<i class="bi bi-arrow-right ms-2"></i>
    </button>
@endsection

@push('styles')
<style>
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
    // Employment details toggle
    const employmentRadios = document.querySelectorAll('input[name="employment[is_employed]"]');
    const employmentDetails = document.getElementById('employmentDetails');
    employmentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            employmentDetails.classList.toggle('d-none', this.value === '0');
        });
    });

    // Preview and Next button handler
    document.getElementById('previewAndNextBtn').addEventListener('click', function() {
        const form = document.getElementById('step3Form');
        let isValid = true;

        // Check required fields
        form.querySelectorAll('[required]').forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            toastr.error('Please fill all required fields.');
            form.classList.add('was-validated');
            return;
        }

        // Populate preview modal
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

        // Show preview modal
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    });

    // Declaration checkbox handler
    const declarationCheck = document.getElementById('declarationCheck');
    const saveAndNextBtn = document.getElementById('saveAndNextBtn');
    
    declarationCheck.addEventListener('change', function() {
        saveAndNextBtn.disabled = !this.checked;
    });

    // Save and Next button handler
    saveAndNextBtn.addEventListener('click', function() {
        if (declarationCheck.checked) {
            document.getElementById('step3Form').submit();
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

@php
    $step = 3;
    $percentage = 40;
@endphp