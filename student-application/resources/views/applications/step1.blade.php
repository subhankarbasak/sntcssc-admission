@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-person me-2"></i>Application Step 1: Personal Details</h4>
    <form id="applicationForm" method="POST" action="{{ route('application.store.step1', $advertisement) }}" class="needs-validation" novalidate>
        @csrf
        <!-- Advertisement Selection -->
        <div class="mb-4">
            <label class="form-label fw-semibold text-dark required">Programme Selection</label>
            <select name="advertisement_program_id" class="form-select" required>
                <option value="">Select Program</option>
                @foreach($advertisement->programs as $program)
                    <option value="{{ $program->id }}" {{ old('advertisement_program_id') == $program->id ? 'selected' : '' }} selected>
                        {{ $program->batchProgram->program->name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Please select a program.</div>
        </div>

        <!-- Student Details -->
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">First Name</label>
                <input type="text" name="first_name" class="form-control" 
                       value="{{ $profile->first_name ?? $student->first_name }}" placeholder="First Name" required readonly>
                <div class="invalid-feedback">First name is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Last Name</label>
                <input type="text" name="last_name" class="form-control" 
                       value="{{ $profile->last_name ?? $student->last_name }}" placeholder="Last Name" required readonly>
                <div class="invalid-feedback">Last name is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Date of Birth</label>
                <input type="date" name="dob" class="form-control" 
                       value="{{ old('dob', $profile->dob ?? $student->dob) }}" required>
                <div class="invalid-feedback">Date of birth is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender', $profile->gender ?? $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $profile->gender ?? $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $profile->gender ?? $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <div class="invalid-feedback">Please select a gender.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Are you Person with Benchmark Disability (PwBD)?</label>
                <select name="is_pwbd" class="form-select" required>
                    <option value="">Select one</option>
                    <option value="1" {{ old('is_pwbd', $profile->is_pwbd ?? $student->is_pwbd) == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_pwbd', $profile->is_pwbd ?? $student->is_pwbd) == '0' ? 'selected' : '' }}>No</option>
                </select>
                <div class="invalid-feedback">Please select options for Benchmark Disability.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Category</label>
                <select name="category" class="form-select" id="category" onchange="toggleCategory()" required>
                    <option value="">Select Category</option>
                    <option value="UR" {{ old('category', $profile->category ?? $student->category) == 'UR' ? 'selected' : '' }}>UR</option>
                    <option value="SC" {{ old('category', $profile->category ?? $student->category) == 'SC' ? 'selected' : '' }}>SC</option>
                    <option value="ST" {{ old('category', $profile->category ?? $student->category) == 'ST' ? 'selected' : '' }}>ST</option>
                    <option value="OBC A" {{ old('category', $profile->category ?? $student->category) == 'OBC A' ? 'selected' : '' }}>OBC A</option>
                    <option value="OBC B" {{ old('category', $profile->category ?? $student->category) == 'OBC B' ? 'selected' : '' }}>OBC B</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
            </div>
            <!-- If Category selected as other than UR -->

            <div id="categoryDetails" class="">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="cat_cert_no" class="form-control @error('cat_cert_no') is-invalid @enderror" id="cat_cert_no" value="{{ old('cat_cert_no', $profile->cat_cert_no ?? $student->cat_cert_no) }}" required>
                            <label for="cat_cert_no">Certificate No.</label>
                            @error('cat_cert_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="date" name="cat_issue_date" class="form-control @error('cat_issue_date') is-invalid @enderror" id="cat_issue_date" value="{{ old('cat_issue_date', $profile->cat_issue_date ?? $student->cat_issue_date) }}" required>
                            <label for="cat_issue_date">Certificate Issue Date.</label>
                            @error('cat_issue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="cat_issue_by" class="form-control @error('cat_issue_by') is-invalid @enderror" id="cat_issue_by" value="{{ old('cat_issue_by', $profile->cat_issue_by ?? $student->cat_issue_by) }}" required>
                            <label for="cat_issue_by">Issuing Authority</label>
                            @error('cat_issue_by') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- Highest Qualifcation -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required" for="Highest Qualification">Highest Qualification</label>
                    <select name="highest_qualification" class="form-select @error('highest_qualification') is-invalid @enderror" required>
                        <option value="">Select Highest Qualification</option>
                        <option value="Graduate" {{ old('highest_qualification', $profile->highest_qualification ?? $student->highest_qualification) == 'Graduate' ? 'selected' : '' }}>Graduation Completed</option>
                        <option value="Post Graduate" {{ old('highest_qualification', $profile->highest_qualification ?? $student->highest_qualification) == 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                        <option value="Final Undergraduate Semester" {{ old('highest_qualification', $profile->highest_qualification ?? $student->highest_qualification) == 'Final Undergraduate Semester' ? 'selected' : '' }}>Final Undergraduate Semester</option>
                    </select>
                    @error('highest_qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror

            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Occupation</label>
                <input type="text" name="occupation" class="form-control" 
                       value="{{ old('occupation', $profile->occupation ?? $student->occupation) }}" placeholder="Occupation" required>
                <div class="invalid-feedback">Occupation is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Father Name</label>
                <input type="text" name="father_name" class="form-control" 
                       value="{{ old('father_name', $profile->father_name ?? $student->father_name) }}" placeholder="Father Name" required>
                <div class="invalid-feedback">Father Name is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Father Occupation</label>
                <input type="text" name="father_occupation" class="form-control" 
                       value="{{ old('father_occupation', $profile->father_occupation ?? $student->father_occupation) }}" placeholder="Father Occupation" required>
                <div class="invalid-feedback">Father Occupation is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Mother Name</label>
                <input type="text" name="mother_name" class="form-control" 
                       value="{{ old('mother_name', $profile->mother_name ?? $student->mother_name) }}" placeholder="Mother Name" required>
                <div class="invalid-feedback">Mother Name is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Mother Occupation</label>
                <input type="text" name="mother_occupation" class="form-control" 
                       value="{{ old('mother_occupation', $profile->mother_occupation ?? $student->mother_occupation) }}" placeholder="Mother Occupation" required>
                <div class="invalid-feedback">Mother Occupation is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ $profile->email ?? $student->email }}" required readonly>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Mobile Number</label>
                <input type="tel" name="mobile" class="form-control" 
                       value="{{ $profile->mobile ?? $student->mobile }}" required pattern="[0-9]{10}" readonly>
                <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Whatsapp Number</label>
                <input type="tel" name="whatsapp" class="form-control" 
                       value="{{ old('whatsapp', $profile->whatsapp ?? $student->whatsapp) }}" required pattern="[0-9]{10}" placeholder="Whatsapp No.">
                <div class="invalid-feedback">Please enter a valid 10-digit Whatsapp number.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Annual Family Income</label>
                <input type="text" name="family_income" class="form-control" 
                       value="{{ old('family_income', $profile->family_income ?? $student->family_income) }}" placeholder="Annual Family Income" required>
                <div class="invalid-feedback">Annual Family Income is required.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark required">Medium in School</label>
                <select name="school_language" class="form-select" required>
                    <option value="">Select one</option>
                    <option value="Bengali" {{ old('school_language', $profile->school_language ?? $student->school_language) == 'Bengali' ? 'selected' : '' }}>Bengali</option>
                    <option value="English" {{ old('school_language', $profile->school_language ?? $student->school_language) == 'English' ? 'selected' : '' }}>English</option>
                    <option value="Hindi" {{ old('school_language', $profile->school_language ?? $student->school_language) == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                    <option value="Others" {{ old('school_language', $profile->school_language ?? $student->school_language) == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
                <div class="invalid-feedback">Please select a school medium.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Optional Subject</label>
                <select name="optional_subject" class="form-select" required>
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
                        <option value="{{ $subject }}" {{ old('optional_subject', $application->optional_subject ?? '') == $subject ? 'selected' : '' }}>
                            {{ $subject }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Appearing for UPSC CSE 2026?</label>
                <select name="is_appearing_upsc_cse" class="form-select">
                    <option value="1" {{ old('is_appearing_upsc_cse', $application->is_appearing_upsc_cse ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_appearing_upsc_cse', $application->is_appearing_upsc_cse ?? 0) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">UPSC Attempts Count</label>
                <input type="number" name="upsc_attempts_count" class="form-control" 
                       value="{{ old('upsc_attempts_count', $application->upsc_attempts_count ?? 0) }}" min="0">
                <div class="invalid-feedback">Please enter a valid number (0 or more).</div>
            </div>
            <input type="hidden" name="student_id" value="{{ $profile->student_id ?? $student->id }}">
            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
        </div>
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <div></div>
            <div>
                <button type="button" class="btn btn-outline-secondary me-2 shadow-sm" 
                        data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
                <button type="submit" form="applicationForm" class="btn btn-primary px-4 shadow-sm">Save and Next</button>
            </div>
        </div>
    </div>
@endsection

@section('preview')
    <table class="table table-striped table-bordered table-hover">
        <tbody id="previewTable">
            <!-- Populated by JavaScript -->
        </tbody>
    </table>
@endsection

@section('preview-footer')
    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Edit</button>
    <button type="button" class="btn btn-primary shadow-sm" onclick="$('#applicationForm').submit()">Save and Next</button>
@endsection

@push('scripts')
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

        const whatsapp = form.querySelector('input[name="whatsapp"]');
        if (whatsapp.value && !/^[0-9]{10}$/.test(whatsapp.value)) {
            whatsapp.classList.add('is-invalid');
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
            toastr.success('Form saved successfully!');
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
            'is_pwbd': 'Person with Benchmark Disability',
            'occupation': 'Occupation',
            'father_name': 'Father Name',
            'father_occupation': 'Father Occupation',
            'mother_name': 'Mother Name',
            'mother_occupation': 'Mother Occupation',
            'email': 'Email',
            'mobile': 'Mobile Number',
            'whatsapp': 'Whatsapp Number',
            'family_income': 'Annual Family Income',
            'school_language': 'Medium in School',
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
            if (key === 'is_pwbd' || key === 'is_appearing_upsc_cse') {
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

<script>
    // Toggle button for Certificate details

    function toggleCategory() {
        const caste = document.getElementById('category').value;
        const certificateDetails = document.getElementById('categoryDetails');
        const requiredCastes = ['SC', 'ST', 'OBC A', 'OBC B', 'EWS'];
        const caste_no = document.getElementById('cat_cert_no');
        const caste_doi = document.getElementById('cat_issue_date');
        const caste_isby = document.getElementById('cat_issue_by');

        if (requiredCastes.includes(caste)) {
            certificateDetails.style.display = '';
            caste_no.required = true;
            caste_doi.required = true;
            caste_isby.required = true;
        } else {
            certificateDetails.style.display = 'none';
            caste_no.value = '';
            caste_doi.value = '';
            caste_isby.value = '';
            caste_no.required = false;
            caste_doi.required = false;
            caste_isby.required = false;
        }
    }

    // Ensure the correct state is set on page load if a caste is already selected
    document.addEventListener('DOMContentLoaded', function() {
        toggleCategory();
    });
</script>
@endpush

@php
    $step = 1;
    $percentage = 0;
@endphp