@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Application Details - {{ $application->application_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $application->studentProfile?->first_name }} {{ $application->studentProfile?->last_name }}</p>
                        <p><strong>Email:</strong> {{ $application->studentProfile?->email }}</p>
                        <p><strong>Phone:</strong> {{ $application->studentProfile?->mobile }}</p>
                        <p><strong>District:</strong> {{ $application->permanentAddress?->district }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
                        <p><strong>Payment Status:</strong> {{ $application->payment?->status ? ucfirst($application->payment->status) : 'N/A' }}</p>
                        <p><strong>Amount:</strong> {{ $application->payment?->amount ?? 'N/A' }}</p>
                        @php
                            $paymentSsDoc = $application->documents->firstWhere('type', 'payment_ss');
                        @endphp
                        <p>
                            <strong>Payment Screenshot:</strong> 
                            @if ($paymentSsDoc)
                                <a href="{{ Storage::url($paymentSsDoc->file_path) }}" target="_blank" class="text-primary">View</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary mt-3">Back to List</a>
            </div>
        </div>
    </div>
@endsection