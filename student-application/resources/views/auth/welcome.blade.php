@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to SNTCSSC!</div>

                <div class="card-body">
                    <h4>Account Creation Successful!</h4>
                    <p>Please save your login credentials (also sent to your email):</p>
                    
                    <div class="alert alert-info">
                        <strong>Email:</strong> {{ $email }}<br>
                        <strong>Password:</strong> {{ $password }}
                    </div>

                    <p class="text-warning">This page will only be shown once after registration.</p>
                    
                    <div class="alert alert-warning">
                        <strong>Important:</strong> This is only confirmation of your account creation. 
                        To appear for the admission test for SNTCSSC Composite Course 2026 batch, 
                        you need to apply from the Dashboard page in the "Available Notifications" section.
                    </div>

                    @if (Auth::check())
                        <form action="{{ route('proceed-to-dashboard') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Proceed to Dashboard
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Go to Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection