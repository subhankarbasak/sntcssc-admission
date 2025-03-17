@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-shield me-2"></i>Application Step 4: Document Upload</h4>
    <form id="applicationForm" method="POST" action="{{ route('application.store.step4', $application) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        <div class="row g-4">
            <!-- Photo -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <label for="photo" class="form-label fw-semibold text-dark required">Photograph</label>
                    <input type="file" name="photo" class="form-control" id="photo" accept="image/*" 
                           {{ !$documents->where('type', 'photo')->first() ? 'required' : '' }}>
                    <small class="text-muted">Max 2MB (JPG/PNG)</small>
                    <div class="preview-area mt-2" id="photo-preview">
                        @if($documents->where('type', 'photo')->first())
                            <div class="existing-preview mb-2">
                                <span class="badge bg-success text-white mb-2">Current</span>
                                <img src="{{ Storage::url($documents->where('type', 'photo')->first()->file_path) }}" 
                                     class="img-fluid rounded" alt="Current Photograph">
                                <a href="{{ Storage::url($documents->where('type', 'photo')->first()->file_path) }}" 
                                   target="_blank" class="text-primary small mt-2 d-block">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </div>
                        @endif
                        <div class="new-preview" id="photo-new-preview"></div>
                    </div>
                    <div class="invalid-feedback">Please upload a photograph.</div>
                </div>
            </div>

            <!-- Signature -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <label for="signature" class="form-label fw-semibold text-dark required">Signature</label>
                    <input type="file" name="signature" class="form-control" id="signature" accept="image/*" 
                           {{ !$documents->where('type', 'signature')->first() ? 'required' : '' }}>
                    <small class="text-muted">Max 1MB (JPG/PNG)</small>
                    <div class="preview-area mt-2" id="signature-preview">
                        @if($documents->where('type', 'signature')->first())
                            <div class="existing-preview mb-2">
                                <span class="badge bg-success text-white mb-2">Current</span>
                                <img src="{{ Storage::url($documents->where('type', 'signature')->first()->file_path) }}" 
                                     class="img-fluid rounded" alt="Current Signature">
                                <a href="{{ Storage::url($documents->where('type', 'signature')->first()->file_path) }}" 
                                   target="_blank" class="text-primary small mt-2 d-block">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </div>
                        @endif
                        <div class="new-preview" id="signature-new-preview"></div>
                    </div>
                    <div class="invalid-feedback">Please upload a signature.</div>
                </div>
            </div>

            <!-- Category Certificate -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <label for="category_cert" class="form-label fw-semibold text-dark">
                        Category Certificate 
                        @if($profile && $profile->category !== 'UR')
                            <span class="text-danger">*</span>
                        @else
                            <span class="text-muted fw-normal">(Optional)</span>
                        @endif
                    </label>
                    <input type="file" name="category_cert" class="form-control" id="category_cert" accept=".pdf,.jpg,.png"
                           {{ $profile && $profile->category !== 'UR' && !$documents->where('type', 'category_cert')->first() ? 'required' : '' }}>
                    <small class="text-muted">Max 5MB (PDF/JPG/PNG)</small>
                    <div class="preview-area mt-2" id="category_cert-preview">
                        @if($documents->where('type', 'category_cert')->first())
                            <div class="existing-preview mb-2">
                                <span class="badge bg-success text-white mb-2">Current</span>
                                @if(strpos($documents->where('type', 'category_cert')->first()->file_path, '.pdf') !== false)
                                    <div class="pdf-preview"><i class="bi bi-file-pdf text-danger me-2"></i>PDF Uploaded</div>
                                @else
                                    <img src="{{ Storage::url($documents->where('type', 'category_cert')->first()->file_path) }}" 
                                         class="img-fluid rounded" alt="Current Category Certificate">
                                @endif
                                <a href="{{ Storage::url($documents->where('type', 'category_cert')->first()->file_path) }}" 
                                   target="_blank" class="text-primary small mt-2 d-block">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </div>
                        @endif
                        <div class="new-preview" id="category_cert-new-preview"></div>
                    </div>
                    <div class="invalid-feedback">Please upload a category certificate.</div>
                </div>
            </div>

            <!-- PwBD Certificate -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <label for="pwbd_cert" class="form-label fw-semibold text-dark">
                        PwBD Certificate 
                        @if($profile && $profile->is_pwbd == 1)
                            <span class="text-danger">*</span>
                        @else
                            <span class="text-muted fw-normal">(Optional)</span>
                        @endif
                    </label>
                    <input type="file" name="pwbd_cert" class="form-control" id="pwbd_cert" accept=".pdf,.jpg,.png"
                           {{ $profile && $profile->is_pwbd == 1 && !$documents->where('type', 'pwbd_cert')->first() ? 'required' : '' }}>
                    <small class="text-muted">Max 5MB (PDF/JPG/PNG)</small>
                    <div class="preview-area mt-2" id="pwbd_cert-preview">
                        @if($documents->where('type', 'pwbd_cert')->first())
                            <div class="existing-preview mb-2">
                                <span class="badge bg-success text-white mb-2">Current</span>
                                @if(strpos($documents->where('type', 'pwbd_cert')->first()->file_path, '.pdf') !== false)
                                    <div class="pdf-preview"><i class="bi bi-file-pdf text-danger me-2"></i>PDF Uploaded</div>
                                @else
                                    <img src="{{ Storage::url($documents->where('type', 'pwbd_cert')->first()->file_path) }}" 
                                         class="img-fluid rounded" alt="Current PwBD Certificate">
                                @endif
                                <a href="{{ Storage::url($documents->where('type', 'pwbd_cert')->first()->file_path) }}" 
                                   target="_blank" class="text-primary small mt-2 d-block">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </div>
                        @endif
                        <div class="new-preview" id="pwbd_cert-new-preview"></div>
                    </div>
                    <div class="invalid-feedback">Please upload a PwBD certificate.</div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.step3', $application) }}" class="btn btn-outline-secondary shadow-sm">
                Previous
            </a>
            <button type="button" class="btn btn-primary shadow-sm" id="previewAndNextBtn">
                <i class="bi bi-eye me-2"></i>Preview and Next
            </button>
        </div>
    </div>
