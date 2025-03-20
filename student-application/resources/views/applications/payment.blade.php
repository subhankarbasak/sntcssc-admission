@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-wallet2 me-2"></i>Step 6: Payment Details</h4>
    <div class="card-body p-0">
        <!-- When payment exists -->
        @if($payment)
            <div class="alert alert-info shadow-sm">
                Payment already submitted. Status: <strong>{{ ucfirst($payment->status) }}</strong>
                @if($payment->screenshot)
                    <br>Screenshot:
                    @if (app()->environment('live'))
                        <a href="{{ url('public/storage/' . $payment->screenshot->file_path) }}" target="_blank" class="text-primary">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                    @else
                        <a href="{{ Storage::url($payment->screenshot->file_path) }}" target="_blank" class="text-primary">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                    @endif
                @endif
            </div>
            <form method="POST" action="{{ route('application.update.payment', $application) }}" enctype="multipart/form-data" id="paymentForm" class="needs-validation" novalidate>
                @csrf
                @method('PATCH') <!-- Use PATCH for updates -->

                <div class="mb-3">
                    <label for="amount" class="form-label fw-medium required">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" id="amount" 
                        value="{{ old('amount', $payment->amount ?? $fee) }}" readonly required>
                </div>

                <div class="mb-3">
                    <label for="method" class="form-label fw-medium required">Payment Method</label>
                    <select name="method" class="form-control" id="method" required>
                        <option value="" disabled {{ !$payment ? 'selected' : '' }}>Select Payment Method</option>
                        <option value="UPI" {{ old('method', $payment->method) === 'UPI' ? 'selected' : '' }}>UPI QR Code / UPI ID</option>
                        <option value="NEFT" {{ old('method', $payment->method) === 'NEFT' ? 'selected' : '' }}>NEFT</option>
                        <option value="IMPS" {{ old('method', $payment->method) === 'IMPS' ? 'selected' : '' }}>IMPS</option>
                        <option value="Direct Account Transfer" {{ old('method', $payment->method) === 'Direct Account Transfer' ? 'selected' : '' }}>Direct Account Transfer</option>
                    </select>
                    <div class="invalid-feedback">Please select a payment method.</div>
                </div>

                <!-- Payment Details Container remains same -->
                <!-- Payment Details Container -->
                <div id="payment-details" class="mb-3 d-none">
                    <!-- UPI QR Code Section -->
                    <div id="upi-details" class="payment-method-details d-none">
                        <div class="alert alert-light border p-3">
                            <h6 class="fw-medium">Scan to Pay</h6>
                            <img src="{{ url('/images/upi-qr-code.jpg') }}" alt="UPI QR Code" class="img-fluid mb-2" style="max-width: 260px;">
                            <p class="small text-muted mb-0">
                                UPI ID: <strong>sntcssc@indianbk</strong><br>
                                Please include the Transaction ID (or UTR no.), transaction date from your UPI app in the field below
                            </p>
                        </div>
                    </div>

                    <!-- Bank Details Section -->
                    <div id="bank-details" class="payment-method-details d-none">
                        <div class="alert alert-light border p-3">
                            <h6 class="fw-medium">Bank Account Details</h6>
                            <dl class="row mb-0 small">
                                <dt class="col-5">Account Holder:</dt>
                                <dd class="col-7">CENTRE FOR EXCELLENCE IN PUBLIC MANAGEMENT</dd>
                                <dt class="col-5">Account Number:</dt>
                                <dd class="col-7">50189702376</dd>
                                <dt class="col-5">IFSC Code:</dt>
                                <dd class="col-7">IDIB000S549</dd>
                                <dt class="col-5">Bank Name:</dt>
                                <dd class="col-7">INDIAN BANK</dd>
                                <dt class="col-5">Branch:</dt>
                                <dd class="col-7">Salt Lake, GD Market</dd>
                            </dl> <br>
                            <p class="small text-muted mb-0">
                                Please include the Transaction ID (or UTR no.), transaction date from your transaction / deposit receipt in the field below
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="transaction_date" class="form-label fw-medium required">Transaction Date</label>
                    <input type="date" name="transaction_date" class="form-control" id="transaction_date" 
                        max="{{ date('Y-m-d') }}" 
                        value="{{ old('transaction_date', $payment->transaction_date->format('Y-m-d')) }}" required>
                    <div class="invalid-feedback">Please select a valid transaction date.</div>
                </div>

                <div class="mb-3">
                    <label for="transaction_id" class="form-label fw-medium required">Transaction ID / UTR No.</label>
                    <input type="text" name="transaction_id" class="form-control" id="transaction_id" 
                        value="{{ old('transaction_id', $payment->transaction_id) }}" required>
                    @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    <div class="invalid-feedback">Please enter a transaction ID.</div>
                </div>

                <div class="mb-3">
                    <label for="screenshot" class="form-label fw-medium">Payment Screenshot <span class="text-muted fw-normal fst-italic">(Ensure the receipt or screenshot clearly displays the transaction ID or UTR number, date, and transaction amount.)</span></label>
                    @if($payment->screenshot)
                        <div class="existing-screenshot mb-2">
                            <p class="mb-1">Current screenshot:</p>
                            <div class="preview-area">
                                @if (app()->environment('live'))
                                    <a href="{{ url('public/storage/' . $payment->screenshot->file_path) }}" target="_blank">
                                        <img src="{{ url('public/storage/' . $payment->screenshot->file_path) }}" class="img-fluid rounded" style="max-height: 120px;" alt="Current Screenshot">
                                    </a>
                                @else
                                    <a href="{{ Storage::url($payment->screenshot->file_path) }}" target="_blank">
                                        <img src="{{ Storage::url($payment->screenshot->file_path) }}" class="img-fluid rounded" style="max-height: 120px;" alt="Current Screenshot">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <input type="file" name="screenshot" class="form-control" id="screenshot" accept=".jpg,.png,.pdf">
                    @error('screenshot') <span class="text-danger small">{{ $message }}</span> @enderror
                    <small class="text-muted">Max 2MB (JPG/PNG/PDF). Select new file to replace existing screenshot.</small>
                    <div class="preview-area mt-2" id="screenshot-preview"></div>
                </div>
            </form>

        <!-- When no payment exists -->
        @else
            <form method="POST" action="{{ route('application.store.payment', $application) }}" enctype="multipart/form-data" id="paymentForm" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="amount" class="form-label fw-medium required">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" id="amount" 
                        value="{{ old('amount', $fee) }}" readonly required>
                </div>

                <div class="mb-3">
                    <label for="method" class="form-label fw-medium required">Payment Method</label>
                    <select name="method" class="form-control" id="method" required>
                        <option value="" disabled {{ old('method') ? '' : 'selected' }}>Select Payment Method</option>
                        <option value="UPI" {{ old('method') === 'UPI' ? 'selected' : '' }}>UPI QR Code / UPI ID</option>
                        <option value="NEFT" {{ old('method') === 'NEFT' ? 'selected' : '' }}>NEFT</option>
                        <option value="IMPS" {{ old('method') === 'IMPS' ? 'selected' : '' }}>IMPS</option>
                        <option value="Direct Account Transfer" {{ old('method') === 'Direct Account Transfer' ? 'selected' : '' }}>Direct Account Transfer</option>
                    </select>
                    <div class="invalid-feedback">Please select a payment method.</div>
                </div>

                <!-- Payment Details Container remains same -->
                <!-- Payment Details Container -->
                <div id="payment-details" class="mb-3 d-none">
                    <!-- UPI QR Code Section -->
                    <div id="upi-details" class="payment-method-details d-none">
                        <div class="alert alert-light border p-3">
                            <h6 class="fw-medium">Scan to Pay</h6>
                            <img src="{{ url('/images/upi-qr-code.jpg') }}" alt="UPI QR Code" class="img-fluid mb-2" style="max-width: 260px;">
                            <p class="small text-muted mb-0">
                                UPI ID: <strong>sntcssc@indianbk</strong><br>
                                Please include the Transaction ID (or UTR no.), transaction date from your UPI app in the field below
                            </p>
                        </div>
                    </div>

                    <!-- Bank Details Section -->
                    <div id="bank-details" class="payment-method-details d-none">
                        <div class="alert alert-light border p-3">
                            <h6 class="fw-medium">Bank Account Details</h6>
                            <dl class="row mb-0 small">
                                <dt class="col-5">Account Holder:</dt>
                                <dd class="col-7">CENTRE FOR EXCELLENCE IN PUBLIC MANAGEMENT</dd>
                                <dt class="col-5">Account Number:</dt>
                                <dd class="col-7">50189702376</dd>
                                <dt class="col-5">IFSC Code:</dt>
                                <dd class="col-7">IDIB000S549</dd>
                                <dt class="col-5">Bank Name:</dt>
                                <dd class="col-7">INDIAN BANK</dd>
                                <dt class="col-5">Branch:</dt>
                                <dd class="col-7">Salt Lake, GD Market</dd>
                            </dl> <br>
                            <p class="small text-muted mb-0">
                                Please include the Transaction ID (or UTR no.), transaction date from your transaction / deposit receipt in the field below
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="transaction_date" class="form-label fw-medium required">Transaction Date</label>
                    <input type="date" name="transaction_date" class="form-control" id="transaction_date" 
                        max="{{ date('Y-m-d') }}" 
                        value="{{ old('transaction_date') }}" required>
                    <div class="invalid-feedback">Please select a valid transaction date.</div>
                </div>

                <div class="mb-3">
                    <label for="transaction_id" class="form-label fw-medium required">Transaction ID / UTR No.</label>
                    <input type="text" name="transaction_id" class="form-control" id="transaction_id" 
                        value="{{ old('transaction_id') }}" required>
                    @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    <div class="invalid-feedback">Please enter a transaction ID.</div>
                </div>

                <div class="mb-3">
                    <label for="screenshot" class="form-label fw-medium required">Payment Screenshot <span class="text-muted fw-normal fst-italic">(Ensure the receipt or screenshot clearly displays the transaction ID or UTR number, date, and transaction amount.)</span></label>
                    <input type="file" name="screenshot" class="form-control" id="screenshot" accept=".jpg,.png,.pdf" required>
                    @error('screenshot') <span class="text-danger small">{{ $message }}</span> @enderror
                    <small class="text-muted">Max 2MB (JPG/PNG/PDF)</small>
                    <div class="preview-area mt-2" id="screenshot-preview"></div>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.step5', $application) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Previous
            </a>
            <div class="">
                <a href="{{ route('application.status', $application) }}" class="btn btn-primary shadow-sm position-relative overflow-hidden">
                    <span class="position-relative z-1">Go to Dashboard <i class="bi bi-arrow-right ms-2"></i></span>
                </a>
            </div>
            @if($payment)
                <div>
                    <button type="submit" form="paymentForm" id="payBtn" class="btn btn-primary shadow-sm">
                        Update Payment <i class="bi bi-check2 ms-2"></i>
                    </button>
                </div>
            @else
                <div>
                    <button type="submit" form="paymentForm" id="payBtn" class="btn btn-primary shadow-sm">
                        Submit Payment <i class="bi bi-check2 ms-2"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .preview-area img {
        max-height: 120px;
        width: auto;
        border-radius: 0.5rem;
    }
    .preview-area .pdf-preview {
        padding: 0.5rem;
        background-color: #f8fafc;
        border-radius: 0.5rem;
        color: #6b7280;
    }
    .payment-method-details {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    toastr.options = {
        positionClass: "toast-top-right",
        progressBar: true,
        timeOut: 5000,
        closeButton: true,
        preventDuplicates: true
    };

    const form = document.getElementById('paymentForm');
    const paymentMethodSelect = document.getElementById('method');
    const paymentDetails = document.getElementById('payment-details');
    const upiDetails = document.getElementById('upi-details');
    const bankDetails = document.getElementById('bank-details');
    const nextBtn = document.getElementById('payBtn');

    // Handle payment method change
    paymentMethodSelect.addEventListener('change', function() {
        const method = this.value;
        paymentDetails.classList.remove('d-none');
        
        if (method === 'UPI') {
            upiDetails.classList.remove('d-none');
            bankDetails.classList.add('d-none');
        } else if (method) {
            bankDetails.classList.remove('d-none');
            upiDetails.classList.add('d-none');
        } else {
            paymentDetails.classList.add('d-none');
        }
    });

    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                toastr.error('Please fill in all required fields correctly.');
            } else {
                nextBtn.disabled = true;
                nextBtn.innerHTML = '<span class="spinner"></span>Processing...';
                toastr.warning('Payment details ' + ({{ $payment ? 'true' : 'false' }} ? 'updating' : 'submitting') + ' in progress. Please wait.');
            }
            form.classList.add('was-validated');
        });

        const screenshotInput = document.getElementById('screenshot');
        const previewArea = document.getElementById('screenshot-preview');
        
        screenshotInput.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (file && file.size > maxSize) {
                toastr.error('File size exceeds limit (2MB)');
                this.value = '';
                previewArea.innerHTML = '';
                return;
            }

            previewArea.innerHTML = '';
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const content = file.type.includes('image') ?
                        `<img src="${e.target.result}" class="img-fluid rounded" alt="Payment Screenshot">` :
                        `<div class="pdf-preview"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>PDF Selected</div>`;
                    previewArea.innerHTML = `
                        ${content}
                        <a href="${e.target.result}" target="_blank" class="text-primary small mt-2 d-block">
                            <i class="bi bi-eye me-1"></i> Preview
                        </a>`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush

@php
    $step = 6;
    $percentage = 100;
@endphp