@extends('layouts.app')

@push('styles')
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    :root {
        --primary: #136ffe;
        /* --primary: #2c3e50; */
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
        /* max-width: 960px;
        margin: 40px auto;
        padding: 0 20px; */
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

    .form-control {
        border-radius: 6px;
        border: 1px solid var(--border);
        padding: 12px;
        font-size: 0.95rem;
    }

    .form-control:focus {
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

    .footer-links a {
        color: var(--accent);
        text-decoration: none;
        margin: 0 5px;
    }

    .footer-links a:hover {
        text-decoration: underline;
        color: var(--primary);
    }

    .toggle-link {
        color: var(--accent);
        cursor: pointer;
        text-decoration: underline;
    }

    .toggle-link:hover {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Login</h2>
            <small class="text-light">Access your account</small>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" id="loginForm" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="login_method" id="loginMethod" value="password">
                <div class="form-section">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ old('email') }}" required placeholder="Enter your email">
                            <label for="email">Email Address</label>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3" id="passwordSection">
                        <div class="form-floating position-relative">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" placeholder="Enter your password">
                            <label for="password">Password</label>
                            <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                    onclick="togglePassword('password')">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3" id="dobSection" style="display: none;">
                        <div class="form-floating">
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" 
                                   id="dob" placeholder="Select your date of birth">
                            <label for="dob">Date of Birth</label>
                            @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <a href="{{ route('student.password.request') }}" class="footer-links">Forgot Password?</a>
                        <span class="toggle-link d-none" id="toggleLoginMethod">Login with DOB</span>
                    </div>

                    <button type="submit" id="loginBtn" class="btn btn-primary w-100">Login</button>

                    <div class="text-center mt-3 footer-links">
                        <small>Don't have an account? <a href="{{ route('register') }}">Register</a></small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Toastr configuration
    toastr.options = {
        "positionClass": "toast-top-right",
        "progressBar": true,
        "timeOut": 5000,
        "closeButton": true,
        "preventDuplicates": true,
        "newestOnTop": true
    };

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('loginForm');
        const toggleLink = document.getElementById('toggleLoginMethod');
        const passwordSection = document.getElementById('passwordSection');
        const dobSection = document.getElementById('dobSection');
        const passwordInput = document.getElementById('password');
        const dobInput = document.getElementById('dob');
        const loginMethod = document.getElementById('loginMethod');
        const loginBtn = document.getElementById('loginBtn');

        // Toggle login method
        toggleLink.addEventListener('click', () => {
            if (passwordSection.style.display === 'none') {
                passwordSection.style.display = 'block';
                dobSection.style.display = 'none';
                passwordInput.required = true;
                dobInput.required = false;
                loginMethod.value = 'password';
                toggleLink.textContent = 'Login with DOB';
            } else {
                passwordSection.style.display = 'none';
                dobSection.style.display = 'block';
                passwordInput.required = false;
                dobInput.required = true;
                loginMethod.value = 'dob';
                toggleLink.textContent = 'Login with Password';
            }
            form.classList.remove('was-validated'); // Reset validation state
        });

        // Form validation
        form.addEventListener('submit', event => {
            const isDobLogin = loginMethod.value === 'dob';
            const requiredField = isDobLogin ? dobInput : passwordInput;
            
            if (!form.checkValidity() || !requiredField.value) {
                event.preventDefault();
                event.stopPropagation();
                toastr.error('Please fill all required fields correctly.');
            }
            form.classList.add('was-validated');
        });

        // Show error messages
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif

        @if(session('toastr'))
            toastr["{{ session('toastr.type') }}"]("{{ session('toastr.message') }}");
        @endif
    });

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('i');
        field.type = field.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }


    loginBtn.addEventListener('click', function() {
    // Add spinner and disable button
    loginBtn.disabled = true;
    loginBtn.innerHTML = '<span class="spinner"></span>Processing...';
    
    // Submit the form
    document.getElementById('loginForm').submit();
});
</script>
@endpush