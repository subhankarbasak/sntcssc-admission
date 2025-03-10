<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@push('styles')
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --secondary: #6b7280;
        --success: #10b981;
        --danger: #ef4444;
        --light-bg: #f9fafb;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
    }

    .card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-floating label {
        color: var(--secondary);
        font-weight: 500;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.3);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(239, 68, 68, 0.3);
    }

    .btn-primary {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
    }

    .section-header {
        position: relative;
        padding-left: 20px;
        font-size: 1.25rem;
        color: var(--primary-dark);
    }

    .section-header:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 30px;
        width: 5px;
        background: var(--primary-light);
        border-radius: 3px;
    }

    .form-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .table th {
        background: var(--primary-dark);
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .table-hover tbody tr:hover {
        background-color: var(--light-bg);
        transition: background-color 0.2s ease;
    }

    .badge-progress {
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary-dark);
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 20px;
    }

    .footer-text a {
        color: var(--primary-light);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-text a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="container py-5 px-4">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-9">
            <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
                <div class="card-header bg-gradient-primary text-white text-center py-5 position-relative">
                    <h2 class="mb-1 fw-bold animate__animated animate__fadeInDown">Student Registration Portal</h2>
                    <p class="text-white-75 mt-2 animate__animated animate__fadeInUp small fw-medium">Securely create your account to access educational opportunities</p>
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge-progress fw-semibold shadow-sm">Step 1 of 1</span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5 bg-light">
                    <form method="POST" action="{{ route('register') }}" id="registrationForm" class="needs-validation" novalidate>
                        @csrf

                        <!-- Personal Details -->
                        <div class="form-section">
                            <h5 class="mb-4 section-header"><i class="bi bi-person-circle me-2"></i>Personal Information</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="secondary_roll" class="form-control @error('secondary_roll') is-invalid @enderror" id="secondary_roll" placeholder="Secondary Roll No." value="{{ old('secondary_roll') }}" required>
                                        <label for="secondary_roll">Secondary Roll No.</label>
                                        @error('secondary_roll')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                                        <label for="first_name">First Name</label>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                                        <label for="last_name">Last Name</label>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" id="gender" required aria-label="Gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Others" {{ old('gender') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="dob" value="{{ old('dob') }}" required>
                                        <label for="dob">Date of Birth</label>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="category" class="form-select @error('category') is-invalid @enderror" id="category" required aria-label="Category">
                                            <option value="">Select Category</option>
                                            <option value="UR" {{ old('category') == 'UR' ? 'selected' : '' }}>UR</option>
                                            <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                            <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                            <option value="OBC A" {{ old('category') == 'OBC A' ? 'selected' : '' }}>OBC A</option>
                                            <option value="OBC B" {{ old('category') == 'OBC B' ? 'selected' : '' }}>OBC B</option>
                                        </select>
                                        <label for="category">Category</label>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Details -->
                        <div class="form-section">
                            <h5 class="mb-4 section-header"><i class="bi bi-telephone-fill me-2"></i>Contact Information</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}" required>
                                        <label for="email">Email Address</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="Mobile" value="{{ old('mobile') }}" required pattern="[0-9]{10}" aria-describedby="mobileHelp">
                                        <label for="mobile">Mobile Number</label>
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small id="mobileHelp" class="form-text text-muted">Enter 10-digit mobile number</small>
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-section">
                            <h5 class="mb-4 section-header"><i class="bi bi-lock-fill me-2"></i>Account Security</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating position-relative">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required minlength="8" aria-describedby="passwordHelp">
                                        <label for="password">Password</label>
                                        <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle p-2" onclick="togglePassword('password')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating position-relative">
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
                                        <label for="password_confirmation">Confirm Password</label>
                                        <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle p-2" onclick="togglePassword('password_confirmation')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted mt-2">Minimum 8 characters, including letters and numbers</small>
                        </div>

                        <!-- Address Fields -->
                        <div class="form-section">
                            <h5 class="mb-4 section-header"><i class="bi bi-geo-alt-fill me-2"></i>Address Details</h5>
                            <div id="address-container">
                                <!-- Present Address -->
                                <div class="card mb-4 shadow-sm border-0 rounded-3 animate__animated animate__fadeIn" id="present-address">
                                    <div class="card-body p-4">
                                        <h6 class="mb-3 fw-semibold text-dark">Present Address</h6>
                                        <input type="hidden" name="addresses[0][type]" value="present">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="addresses[0][address_line1]" class="form-control" placeholder="Address Line 1" value="{{ old('addresses.0.address_line1') }}" required>
                                                    <label>Address Line 1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="addresses[0][state]" class="form-select state-select" id="present_state" required onchange="updateDistricts(this, 'present_district')">
                                                        <option value="">Select State</option>
                                                        <!-- States will be populated via JavaScript -->
                                                    </select>
                                                    <label>State</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="addresses[0][district]" class="form-select district-select" id="present_district" required>
                                                        <option value="">Select District</option>
                                                    </select>
                                                    <label>District</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="addresses[0][pin_code]" class="form-control" placeholder="Pin Code" value="{{ old('addresses.0.pin_code') }}" required pattern="[0-9]{6}" aria-describedby="pinHelp">
                                                    <label>Pin Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Permanent Address -->
                                <div class="card mb-4 shadow-sm border-0 rounded-3 animate__animated animate__fadeIn" id="permanent-address">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold text-dark">Permanent Address</h6>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="sameAsPresent" onchange="copyPresentAddress()">
                                                <label class="form-check-label fw-medium" for="sameAsPresent">Same as Present</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="addresses[1][type]" value="permanent">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="addresses[1][address_line1]" class="form-control" placeholder="Address Line 1" value="{{ old('addresses.1.address_line1') }}" required>
                                                    <label>Address Line 1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="addresses[1][state]" class="form-select state-select" id="permanent_state" required onchange="updateDistricts(this, 'permanent_district')">
                                                        <option value="">Select State</option>
                                                        <!-- States will be populated via JavaScript -->
                                                    </select>
                                                    <label>State</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="addresses[1][district]" class="form-select district-select" id="permanent_district" required>
                                                        <option value="">Select District</option>
                                                    </select>
                                                    <label>District</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="addresses[1][pin_code]" class="form-control" placeholder="Pin Code" value="{{ old('addresses.1.pin_code') }}" required pattern="[0-9]{6}">
                                                    <label>Pin Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small id="pinHelp" class="form-text text-muted">Enter 6-digit PIN code</small>
                        </div>

                        <!-- Academic Qualifications -->
                        <div class="form-section">
                            <h5 class="mb-4 section-header"><i class="bi bi-book-fill me-2"></i>Academic Qualifications</h5>
                            <div class="table-responsive shadow-sm rounded-3 overflow-hidden">
                                <table class="table table-hover align-middle mb-0" id="academic-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Level</th>
                                            <th scope="col">Institute</th>
                                            <th scope="col">Board/University</th>
                                            <th scope="col">Year Passed</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="academic-container">
                                        <!-- Secondary -->
                                        <tr class="animate__animated animate__fadeIn">
                                            <td>
                                                <div class="form-floating">
                                                    <select name="academic_qualifications[0][level]" class="form-select" required aria-label="Academic Level">
                                                        <option value="Secondary" selected>Secondary</option>
                                                    </select>
                                                    <label>Level</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[0][institute]" class="form-control" placeholder="Institute" value="{{ old('academic_qualifications.0.institute') }}" required>
                                                    <label>Institute</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[0][board_university]" class="form-control" placeholder="Board/University" value="{{ old('academic_qualifications.0.board_university') }}" required>
                                                    <label>Board/University</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[0][year_passed]" class="form-control" placeholder="Year Passed" value="{{ old('academic_qualifications.0.year_passed') }}" required pattern="[0-9]{4}" aria-describedby="yearHelp">
                                                    <label>Year Passed</label>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <!-- Higher Secondary -->
                                        <tr class="animate__animated animate__fadeIn">
                                            <td>
                                                <div class="form-floating">
                                                    <select name="academic_qualifications[1][level]" class="form-select" required aria-label="Academic Level">
                                                        <option value="Higher Secondary" selected>Higher Secondary</option>
                                                    </select>
                                                    <label>Level</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[1][institute]" class="form-control" placeholder="Institute" value="{{ old('academic_qualifications.1.institute') }}" required>
                                                    <label>Institute</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[1][board_university]" class="form-control" placeholder="Board/University" value="{{ old('academic_qualifications.1.board_university') }}" required>
                                                    <label>Board/University</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating">
                                                    <input name="academic_qualifications[1][year_passed]" class="form-control" placeholder="Year Passed" value="{{ old('academic_qualifications.1.year_passed') }}" required pattern="[0-9]{4}">
                                                    <label>Year Passed</label>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-3 rounded-pill fw-medium" onclick="addAcademic()">
                                <i class="bi bi-plus-circle me-2"></i>Add Qualification
                            </button>
                            <small id="yearHelp" class="form-text text-muted d-block mt-2">Enter year in YYYY format</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-3 text-center">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">Complete Registration</button>
                            <p class="footer-text text-muted small mt-3">By registering, you agree to our <a href="#" class="fw-medium">Terms & Conditions</a> and <a href="#" class="fw-medium">Privacy Policy</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // State and District Data (Sample - Expand with full list or fetch from API)
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

    // Populate states on page load
    document.addEventListener('DOMContentLoaded', () => {
        const stateSelects = document.querySelectorAll('.state-select');
        stateSelects.forEach(select => {
            const states = Object.keys(indiaStatesDistricts);
            states.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                select.appendChild(option);
            });
            // Set old value if available
            const oldState = select.getAttribute('data-old-value');
            if (oldState && indiaStatesDistricts[oldState]) {
                select.value = oldState;
                updateDistricts(select, select.id.replace('state', 'district'));
            }
        });
    });

    // Update districts based on selected state
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

    // Bootstrap form validation
    (function () {
        'use strict';
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
    })();

    // Toastr configuration
    toastr.options = {
        "positionClass": "toast-top-right",
        "progressBar": true,
        "timeOut": 5000,
        "closeButton": true,
        "preventDuplicates": true,
        "newestOnTop": true
    };

    @if(session('toastr'))
        toastr["{{ session('toastr.type') }}"]("{{ session('toastr.message') }}");
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        });
    @endif

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        const isPassword = field.type === 'password';
        field.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isPassword);
        icon.classList.toggle('bi-eye-slash', isPassword);
    }

    function copyPresentAddress() {
        const checkbox = document.getElementById('sameAsPresent');
        if (checkbox.checked) {
            const presentInputs = document.querySelectorAll('#present-address input:not([type="hidden"]), #present-address select');
            const permanentInputs = document.querySelectorAll('#permanent-address input:not([type="hidden"]), #permanent-address select');
            presentInputs.forEach((input, index) => {
                if (index < permanentInputs.length) {
                    permanentInputs[index].value = input.value;
                    if (input.tagName === 'SELECT' && input.id === 'present_state') {
                        updateDistricts(permanentInputs[index], 'permanent_district');
                    }
                }
            });
        }
    }

    function addAcademic() {
        const container = document.getElementById('academic-container');
        const index = container.children.length;
        const academicHtml = `
            <tr class="animate__animated animate__fadeIn">
                <td>
                    <div class="form-floating">
                        <select name="academic_qualifications[${index}][level]" class="form-select" required aria-label="Academic Level">
                            <option value="Graduation">Graduation</option>
                            <option value="Post Graduation">Post Graduation</option>
                            <option value="Other">Other</option>
                        </select>
                        <label>Level</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating">
                        <input name="academic_qualifications[${index}][institute]" class="form-control" placeholder="Institute" required>
                        <label>Institute</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating">
                        <input name="academic_qualifications[${index}][board_university]" class="form-control" placeholder="Board/University" required>
                        <label>Board/University</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating">
                        <input name="academic_qualifications[${index}][year_passed]" class="form-control" placeholder="Year Passed" required pattern="[0-9]{4}">
                        <label>Year Passed</label>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-circle p-2" onclick="this.closest('tr').remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', academicHtml);
    }

    // Enhance accessibility with focus management
    document.querySelectorAll('.form-control, .form-select').forEach(element => {
        element.addEventListener('focus', () => {
            element.closest('.form-floating')?.classList.add('focused');
        });
        element.addEventListener('blur', () => {
            element.closest('.form-floating')?.classList.remove('focused');
        });
    });
</script>
@endpush
@endsection