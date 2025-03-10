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
            <h2 class="mb-0">Forgot Password</h2>
            <small class="text-light">Reset your password</small>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="needs-validation" novalidate>
                @csrf
                <div class="form-section">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ old('email') }}" required placeholder="Enter your email">
                            <label for="email">Email Address</label>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>

                    <div class="text-center mt-3 footer-links">
                        <small><a href="{{ route('login') }}">Back to Login</a> | <a href="{{ route('register') }}">Register</a></small>
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
        const form = document.getElementById('forgotPasswordForm');
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                toastr.error('Please enter a valid email address.');
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
</script>
@endpush