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
        margin: 40px auto;
        padding: 0 20px;
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

    .footer-links a {
        color: var(--accent);
        text-decoration: none;
        margin: 0 5px;
    }

    .footer-links a:hover {
        text-decoration: underline;
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Reset Password</h2>
            <small class="text-light">Enter your new password</small>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-section">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ $email ?? old('email') }}" required placeholder="Enter your email">
                            <label for="email">Email Address</label>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" required placeholder="Enter new password">
                            <label for="password">New Password</label>
                            <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                    onclick="togglePassword('password')">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating position-relative">
                            <input type="password" name="password_confirmation" class="form-control" 
                                   id="password_confirmation" required placeholder="Confirm new password">
                            <label for="password_confirmation">Confirm Password</label>
                            <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                    onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>

                    <div class="text-center mt-3 footer-links">
                        <small><a href="{{ route('login') }}">Back to Login</a></small>
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
        // Form validation
        const form = document.getElementById('resetPasswordForm');
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
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
</script>
@endpush