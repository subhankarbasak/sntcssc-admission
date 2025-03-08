@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white py-3 rounded-top">
                    <h4 class="mb-0 fw-bold">Application Step 1: Personal Details</h4>
                </div>
                <div class="card-body p-4">
                    <form id="applicationForm" method="POST" action="{{ route('application.store.step1', $advertisement->id) }}" class="needs-validation" novalidate>
                        @csrf
                        <!-- Advertisement Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Program Selection <span class="text-danger">*</span></label>
                            <select name="advertisement_program_id" class="form-select" required>
                                <option value="">Select Program</option>
                                @foreach($advertisement->programs as $program)
                                    <option value="{{ $program->id }}" selected>{{ $program->batchProgram->program->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a program.</div>
                        </div>

                        <!-- Student Details -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" 
                                       value="{{ $profile->first_name ?? $student->first_name }}" required readonly>
                                <div class="invalid-feedback">First name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" 
                                       value="{{ $profile->last_name ?? $student->last_name }}" required readonly>
                                <div class="invalid-feedback">Last name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="dob" class="form-control" 
                                       value="{{ $profile->dob ?? $student->dob }}" required>
                                <div class="invalid-feedback">Date of birth is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ ($profile->gender ?? $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ ($profile->gender ?? $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ ($profile->gender ?? $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="UR" {{ ($profile->category ?? $student->category) == 'UR' ? 'selected' : '' }}>General</option>
                                    <option value="OBC" {{ ($profile->category ?? $student->category) == 'OBC' ? 'selected' : '' }}>OBC</option>
                                    <option value="SC" {{ ($profile->category ?? $student->category) == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="ST" {{ ($profile->category ?? $student->category) == 'ST' ? 'selected' : '' }}>ST</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ $profile->email ?? $student->email }}" required readonly>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile" class="form-control" 
                                       value="{{ $profile->mobile ?? $student->mobile }}" required pattern="[0-9]{10}" readonly>
                                <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Optional Subject</label>
                                <select name="optional_subject" class="form-select">
                                    <option value="">Select Optional Subject</option>
                                    @foreach(json_decode('{
                                        "optional_subjects": [
                                            "Agriculture", "Animal Husbandry and Veterinary Science", "Anthropology", "Botany", "Chemistry",
                                            "Civil Engineering", "Commerce and Accountancy", "Economics", "Electrical Engineering", "Geography",
                                            "Geology", "History", "Law", "Literature of Assamese Language", "Literature of Bengali Language",
                                            "Literature of Bodo Language", "Literature of Dogri Language", "Literature of English Language",
                                            "Literature of Gujarati Language", "Literature of Hindi Language", "Literature of Kannada Language",
                                            "Literature of Kashmiri Language", "Literature of Konkani Language", "Literature of Maithili Language",
                                            "Literature of Malayalam Language", "Literature of Manipuri Language", "Literature of Marathi Language",
                                            "Literature of Nepali Language", "Literature of Odia Language", "Literature of Punjabi Language",
                                            "Literature of Sanskrit Language", "Literature of Santhali Language", "Literature of Sindhi Language",
                                            "Literature of Tamil Language", "Literature of Telugu Language", "Literature of Urdu Language",
                                            "Management", "Mathematics", "Mechanical Engineering", "Medical Science", "Philosophy", "Physics",
                                            "Political Science and International Relations", "Psychology", "Public Administration", "Sociology",
                                            "Statistics", "Zoology"
                                        ]
                                    }')->optional_subjects as $subject)
                                        <option value="{{ $subject }}" {{ ($application->optional_subject ?? '') == $subject ? 'selected' : '' }}>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Appearing for UPSC CSE?</label>
                                <select name="is_appearing_upsc_cse" class="form-select">
                                    <option value="0" {{ ($application->is_appearing_upsc_cse ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ ($application->is_appearing_upsc_cse ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">UPSC Attempts Count</label>
                                <input type="number" name="upsc_attempts_count" class="form-control" 
                                       value="{{ $application->upsc_attempts_count ?? 0 }}" min="0">
                                <div class="invalid-feedback">Please enter a valid number (0 or more).</div>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $profile->student_id ?? $student->id }}">
                            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                        </div>

                        <div class="text-end mt-5">
                            <button type="button" class="btn btn-outline-secondary me-2 shadow-sm" 
                                    data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Save and Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-bold text-primary">Application Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <table class="table table-striped table-bordered table-hover">
                    <tbody id="previewTable">
                        <!-- Populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-primary shadow-sm" onclick="$('#applicationForm').submit()">Save and Next</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .card-header.bg-gradient-primary {
        background: linear-gradient(90deg, #007bff, #00c4ff);
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }
    .btn-primary {
        background: linear-gradient(90deg, #007bff, #00c4ff);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #0056b3, #0096cc);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationForm');
    const previewModal = document.getElementById('previewModal');
    const previewTable = document.getElementById('previewTable');

    // Toastr options
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000
    };

    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        form.querySelectorAll('[required]').forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        const email = form.querySelector('input[name="email"]');
        if (email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.classList.add('is-invalid');
            isValid = false;
        }

        const mobile = form.querySelector('input[name="mobile"]');
        if (mobile.value && !/^[0-9]{10}$/.test(mobile.value)) {
            mobile.classList.add('is-invalid');
            isValid = false;
        }

        const attempts = form.querySelector('input[name="upsc_attempts_count"]');
        if (attempts.value && attempts.value < 0) {
            attempts.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please correct the errors in the form.');
        } else {
            toastr.success('Form submitted successfully!');
        }
    });

    // Preview modal population
    previewModal.addEventListener('show.bs.modal', function() {
        const formData = new FormData(form);
        let previewHTML = '';
        
        const labels = {
            'advertisement_program_id': 'Program Selection',
            'first_name': 'First Name',
            'last_name': 'Last Name',
            'dob': 'Date of Birth',
            'gender': 'Gender',
            'category': 'Category',
            'email': 'Email',
            'mobile': 'Mobile Number',
            'optional_subject': 'Optional Subject',
            'is_appearing_upsc_cse': 'Appearing for UPSC CSE',
            'upsc_attempts_count': 'UPSC Attempts Count'
        };

        for (let [key, value] of formData.entries()) {
            if (key === 'student_id' || key === 'advertisement_id' || key === '_token') continue;
            
            let displayValue = value || '-';
            if (key === 'advertisement_program_id' && value) {
                displayValue = form.querySelector(`select[name="${key}"] option[value="${value}"]`).textContent;
            }
            if (key === 'optional_subject' && value) {
                displayValue = value;
            }
            if (key === 'is_appearing_upsc_cse') {
                displayValue = value === '1' ? 'Yes' : 'No';
            }
            
            previewHTML += `
                <tr>
                    <th class="fw-semibold text-dark" style="width: 40%">${labels[key] || key}</th>
                    <td>${displayValue}</td>
                </tr>
            `;
        }
        
        previewTable.innerHTML = previewHTML;
    });
});
</script>
@endpush
@endsection