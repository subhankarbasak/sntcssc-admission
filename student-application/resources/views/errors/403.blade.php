@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page">
                <div class="error-code">
                    <h1 class="display-1">403</h1>
                </div>
                <h2 class="text-danger mt-4">Oops! Forbidden Access</h2>
                <p class="lead mt-3">
                    Sorry, you don't have permission to access this resource.
                </p>
                @if(env('APP_ENV') === 'local')
                    <div class="mt-3">
                        <small class="text-muted">
                            Error Code: {{ $code }}<br>
                            Error Message: {{ $message }}
                        </small>
                    </div>
                @endif
                @if(env('APP_ENV') === 'local')
                    <div class="alert alert-danger mt-3">
                        <strong>Error Details:</strong><br>
                        <p>{{ $message }}</p>
                        <p>Error Code: {{ $code }}</p>
                    </div>
                @endif
                <div class="mt-5">
                    <a href="{{ url()->previous() }}">Go back</a>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection