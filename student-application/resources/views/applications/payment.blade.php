@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-wallet2 me-2"></i>Step 6: Payment Details</h4>
    <div class="card-body p-0">
        @if($payment)
            <div class="alert alert-info shadow-sm">
                Payment already submitted. Status: <strong>{{ ucfirst($payment->status) }}</strong>
                @if($payment->screenshot)
                    <br>Screenshot: <a href="{{ Storage::url($payment->screenshot->file_path) }}" target="_blank" class="text-primary">
                        <i class="bi bi-eye me-1"></i>View
                    </a>
                @endif
            </div>
        @else
            <form method="POST" action="{{ route('application.store.payment', $application) }}" enctype="multipart/form-data" id="paymentForm" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="amount" class="form-label fw-medium required">Amount (₹)</label>
                    <input type="number" name="amount" class="form-control" id="amount" 
                           value="{{ $fee }}" readonly required>
                </div>

                <div class="mb-3">
                    <label for="method" class="form-label fw-medium required">Payment Method</label>
                    <select name="method" class="form-control" id="method" required>
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="UPI">UPI QR code</option>
                        <option value="Bank Transfer">Direct Bank Transfer</option>
                    </select>
                    <div class="invalid-feedback">Please select a payment method.</div>
                </div>

                <div class="mb-3">
                    <label for="transaction_date" class="form-label fw-medium required">Transaction Date</label>
                    <input type="date" name="transaction_date" class="form-control" id="transaction_date" 
                           max="{{ date('Y-m-d') }}" required>
                    <div class="invalid-feedback">Please select a valid transaction date.</div>
                </div>

                <div class="mb-3">
                    <label for="transaction_id" class="form-label fw-medium required">Transaction ID / UTR No.</label>
                    <input type="text" name="transaction_id" class="form-control" id="transaction_id" required>
                    @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    <div class="invalid-feedback">Please enter a transaction ID.</div>
                </div>

                <div class="mb-3">
                    <label for="screenshot" class="form-label fw-medium">Payment Screenshot <span class="text-muted fw-normal fst-italic">(Ensure the receipt or screenshot clearly displays the transaction ID or UTR number, date, and transaction amount.)</span></label>
                    <input type="file" name="screenshot" class="form-control" id="screenshot" accept=".jpg,.png,.pdf" required>
                    @error('screenshot') <span class="text-danger small">{{ $message }}</span> @enderror
                    <small class="text-muted">Max 3MB (JPG/PNG/PDF)</small>
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
            <div class="d-none">
                <a href="{{ route('application.status', $application) }}" class="btn btn-primary shadow-sm position-relative overflow-hidden">
                    <span class="position-relative z-1">Go to Dashboard <i class="bi bi-arrow-right ms-2"></i></span>
                </a>
            </div>
            @if(!$payment)
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
</style>
@endpush

@push('scripts')
<script>
        const form = document.getElementById('paymentForm');
        const nextBtn = document.getElementById('payBtn');
document.addEventListener('DOMContentLoaded', function() {
    toastr.options = {
        positionClass: "toast-top-right",
        progressBar: true,
        timeOut: 5000,
        closeButton: true,
        preventDuplicates: true
    };

    @if(session('toastr'))
        toastr['{{ session('toastr.type') }}']('{{ session('toastr.message') }}', 'Notification');
    @endif

    const form = document.getElementById('paymentForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                toastr.error('Please fill in all required fields correctly.');
            } else {
                // Add spinner and disable button
                nextBtn.disabled = true;
                nextBtn.innerHTML = '<span class="spinner"></span>Processing...';
                
                toastr.success('Payment details submitted successfully!');
            }
            form.classList.add('was-validated');
        });

        const screenshotInput = document.getElementById('screenshot');
        const previewArea = document.getElementById('screenshot-preview');
        screenshotInput.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file && file.size > maxSize) {
                toastr.error('File size exceeds limit (5MB)');
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
    $step = 5;
    $percentage = 100;
@endphp