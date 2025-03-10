@extends('layouts.app')

@push('styles')
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #2c3e50;
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
        max-width: 960px;
        margin: 0 auto;
        padding: 40px 20px;
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
        padding: 30px;
    }

    .form-section {
        margin-bottom: 30px;
        padding: 20px;
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
                                <input type="text" name="secondary_roll" class="form-control @error('secondary_roll') is-invalid @enderror" id="secondary_roll" value="{{ old('secondary_roll') }}" required placeholder="Enter Secondary Roll No.">
                                <label for="secondary_roll">Secondary Roll No.</label>
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
                                <select name="category" class="form-select @error('category') is-invalid @enderror" id="category" required>
                                    <option value="">Select Category</option>
                                    <option value="UR" {{ old('category') == 'UR' ? 'selected' : '' }}>UR</option>
                                    <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                    <option value="OBC A" {{ old('category') == 'OBC A' ? 'selected' : '' }}>OBC A</option>
                                    <option value="OBC B" {{ old('category') == 'OBC B' ? 'selected' : '' }}>OBC B</option>
                                </select>
                                <label for="category">Category</label>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    <h5 class="section-title"><i class="bi bi-lock-fill"></i>Account Security</h5>
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
                                        </select>
                                        <label>State</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[0][district]" class="form-select district-select" id="present_district" required>
                                            <option value="">Select District</option>
                                        </select>
                                        <label>District</label>
                                    </div>
                                </div>
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
                                        </select>
                                        <label>State</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select name="addresses[1][district]" class="form-select district-select" id="permanent_district" required>
                                            <option value="">Select District</option>
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
                        <div class="mb-3 academic-entry">
                            <div class="row g-3">
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
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[0][year_passed]" class="form-control" value="{{ old('academic_qualifications.0.year_passed') }}" required pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Higher Secondary -->
                        <div class="mb-3 academic-entry">
                            <div class="row g-3">
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
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[1][year_passed]" class="form-control" value="{{ old('academic_qualifications.1.year_passed') }}" required pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Graduation -->
                        <div class="mb-3 academic-entry">
                            <div class="row g-3">
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
                                        <input name="academic_qualifications[2][institute]" class="form-control" value="{{ old('academic_qualifications.2.institute') }}" placeholder="Enter Institute">
                                        <label>Institute</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][board_university]" class="form-control" value="{{ old('academic_qualifications.2.board_university') }}" placeholder="Enter Board/University">
                                        <label>Board/University</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input name="academic_qualifications[2][year_passed]" class="form-control" value="{{ old('academic_qualifications.2.year_passed') }}" pattern="[0-9]{4}" placeholder="Enter Year">
                                        <label>Year Passed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2" onclick="addAcademic()">Add Qualification</button>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#previewModal">
                        <i class="bi bi-eye me-1"></i>Preview
                    </button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
                <div class="text-center mt-3 footer-links">
                    <small>Already have an account? <a href="{{ route('login') }}">Log in</a> | <a href="#">Terms</a> | <a href="#">Privacy</a></small>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel"><i class="bi bi-eye me-2"></i>Registration Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-section">
                    <h6><i class="bi bi-person-circle"></i>Personal Information</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody id="personalPreview"></tbody>
                    </table>
                </div>
                <div class="table-section">
                    <h6><i class="bi bi-telephone-fill"></i>Contact Information</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody id="contactPreview"></tbody>
                    </table>
                </div>
                <div class="table-section">
                    <h6><i class="bi bi-geo-alt-fill"></i>Address Details</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody id="addressPreview"></tbody>
                    </table>
                </div>
                <div class="table-section">
                    <h6><i class="bi bi-book-fill"></i>Academic Qualifications</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Institute</th>
                                <th>Board/University</th>
                                <th>Year Passed</th>
                            </tr>
                        </thead>
                        <tbody id="academicPreview"></tbody>
                    </table>
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                    <label class="form-check-label" for="termsAgreement">
                        I agree to the <a href="#" class="text-accent">Terms</a> and <a href="#" class="text-accent">Privacy Policy</a>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-primary" id="submitFromModal" disabled>Create Account</button>
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
            "YSR Kadapa", "Nellore"
        ],
        "Arunachal Pradesh": [
            "Tawang", "West Kameng", "East Kameng", "Papum Pare", "Kurung Kumey",
            "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "East Siang"
        ]
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Populate states
        const stateSelects = document.querySelectorAll('.state-select');
        stateSelects.forEach(select => {
            Object.keys(indiaStatesDistricts).forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                select.appendChild(option);
            });
        });

        // Form validation
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Preview Modal
        const previewModal = document.getElementById('previewModal');
        previewModal.addEventListener('show.bs.modal', () => {
            const formData = new FormData(form);

            // Personal Information
            const personalPreview = document.getElementById('personalPreview');
            personalPreview.innerHTML = '';
            const personalFields = [
                { label: 'Secondary Roll No.', key: 'secondary_roll' },
                { label: 'First Name', key: 'first_name' },
                { label: 'Last Name', key: 'last_name' },
                { label: 'Gender', key: 'gender' },
                { label: 'Date of Birth', key: 'dob' },
                { label: 'Category', key: 'category' },
            ];
            personalFields.forEach(field => {
                const value = formData.get(field.key) || 'Not Provided';
                personalPreview.innerHTML += `<tr><td>${field.label}</td><td>${value}</td></tr>`;
            });

            // Contact Information
            const contactPreview = document.getElementById('contactPreview');
            contactPreview.innerHTML = '';
            const contactFields = [
                { label: 'Email', key: 'email' },
                { label: 'Mobile', key: 'mobile' },
            ];
            contactFields.forEach(field => {
                const value = formData.get(field.key) || 'Not Provided';
                contactPreview.innerHTML += `<tr><td>${field.label}</td><td>${value}</td></tr>`;
            });

            // Address Details
            const addressPreview = document.getElementById('addressPreview');
            addressPreview.innerHTML = '';
            const addressFields = [
                { label: 'Present Address Line 1', key: 'addresses[0][address_line1]' },
                { label: 'Present Post Office', key: 'addresses[0][post_office]' },
                { label: 'Present State', key: 'addresses[0][state]' },
                { label: 'Present District', key: 'addresses[0][district]' },
                { label: 'Present Pin Code', key: 'addresses[0][pin_code]' },
                { label: 'Permanent Address Line 1', key: 'addresses[1][address_line1]' },
                { label: 'Permanent Post Office', key: 'addresses[1][post_office]' },
                { label: 'Permanent State', key: 'addresses[1][state]' },
                { label: 'Permanent District', key: 'addresses[1][district]' },
                { label: 'Permanent Pin Code', key: 'addresses[1][pin_code]' },
            ];
            addressFields.forEach(field => {
                const value = formData.get(field.key) || 'Not Provided';
                addressPreview.innerHTML += `<tr><td>${field.label}</td><td>${value}</td></tr>`;
            });

            // Academic Qualifications
            const academicPreview = document.getElementById('academicPreview');
            academicPreview.innerHTML = '';
            document.querySelectorAll('.academic-entry').forEach((entry, index) => {
                const level = formData.get(`academic_qualifications[${index}][level]`) || 'Not Provided';
                const institute = formData.get(`academic_qualifications[${index}][institute]`) || 'Not Provided';
                const board = formData.get(`academic_qualifications[${index}][board_university]`) || 'Not Provided';
                const year = formData.get(`academic_qualifications[${index}][year_passed]`) || 'Not Provided';
                academicPreview.innerHTML += `
                    <tr>
                        <td>${level}</td>
                        <td>${institute}</td>
                        <td>${board}</td>
                        <td>${year}</td>
                    </tr>
                `;
            });
        });

        // Terms Agreement
        const termsCheckbox = document.getElementById('termsAgreement');
        const submitButton = document.getElementById('submitFromModal');
        termsCheckbox.addEventListener('change', () => {
            submitButton.disabled = !termsCheckbox.checked;
        });

        // Submit from Modal
        submitButton.addEventListener('click', () => {
            if (form.checkValidity()) {
                form.submit();
            }
        });
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

    function addAcademic() {
        const container = document.getElementById('academic-container');
        const index = container.children.length;
        const html = `
            <div class="mb-3 academic-entry">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select name="academic_qualifications[${index}][level]" class="form-select" required>
                                <option value="">Select Level</option>
                                <option value="Post Graduation">Post Graduation</option>
                                <option value="Others">Others</option>
                            </select>
                            <label>Level</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][institute]" class="form-control" required placeholder="Enter Institute">
                            <label>Institute</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][board_university]" class="form-control" required placeholder="Enter Board/University">
                            <label>Board/University</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][year_passed]" class="form-control" required pattern="[0-9]{4}" placeholder="Enter Year">
                            <label>Year Passed</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
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
</script>
@endpush
@endsection