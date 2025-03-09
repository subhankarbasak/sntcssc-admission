<!-- resources/views/applications/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Payment Details</h4>
                </div>
                <div class="card-body">
                    @if($payment)
                        <div class="alert alert-info">
                            Payment already submitted. Status: {{ ucfirst($payment->status) }}
                            @if($payment->screenshot)
                                <br>Screenshot: <a href="{{ Storage::url($payment->screenshot->file_path) }}" target="_blank">View</a>
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('application.store.payment', $application->id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" id="amount" 
                                       value="{{ $fee }}" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="method" class="form-control" id="method" required>
                                    <option value="UPI">UPI</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
                                <input type="date" name="transaction_date" class="form-control" id="transaction_date" 
                                       max="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                <input type="text" name="transaction_id" class="form-control" id="transaction_id" required>
                                @error('transaction_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="screenshot" class="form-label">Payment Screenshot (Optional)</label>
                                <input type="file" name="screenshot" class="form-control" id="screenshot" accept=".jpg,.png,.pdf">
                                @error('screenshot') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    toastr.options = {
        "positionClass": "toast-top-right",
        "progressBar": true
    };

    @if(session('toastr'))
        toastr[{{ session('toastr.type') }}]('{{ session('toastr.message') }}');
    @endif
    </script>
@endpush
@endsection