@endsection

@section('preview')
    <h6 class="fw-semibold text-dark mb-3">Uploaded Documents</h6>
    <div class="row g-4" id="documentPreview">
        <div class="col-md-6">
            <h6>Photograph</h6>
            <div id="photo-preview-modal"></div>
        </div>
        <div class="col-md-6">
            <h6>Signature</h6>
            <div id="signature-preview-modal"></div>
        </div>
        <div class="col-md-6">
            <h6>Category Certificate</h6>
            <div id="category_cert-preview-modal"></div>
        </div>
        <div class="col-md-6">
            <h6>PwBD Certificate</h6>
            <div id="pwbd_cert-preview-modal"></div>
        </div>
    </div>
    <div class="mt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="declarationCheck" required>
            <label class="form-check-label" for="declarationCheck">
                I hereby declare that all the information provided is true and correct to the best of my knowledge.
            </label>
        </div>
    </div>
@endsection

@section('preview-footer')
    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Edit</button>
    <button type="button" class="btn btn-primary shadow-sm" id="saveAndNextBtn" disabled>Save and Next <i class="bi bi-arrow-right ms-2"></i></button>
@endsection

@push('styles')
<style>
    .preview-area img {
        max-height: 120px;
        width: auto;
    }
    .existing-preview {
        padding: 0.5rem;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
    }
    .new-preview {
        padding: 0.5rem;
        background-color: #fef3c7;
        border: 1px dashed #d97706;
        border-radius: 0.5rem;
        position: relative;
        min-height: 50px;
    }
    .new-preview::before {
        content: "Will Replace Current";
        position: absolute;
        top: 0.25rem;
        left: 0.5rem;
        font-size: 0.75rem;
        color: #d97706;
        background-color: #fef3c7;
        padding: 0 0.5rem;
    }
    .pdf-preview {
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        color: #6b7280;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationForm');
    const isCategoryRequired = {{ $profile && $profile->category !== 'UR' ? 'true' : 'false' }};
    const isPwbdRequired = {{ $profile && $profile->is_pwbd == 1 ? 'true' : 'false' }};

    // Toastr options
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000
    };

    // File input handling
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const newPreviewArea = document.getElementById(`${this.id}-new-preview`);
            const maxSizes = {
                'photo': 2 * 1024 * 1024,
                'signature': 1 * 1024 * 1024,
                'category_cert': 5 * 1024 * 1024,
                'pwbd_cert': 5 * 1024 * 1024
            };

            if (file && file.size > maxSizes[this.id]) {
                toastr.error(`File size exceeds limit (${maxSizes[this.id] / (1024 * 1024)}MB)`);
                this.value = '';
                newPreviewArea.innerHTML = '';
                return;
            }

            newPreviewArea.innerHTML = '';
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const content = file.type.includes('image') ?
                        `<img src="${e.target.result}" class="img-fluid rounded" alt="New ${input.id}">` :
                        `<div class="pdf-preview"><i class="bi bi-file-pdf text-danger me-2"></i>PDF Selected</div>`;
                    newPreviewArea.innerHTML = `
                        ${content}
                        <a href="${e.target.result}" target="_blank" class="text-primary small mt-2 d-block">
                            <i class="bi bi-eye me-1"></i> Preview
                        </a>`;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Preview and Next button handler
    document.getElementById('previewAndNextBtn').addEventListener('click', function() {
        let isValid = true;
        
        // Check photo and signature (always required if no existing file)
        ['photo', 'signature'].forEach(id => {
            const input = document.getElementById(id);
            const existingFile = document.querySelector(`#${id}-preview .existing-preview`);
            if (!input.files.length && !existingFile) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // Check category certificate if category is not UR
        if (isCategoryRequired) {
            const input = document.getElementById('category_cert');
            const existingFile = document.querySelector('#category_cert-preview .existing-preview');
            if (!input.files.length && !existingFile) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        }

        // Check PwBD certificate if is_pwbd is 1
        if (isPwbdRequired) {
            const input = document.getElementById('pwbd_cert');
            const existingFile = document.querySelector('#pwbd_cert-preview .existing-preview');
            if (!input.files.length && !existingFile) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        }

        if (!isValid) {
            toastr.error('Please upload all required documents.');
            form.classList.add('was-validated');
            return;
        }

        // Populate preview modal
        const inputs = ['photo', 'signature', 'category_cert', 'pwbd_cert'];
        inputs.forEach(id => {
            const modalPreview = document.getElementById(`${id}-preview-modal`);
            const existingPreview = document.querySelector(`#${id}-preview .existing-preview`);
            const newPreview = document.getElementById(`${id}-new-preview`).innerHTML;

            if (newPreview) {
                modalPreview.innerHTML = newPreview;
            } else if (existingPreview) {
                modalPreview.innerHTML = existingPreview.innerHTML;
            } else {
                modalPreview.innerHTML = '<span class="text-muted">Not uploaded</span>';
            }
        });

        // Show preview modal
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    });

    // Declaration checkbox handler
    const declarationCheck = document.getElementById('declarationCheck');
    const saveAndNextBtn = document.getElementById('saveAndNextBtn');
    
    declarationCheck.addEventListener('change', function() {
        saveAndNextBtn.disabled = !this.checked;
    });

    // Save and Next button handler
    saveAndNextBtn.addEventListener('click', function() {
        if (declarationCheck.checked) {
            document.getElementById('applicationForm').submit();
        }
    });

    // Form submission feedback
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            toastr.error('Please upload all required documents.');
        } else {
            toastr.success('Documents saved successfully!');
        }
    });

    @if(session('toastr'))
        toastr['{{ session('toastr.type') }}']('{{ session('toastr.message') }}', 'Notification');
    @endif
});
</script>
<script>
    const form = document.getElementById('applicationForm');
    const nextBtn = document.getElementById('saveAndNextBtn');
    nextBtn.addEventListener('click', function() {
        // Add spinner and disable button
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<span class="spinner"></span>Processing...';
        
        // Submit the form
        form.submit();
    });
</script>
@endpush

@php
    $step = 4;
    $percentage = 60;
@endphp