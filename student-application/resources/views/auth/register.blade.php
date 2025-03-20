@extends('layouts.app')

@push('styles')
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #136ffe; /* #2c3e50; */
        --primary-light: #34495e;
        --secondary: #7f8c8d;
        --accent: #3498db;
        --success: #2ecc71;
        --danger: #e74c3c;
        --light: #ecf0f1;
        --border: #dcdcdc;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    body {
        background: var(--light);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--primary);
    }

    .container {
        /* max-width: 960px; */
        margin: 0 auto;
        /* padding: 40px 20px; */
    }

    .card {
        border: none;
        border-radius: 8px;
        background: white;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        background: var(--primary);
        color: white;
        padding: 20px;
        text-align: center;
        border-bottom: 4px solid var(--accent);
    }

    .card-body {
        padding: 10px;
    }

    .form-section {
        margin-bottom: 30px;
        padding: 10px;
        background: #fafafa;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        color: var(--accent);
    }

    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid var(--border);
        padding: 12px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .form-floating label {
        color: var(--secondary);
        font-size: 0.9rem;
        padding: 12px;
    }

    .btn-primary {
        background: var(--accent);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 6px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background: var(--primary);
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        border-color: var(--accent);
        color: var(--accent);
        padding: 12px 24px;
        border-radius: 6px;
    }

    .btn-outline-primary:hover {
        background: var(--accent);
        color: white;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: var(--primary);
        color: white;
        border-bottom: 3px solid var(--accent);
    }

    .modal-body {
        padding: 20px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background: var(--primary-light);
        color: white;
        font-weight: 600;
        padding: 12px;
    }

    .table td {
        padding: 12px;
        vertical-align: middle;
    }
