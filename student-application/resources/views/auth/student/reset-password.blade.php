<!-- resources/views/auth/student/reset-password.blade.php -->
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
        --primary: #0d6efd;
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reset Password</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" minlength="8" placeholder="Enter New Password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </form>
                    <div class="text-center mt-3 footer-links">
                        <small><a href="{{ route('login') }}">Back to Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endpush
@endsection