</style>
<!--  -->
<style>
    .preview-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-family: 'Arial', sans-serif;
    }

    .preview-table th,
    .preview-table td {
        padding: 10px 15px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .preview-table th {
        background-color: #f5f5f5;
        color: #333;
        font-weight: 600;
        width: 25%;
    }

    .preview-table td {
        color: #444;
    }

    .section-title {
        background-color: #e9ecef;
        padding: 8px 15px;
        margin: 15px 0 5px 0;
        font-size: 1rem;
        font-weight: 500;
        border-left: 4px solid #007bff;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-content {
        border-radius: 5px;
    }

/* Spinner */
.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Student Registration</h2>
            <small class="text-light">Create your account to get started</small>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" id="registrationForm" class="needs-validation" novalidate>
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-person-circle"></i>Personal Information</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="secondary_roll" class="form-control @error('secondary_roll') is-invalid @enderror" id="secondary_roll" value="{{ old('secondary_roll') }}" required placeholder="Enter Secondary Roll No." pattern="[A-Za-z0-9]+" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
                                <label for="secondary_roll">Madhyamik (Class X) Roll No.</label>
                                @error('secondary_roll') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" required placeholder="Enter First Name">
                                <label for="first_name">First Name</label>
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" required placeholder="Enter Last Name">
                                <label for="last_name">Last Name</label>
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Others" {{ old('gender') == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                                <label for="gender">Gender</label>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="dob" value="{{ old('dob') }}" required placeholder="Select Date of Birth">
                                <label for="dob">Date of Birth</label>
                                @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="category" class="form-select @error('category') is-invalid @enderror" id="category" onchange="toggleCategory()" required>
                                    <option value="">Select Category</option>
                                    <option value="Unreserved" {{ old('category') == 'Unreserved' ? 'selected' : '' }}>Unreserved</option>
                                    <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                    <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                </select>
                                <label for="category">Category</label>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- If Category selected as other than UR -->

                        <div id="categoryDetails" class="">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="cat_cert_no" class="form-control @error('cat_cert_no') is-invalid @enderror" id="cat_cert_no" value="{{ old('cat_cert_no') }}" required placeholder="Enter Last Name">
                                        <label for="cat_cert_no">Certificate No.</label>
                                        @error('cat_cert_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="cat_issue_date" class="form-control @error('cat_issue_date') is-invalid @enderror" id="cat_issue_date" value="{{ old('cat_issue_date') }}" required placeholder="Enter Last Name">
                                        <label for="cat_issue_date">Certificate Issue Date.</label>
                                        @error('cat_issue_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="cat_issue_by" class="form-control @error('cat_issue_by') is-invalid @enderror" id="cat_issue_by" value="{{ old('cat_issue_by') }}" required placeholder="Enter Last Name">
                                        <label for="cat_issue_by">Issuing Authority</label>
                                        @error('cat_issue_by') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Highest Qualifcation -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="highest_qualification" class="form-select @error('highest_qualification') is-invalid @enderror" required>
                                    <option value="">Select Highest Qualification</option>
                                    <option value="Postgraduate and above" {{ old('highest_qualification') == 'Postgraduate and above' ? 'selected' : '' }}>Postgraduate and above</option>
                                    <option value="Graduate" {{ old('highest_qualification') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                    <option value="Undergraduate - Final Year" {{ old('highest_qualification') == 'Undergraduate - Final Year' ? 'selected' : '' }}>Undergraduate - Final Year</option>
                                </select>
                                <label for="Highest Qualification">Highest Qualification</label>
                                @error('highest_qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-telephone-fill"></i>Contact Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required placeholder="Enter Email Address">
                                <label for="email">Email Address</label>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ old('mobile') }}" required pattern="[0-9]{10}" placeholder="Enter Mobile Number">
                                <label for="mobile">Mobile Number</label>
                                @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-lock-fill"></i>Account Security: Create Your New Password for Login (Minimum 8 characters)</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating position-relative">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required minlength="8" placeholder="Enter Password">
                                <label for="password">Password</label>
                                <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('password')">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating position-relative">
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required placeholder="Confirm Password">
                                <label for="password_confirmation">Confirm Password</label>
                                <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Details -->
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-geo-alt-fill"></i>Address Details</h5>
                    <div class="row g-3">
                        <!-- Present Address -->
                        <div class="col-md-6" id="present-address">
                            <div class="border p-3 rounded-6">
                                <h6 class="mb-3">Present Address</h6>
                                <input type="hidden" name="addresses[0][type]" value="present">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[0][address_line1]" class="form-control" value="{{ old('addresses.0.address_line1') }}" required placeholder="Enter Address Line 1">
                                        <label>Address Line 1</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[0][post_office]" class="form-control" value="{{ old('addresses.0.post_office') }}" required placeholder="Enter Post Office">
                                        <label>Post Office</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[0][state]" class="form-select state-select" id="present_state" required onchange="updateDistricts(this, 'present_district')">
                                            <option value="">Select State</option>
                                            @foreach(array_keys($indiaStatesDistricts) as $state)
                                                <option value="{{ $state }}" {{ old('addresses.0.state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        <label>State</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[0][district]" class="form-select district-select" id="present_district" required data-old-value="{{ old('addresses.0.district') }}">
                                            <option value="">Select District</option>
                                            <!-- Districts will be populated by JS -->
                                        </select>
                                        <label>District</label>
                                    </div>
                                </div>
                                <!-- State and District -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[0][pin_code]" class="form-control" value="{{ old('addresses.0.pin_code') }}" required pattern="[0-9]{6}" placeholder="Enter Pin Code">
                                        <label>Pin Code</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Permanent Address -->
                        <div class="col-md-6" id="permanent-address">
                            <div class="border p-3 rounded-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Permanent Address</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sameAsPresent" onchange="copyPresentAddress()">
                                        <label class="form-check-label" for="sameAsPresent">Same as Present</label>
                                    </div>
                                </div>
                                <input type="hidden" name="addresses[1][type]" value="permanent">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[1][address_line1]" class="form-control" value="{{ old('addresses.1.address_line1') }}" required placeholder="Enter Address Line 1">
                                        <label>Address Line 1</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[1][post_office]" class="form-control" value="{{ old('addresses.1.post_office') }}" required placeholder="Enter Post Office">
                                        <label>Post Office</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[1][state]" class="form-select state-select" id="permanent_state" required onchange="updateDistricts(this, 'permanent_district')">
                                            <option value="">Select State</option>
                                            @foreach(array_keys($indiaStatesDistricts) as $state)
                                                <option value="{{ $state }}" {{ old('addresses.1.state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        <label>State</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[1][district]" class="form-select district-select" id="permanent_district" required data-old-value="{{ old('addresses.1.district') }}">
                                            <option value="">Select District</option>
                                            <!-- Districts will be populated by JS -->
                                        </select>
                                        <label>District</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input name="addresses[1][pin_code]" class="form-control" value="{{ old('addresses.1.pin_code') }}" required pattern="[0-9]{6}" placeholder="Enter Pin Code">
                                        <label>Pin Code</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Qualifications -->
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-book-fill"></i>Academic Qualifications</h5>
                    <div id="academic-container">
                        <!-- Secondary -->
                        <div class="mb-3 academic-entry" data-required="true">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="academic_qualifications[0][level]" class="form-select" required>
                                            <option value="Secondary" selected>Secondary</option>
                                        </select>
                                        <label>Level</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[0][institute]" class="form-control" value="{{ old('academic_qualifications.0.institute') }}" required placeholder="Enter Institute">
                                        <label>Institute</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[0][board_university]" class="form-control" value="{{ old('academic_qualifications.0.board_university') }}" required placeholder="Enter Board/University">
                                        <label>Board/University</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[0][year_passed]" class="form-control" value="{{ old('academic_qualifications.0.year_passed') }}" required pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[0][subjects]" class="form-control" value="{{ old('academic_qualifications.0.subjects') }}" required placeholder="Enter Subjects">
                                        <label>Subjects</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[0][total_marks]" class="form-control" value="{{ old('academic_qualifications.0.total_marks') }}" required placeholder="Enter Total Marks">
                                        <label>Total Marks</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[0][marks_obtained]" class="form-control" value="{{ old('academic_qualifications.0.marks_obtained') }}" required placeholder="Enter Marks Obtained">
                                        <label>Marks Obtained</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="academic_qualifications[0][cgpa]" class="form-control" value="{{ old('academic_qualifications.0.cgpa') }}" placeholder="Enter Marks Obtained">
                                        <label>GPA/CGPA/SGPA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[0][division]" class="form-control" value="{{ old('academic_qualifications.0.division') }}" placeholder="Enter Marks Obtained">
                                        <label>Division/Grade</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-academic" disabled title="Secondary qualification is required">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Higher Secondary -->
                        <div class="mb-3 academic-entry" data-required="true">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="academic_qualifications[1][level]" class="form-select" required>
                                            <option value="Higher Secondary" selected>Higher Secondary</option>
                                        </select>
                                        <label>Level</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[1][institute]" class="form-control" value="{{ old('academic_qualifications.1.institute') }}" required placeholder="Enter Institute">
                                        <label>Institute</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[1][board_university]" class="form-control" value="{{ old('academic_qualifications.1.board_university') }}" required placeholder="Enter Board/University">
                                        <label>Board/University</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[1][year_passed]" class="form-control" value="{{ old('academic_qualifications.1.year_passed') }}" required pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[1][subjects]" class="form-control" value="{{ old('academic_qualifications.1.subjects') }}" required placeholder="Enter Subjects">
                                        <label>Subjects</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[1][total_marks]" class="form-control" value="{{ old('academic_qualifications.1.total_marks') }}" required placeholder="Enter Total Marks">
                                        <label>Total Marks</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[1][marks_obtained]" class="form-control" value="{{ old('academic_qualifications.1.marks_obtained') }}" required placeholder="Enter Marks Obtained">
                                        <label>Marks Obtained</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="academic_qualifications[1][cgpa]" class="form-control" value="{{ old('academic_qualifications.1.cgpa') }}" placeholder="Enter Marks Obtained">
                                        <label>GPA/CGPA/SGPA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[1][division]" class="form-control" value="{{ old('academic_qualifications.1.division') }}" placeholder="Enter Marks Obtained">
                                        <label>Division/Grade</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-academic" disabled onclick="removeAcademic(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Graduation -->
                        <div class="mb-3 academic-entry" data-required="true">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="academic_qualifications[2][level]" class="form-select">
                                            <option value="Graduation" selected>Graduation</option>
                                        </select>
                                        <label>Level</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][institute]" class="form-control" value="{{ old('academic_qualifications.2.institute') }}" placeholder="Enter Institute" required>
                                        <label>Institute</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][board_university]" class="form-control" value="{{ old('academic_qualifications.2.board_university') }}" placeholder="Enter Board/University" required>
                                        <label>Board/University</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[2][year_passed]" class="form-control" value="{{ old('academic_qualifications.2.year_passed') }}" pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][subjects]" class="form-control" value="{{ old('academic_qualifications.2.subjects') }}" required placeholder="Enter Subjects">
                                        <label>Subjects</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[2][total_marks]" class="form-control" value="{{ old('academic_qualifications.2.total_marks') }}" placeholder="Enter Total Marks">
                                        <label>Total Marks</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" name="academic_qualifications[2][marks_obtained]" class="form-control" value="{{ old('academic_qualifications.2.marks_obtained') }}" placeholder="Enter Marks Obtained">
                                        <label>Marks Obtained</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" name="academic_qualifications[2][cgpa]" class="form-control" value="{{ old('academic_qualifications.2.cgpa') }}" placeholder="Enter GPA/CGPA/SGPA">
                                        <label>GPA/CGPA/SGPA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][division]" class="form-control" value="{{ old('academic_qualifications.2.division') }}" placeholder="Enter Division">
                                        <label>Division/Grade</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-academic" disabled onclick="removeAcademic(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2" onclick="addAcademic()">Add Other Qualifications</button>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <button type="button" class="btn btn-primary" id="createAccountBtn"><i class="bi bi-eye"></i> Preview and Next</button>
                </div>
                <div class="text-center mt-3 footer-links">
                    Already have an account? <a href="{{ route('login') }}">Log in</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="previewModalLabel">Registration Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3" id="previewContent">
                <!-- Preview content will be dynamically added here -->
            </div>
            <div class="modal-footer">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="declarationCheck" required>
                    <label class="form-check-label" for="declarationCheck">
                        I confirm all provided information is accurate
                    </label>
                </div>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmCreateBtn" disabled>Confirm & Proceed <i class="bi bi-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    const indiaStatesDistricts = {
        "Andhra Pradesh": [
            "Anantapur", "Chittoor", "East Godavari", "Guntur", "Krishna", "Kurnool", 
            "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari", 
            "YSR Kadapa", "Nellore", "Alluri Sitharama Raju", "Anakapalli", "Bapatla", 
            "Eluru", "Kakinada", "Konaseema", "Nandyal", "Palnadu", "Parvathipuram Manyam", 
            "Sri Sathya Sai", "Tirupati"
        ],
        "Arunachal Pradesh": [
            "Tawang", "West Kameng", "East Kameng", "Papum Pare", "Kurung Kumey", 
            "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "East Siang", 
            "Siang", "Upper Siang", "Lower Siang", "Lower Dibang Valley", "Dibang Valley", 
            "Anjaw", "Lohit", "Namsai", "Changlang", "Tirap", "Longding", "Kamle", 
            "Pakke-Kessang", "Lepa Rada", "Shi-Yomi"
        ],
        "Assam": [
            "Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", 
            "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", 
            "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup", 
            "Kamrup Metropolitan", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", 
            "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", 
            "South Salmara-Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"
        ],
        "Bihar": [
            "Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", 
            "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", 
            "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", 
            "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", 
            "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", 
            "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"
        ],
        "Chhattisgarh": [
            "Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", 
            "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Gaurela-Pendra-Marwahi", 
            "Janjgir-Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", 
            "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", 
            "Rajnandgaon", "Sukma", "Surajpur", "Surguja"
        ],
        "Goa": [
            "North Goa", "South Goa"
        ],
        "Gujarat": [
            "Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", 
            "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhoomi Dwarka", 
            "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", 
            "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", 
            "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", 
            "Tapi", "Vadodara", "Valsad"
        ],
        "Haryana": [
            "Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", 
            "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", 
            "Nuh", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", 
            "Sonipat", "Yamunanagar"
        ],
        "Himachal Pradesh": [
            "Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul and Spiti", 
            "Mandi", "Shimla", "Sirmaur", "Solan", "Una"
        ],
        "Jharkhand": [
            "Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", 
            "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", 
            "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", 
            "Sahebganj", "Seraikela Kharsawan", "Simdega", "West Singhbhum"
        ],
        "Karnataka": [
            "Bagalkot", "Ballari", "Belagavi", "Bengaluru Rural", "Bengaluru Urban", 
            "Bidar", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", 
            "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Hassan", "Haveri", 
            "Kalaburagi", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysuru", "Raichur", 
            "Ramanagara", "Shivamogga", "Tumakuru", "Udupi", "Uttara Kannada", "Vijayapura", 
            "Yadgir"
        ],
        "Kerala": [
            "Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", 
            "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", 
            "Thiruvananthapuram", "Thrissur", "Wayanad"
        ],
        "Madhya Pradesh": [
            "Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", 
            "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", 
            "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", 
            "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", 
            "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Niwari", "Panna", 
            "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna", "Sehore", "Seoni", 
            "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", 
            "Ujjain", "Umaria", "Vidisha"
        ],
        "Maharashtra": [
            "Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", 
            "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", 
            "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", 
            "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", 
            "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", 
            "Thane", "Wardha", "Washim", "Yavatmal"
        ],
        "Manipur": [
            "Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", 
            "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", 
            "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"
        ],
        "Meghalaya": [
            "East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", 
            "Ri-Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", 
            "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"
        ],
        "Mizoram": [
            "Aizawl", "Champhai", "Hnahthial", "Khawzawl", "Kolasib", "Lawngtlai", 
            "Lunglei", "Mamit", "Saiha", "Saitual", "Serchhip"
        ],
        "Nagaland": [
            "Chumoukedima", "Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", 
            "Mon", "Niuland", "Noklak", "Peren", "Phek", "Shamator", "Tseminyu", 
            "Tuensang", "Wokha", "Zunheboto"
        ],
        "Odisha": [
            "Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", 
            "Deogarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", 
            "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", 
            "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", 
            "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundargarh"
        ],
        "Punjab": [
            "Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", 
            "Ferozepur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", 
            "Malerkotla", "Mansa", "Moga", "Muktsar", "Pathankot", "Patiala", "Rupnagar", 
            "Sangrur", "SAS Nagar", "Shaheed Bhagat Singh Nagar", "Tarn Taran"
        ],
        "Rajasthan": [
            "Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", 
            "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", 
            "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", 
            "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", 
            "Sawai Madhopur", "Sikar", "Sirohi", "Sri Ganganagar", "Tonk", "Udaipur"
        ],
        "Sikkim": [
            "East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"
        ],
        "Tamil Nadu": [
            "Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", 
            "Dindigul", "Erode", "Kallakurichi", "Kanchipuram", "Kanyakumari", "Karur", 
            "Krishnagiri", "Madurai", "Mayiladuthurai", "Nagapattinam", "Namakkal", 
            "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", 
            "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi", 
            "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", 
            "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"
        ],
        "Telangana": [
            "Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", 
            "Jayashankar Bhupalpally", "Jogulamba Gadwal", "Kamareddy", "Karimnagar", 
            "Khammam", "Kumuram Bheem Asifabad", "Mahabubabad", "Mahbubnagar", 
            "Mancherial", "Medak", "Medchal-Malkajgiri", "Mulugu", "Nagarkurnool", 
            "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", 
            "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", 
            "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"
        ],
        "Tripura": [
            "Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", 
            "Unakoti", "West Tripura"
        ],
        "Uttar Pradesh": [
            "Agra", "Aligarh", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Ayodhya", 
            "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", 
            "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", 
            "Chitrakoot", "Deoria", "Etah", "Etawah", "Farrukhabad", "Fatehpur", "Firozabad", 
            "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", 
            "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", 
            "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", 
            "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", 
            "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", 
            "Prayagraj", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", 
            "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", 
            "Sultanpur", "Unnao", "Varanasi"
        ],
        "Uttarakhand": [
            "Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", 
            "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal", 
            "Udham Singh Nagar", "Uttarkashi"
        ],
        "West Bengal": [
            "Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", 
            "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", 
            "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", 
            "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", 
            "Purulia", "South 24 Parganas", "Uttar Dinajpur"
        ],
        // Union Territories
        "Andaman and Nicobar Islands": [
            "Nicobar", "North and Middle Andaman", "South Andaman"
        ],
        "Chandigarh": [
            "Chandigarh"
        ],
        "Dadra and Nagar Haveli and Daman and Diu": [
            "Dadra and Nagar Haveli", "Daman", "Diu"
        ],
        "Delhi": [
            "Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", 
            "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", 
            "South West Delhi", "West Delhi"
        ],
        "Jammu and Kashmir": [
            "Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", 
            "Jammu", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Poonch", "Pulwama", 
            "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"
        ],
        "Ladakh": [
            "Kargil", "Leh"
        ],
        "Lakshadweep": [
            "Lakshadweep"
        ],
        "Puducherry": [
            "Karaikal", "Mahe", "Puducherry", "Yanam"
        ]
    };

    document.addEventListener('DOMContentLoaded', () => {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '5000',
        };

        const stateSelects = document.querySelectorAll('.state-select');
        stateSelects.forEach(select => {
            const selectedState = select.value;
            if (selectedState) {
                const districtSelectId = select.id === 'present_state' ? 'present_district' : 'permanent_district';
                updateDistricts(select, districtSelectId);
                const districtSelect = document.getElementById(districtSelectId);
                const oldDistrict = districtSelect.dataset.oldValue || '';
                if (oldDistrict) districtSelect.value = oldDistrict;
            }
        });

        const oldAcademic = @json(old('academic_qualifications', []));
        if (oldAcademic.length > 3) {
            for (let i = 3; i < oldAcademic.length; i++) {
                addAcademic(oldAcademic[i]);
            }
        }

        toggleCategory();
    });

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('i');
        field.type = field.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

    function copyPresentAddress() {
        const checkbox = document.getElementById('sameAsPresent');
        const presentFields = document.querySelectorAll('#present-address .form-control, #present-address .form-select');
        const permanentFields = document.querySelectorAll('#permanent-address .form-control, #permanent-address .form-select');

        if (checkbox.checked) {
            presentFields.forEach((field, index) => {
                if (permanentFields[index]) {
                    permanentFields[index].value = field.value;
                    if (field.id === 'present_state') {
                        updateDistricts(permanentFields[index], 'permanent_district');
                        permanentFields[index + 1].value = document.getElementById('present_district').value;
                    }
                }
            });
        }
    }

    function addAcademic(oldData = null) {
        const container = document.getElementById('academic-container');
        const index = container.querySelectorAll('.academic-entry').length;
        const html = `
            <hr>
            <div class="mb-3 academic-entry">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select name="academic_qualifications[${index}][level]" class="form-select" required>
                                <option value="">Select Level</option>
                                <option value="Post Graduation" ${oldData?.level === 'Post Graduation' ? 'selected' : ''}>Post Graduation</option>
                                <option value="Other" ${oldData?.level === 'Other' ? 'selected' : ''}>Other</option>
                            </select>
                            <label>Level</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][institute]" class="form-control" value="${oldData?.institute || ''}" required placeholder="Enter Institute">
                            <label>Institute</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][board_university]" class="form-control" value="${oldData?.board_university || ''}" required placeholder="Enter Board/University">
                            <label>Board/University</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" name="academic_qualifications[${index}][year_passed]" class="form-control" value="${oldData?.year_passed || ''}" required pattern="[0-9]{4}" placeholder="Enter Year">
                            <label>Year Passed</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][subjects]" class="form-control" value="${oldData?.subjects || ''}" required placeholder="Enter Subjects">
                            <label>Subjects</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" name="academic_qualifications[${index}][total_marks]" class="form-control" value="${oldData?.total_marks || ''}" required placeholder="Enter Total Marks">
                            <label>Total Marks</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" name="academic_qualifications[${index}][marks_obtained]" class="form-control" value="${oldData?.marks_obtained || ''}" required placeholder="Enter Marks Obtained">
                            <label>Marks Obtained</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" step="0.01" name="academic_qualifications[${index}][cgpa]" class="form-control" value="${oldData?.cgpa || ''}" placeholder="Enter GPA/CGPA/SGPA">
                            <label>GPA/CGPA/SGPA</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][division]" class="form-control" value="${oldData?.division || ''}" placeholder="Enter Division">
                            <label>Division/Grade</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-academic" onclick="removeAcademic(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeAcademic(button) {
        const entry = button.closest('.academic-entry');
        if (!entry.dataset.required) {
            entry.previousElementSibling.remove();
            entry.remove();
            toastr.success('Academic qualification removed successfully');
        } else {
            toastr.warning('Cannot remove required qualification');
        }
    }

    function updateDistricts(stateSelect, districtSelectId) {
        const districtSelect = document.getElementById(districtSelectId);
        districtSelect.innerHTML = '<option value="">Select District</option>';
        const selectedState = stateSelect.value;
        if (selectedState && indiaStatesDistricts[selectedState]) {
            indiaStatesDistricts[selectedState].forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    }

    function toggleCategory() {
        const caste = document.getElementById('category').value;
        const certificateDetails = document.getElementById('categoryDetails');
        const requiredCastes = ['SC', 'ST', 'OBC', 'OBC B'];
        const inputs = certificateDetails.querySelectorAll('input');
        
        if (requiredCastes.includes(caste)) {
            certificateDetails.style.display = 'block';
            inputs.forEach(input => input.required = true);
        } else {
            certificateDetails.style.display = 'none';
            inputs.forEach(input => {
                input.required = false;
                input.value = '';
            });
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const createBtn = document.getElementById('createAccountBtn');
        const confirmBtn = document.getElementById('confirmCreateBtn');
        const declarationCheck = document.getElementById('declarationCheck');

        createBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (form.checkValidity()) {
                showPreviewModal();
                toastr.success('Preview generated successfully');
            } else {
                form.classList.add('was-validated');
                const invalidFields = form.querySelectorAll(':invalid');
                invalidFields.forEach(field => {
                    const readableName = getReadableFieldName(field);
                    toastr.error(`Please fill in "${readableName}" correctly`);
                });
            }
        });

        declarationCheck.addEventListener('change', function() {
            confirmBtn.disabled = !this.checked;
            if (this.checked) {
                toastr.info('Declaration confirmed');
            }
        });

        confirmBtn.addEventListener('click', function() {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner"></span>Processing...';
            toastr.info('Submitting registration...');
            form.submit();
        });

        function getReadableFieldName(field) {
            const name = field.name;
            const label = field.labels[0]?.textContent || '';

            // If there's a label, use it
            if (label) return label;

            // Parse complex field names like academic_qualifications[2][subjects]
            if (name.includes('academic_qualifications')) {
                const match = name.match(/academic_qualifications\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = parseInt(match[1], 10);
                    const fieldName = match[2];
                    const levelMap = {
                        0: 'Secondary',
                        1: 'Higher Secondary',
                        2: 'Graduation'
                    };
                    const level = levelMap[index] || `Additional Qualification ${index - 2}`;
                    const fieldMap = {
                        'level': 'Level',
                        'institute': 'Institute',
                        'board_university': 'Board/University',
                        'year_passed': 'Year Passed',
                        'subjects': 'Subjects',
                        'total_marks': 'Total Marks',
                        'marks_obtained': 'Marks Obtained',
                        'cgpa': 'GPA/CGPA/SGPA',
                        'division': 'Division/Grade'
                    };
                    return `${level} ${fieldMap[fieldName] || fieldName}`;
                }
            }

            // Handle address fields
            if (name.includes('addresses')) {
                const match = name.match(/addresses\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const type = match[1] === '0' ? 'Present' : 'Permanent';
                    const fieldName = match[2];
                    const fieldMap = {
                        'address_line1': 'Address Line 1',
                        'post_office': 'Post Office',
                        'state': 'State',
                        'district': 'District',
                        'pin_code': 'Pin Code'
                    };
                    return `${type} ${fieldMap[fieldName] || fieldName}`;
                }
            }

            // Fallback to simple field names
            const simpleFieldMap = {
                'secondary_roll': 'Secondary Roll No.',
                'first_name': 'First Name',
                'last_name': 'Last Name',
                'gender': 'Gender',
                'dob': 'Date of Birth',
                'category': 'Category',
                'cat_cert_no': 'Category Certificate No.',
                'cat_issue_date': 'Category Certificate Issue Date',
                'cat_issue_by': 'Category Certificate Issuing Authority',
                'highest_qualification': 'Highest Qualification',
                'email': 'Email Address',
                'mobile': 'Mobile Number',
                'password': 'Password',
                'password_confirmation': 'Password Confirmation'
            };
            return simpleFieldMap[name] || name.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
        }

        function showPreviewModal() {
            const previewContent = document.getElementById('previewContent');
            previewContent.innerHTML = '';
            const formData = new FormData(form);
            let previewHTML = '';

            previewHTML += '<div class="section-title">Personal Information</div>';
            previewHTML += '<table class="preview-table">';
            previewHTML += createTableRow('Secondary Roll No.', formData.get('secondary_roll'));
            previewHTML += createTableRow('Full Name', `${formData.get('first_name')} ${formData.get('last_name')}`);
            previewHTML += createTableRow('Gender', formData.get('gender'));
            previewHTML += createTableRow('Date of Birth (YYYY-MM-DD)', formData.get('dob'));
            previewHTML += createTableRow('Category', formData.get('category'));
            if (formData.get('cat_cert_no')) {
                previewHTML += createTableRow('Certificate No.', formData.get('cat_cert_no'));
                previewHTML += createTableRow('Date of issue (YYYY-MM-DD)', formData.get('cat_issue_date'));
                previewHTML += createTableRow('Issuing Authority', formData.get('cat_issue_by'));
            }
            previewHTML += createTableRow('Highest Qualification', formData.get('highest_qualification'));
            previewHTML += '</table>';

            previewHTML += '<div class="section-title">Contact Information</div>';
            previewHTML += '<table class="preview-table">';
            previewHTML += createTableRow('Email Address', formData.get('email'));
            previewHTML += createTableRow('Mobile Number', formData.get('mobile'));
            previewHTML += '</table>';

            previewHTML += '<div class="section-title">Present Address</div>';
            previewHTML += '<table class="preview-table">';
            previewHTML += createTableRow('Address Line', formData.get('addresses[0][address_line1]'));
            previewHTML += createTableRow('Post Office', formData.get('addresses[0][post_office]'));
            previewHTML += createTableRow('State', formData.get('addresses[0][state]'));
            previewHTML += createTableRow('District', formData.get('addresses[0][district]'));
            previewHTML += createTableRow('Pin Code', formData.get('addresses[0][pin_code]'));
            previewHTML += '</table>';

            previewHTML += '<div class="section-title">Permanent Address</div>';
            previewHTML += '<table class="preview-table">';
            previewHTML += createTableRow('Address Line', formData.get('addresses[1][address_line1]'));
            previewHTML += createTableRow('Post Office', formData.get('addresses[1][post_office]'));
            previewHTML += createTableRow('State', formData.get('addresses[1][state]'));
            previewHTML += createTableRow('District', formData.get('addresses[1][district]'));
            previewHTML += createTableRow('Pin Code', formData.get('addresses[1][pin_code]'));
            previewHTML += '</table>';

            previewHTML += '<div class="section-title">Academic Qualifications</div>';
            previewHTML += '<table class="preview-table">';
            previewHTML += '<tr><th>Level</th><th>Institute</th><th>Board/University</th><th>Year</th><th>Subjects</th><th>Total Marks</th><th>Marks Obtained</th><th>GPA/CGPA</th><th>Division/Grade</th></tr>';
            
            const academicEntries = document.querySelectorAll('.academic-entry');
            academicEntries.forEach((entry, index) => {
                previewHTML += '<tr>';
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][level]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][institute]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][board_university]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][year_passed]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][subjects]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][total_marks]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][marks_obtained]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][cgpa]`) || ''}</td>`;
                previewHTML += `<td>${formData.get(`academic_qualifications[${index}][division]`) || ''}</td>`;
                previewHTML += '</tr>';
            });
            previewHTML += '</table>';

            previewContent.innerHTML = previewHTML;
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }

        function createTableRow(label, value) {
            if (value) {
                return `<tr><th scope="row">${label}</th><td>${value}</td></tr>`;
            }
            return '';
        }
    });
</script>
@endpush
@endsection