<!-- resources/views/applications/step4.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5 px-3 px-md-0">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                    <h4 class="mb-0 fw-semibold">Step 4: Document Upload</h4>
                    <span class="badge bg-light text-primary fw-medium px-3 py-2 rounded-pill">
                        <i class="fas fa-id-card me-2"></i> Application #{{ $application->id }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 p-lg-5">
                    <form method="POST" action="{{ route('application.store.step4', $application->id) }}" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <!-- Progress Bar -->
                        <div class="progress mb-5" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- Document Upload Section -->
                        <div class="row g-4">
                            <!-- Photo -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-lg bg-white border">
                                    <div class="d-flex flex-column gap-2">
                                        <label for="photo" class="form-label fw-medium text-dark">Photograph <span class="text-danger">*</span></label>
                                        <div class="custom-file-upload">
                                            <input type="file" name="photo" class="form-control" id="photo" accept="image/*" {{ !$documents->where('type', 'photo')->first() ? 'required' : '' }}>
                                        </div>
                                        <small class="text-muted">Max 2MB (JPG/PNG)</small>
                                        <div class="preview-area mt-2" id="photo-preview">
                                            @if($documents->where('type', 'photo')->first())
                                                <div class="existing-preview mb-2">
                                                    <span class="badge bg-success-subtle text-success mb-2">Current</span>
                                                    <img src="{{ Storage::url($documents->where('type', 'photo')->first()->file_path) }}" class="img-fluid rounded" alt="Current Photograph">
                                                    <a href="{{ Storage::url($documents->where('type', 'photo')->first()->file_path) }}" target="_blank" class="text-primary small mt-2 d-block">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="new-preview" id="photo-new-preview"></div>
                                        </div>
                                        @error('photo') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Signature -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-lg bg-white border">
                                    <div class="d-flex flex-column gap-2">
                                        <label for="signature" class="form-label fw-medium text-dark">Signature <span class="text-danger">*</span></label>
                                        <div class="custom-file-upload">
                                            <input type="file" name="signature" class="form-control" id="signature" accept="image/*" {{ !$documents->where('type', 'signature')->first() ? 'required' : '' }}>
                                        </div>
                                        <small class="text-muted">Max 1MB (JPG/PNG)</small>
                                        <div class="preview-area mt-2" id="signature-preview">
                                            @if($documents->where('type', 'signature')->first())
                                                <div class="existing-preview mb-2">
                                                    <span class="badge bg-success-subtle text-success mb-2">Current</span>
                                                    <img src="{{ Storage::url($documents->where('type', 'signature')->first()->file_path) }}" class="img-fluid rounded" alt="Current Signature">
                                                    <a href="{{ Storage::url($documents->where('type', 'signature')->first()->file_path) }}" target="_blank" class="text-primary small mt-2 d-block">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="new-preview" id="signature-new-preview"></div>
                                        </div>
                                        @error('signature') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Category Certificate -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-lg bg-white border">
                                    <div class="d-flex flex-column gap-2">
                                        <label for="category_cert" class="form-label fw-medium text-dark">Category Certificate <span class="text-muted fw-normal">(Optional)</span></label>
                                        <div class="custom-file-upload">
                                            <input type="file" name="category_cert" class="form-control" id="category_cert" accept=".pdf,.jpg,.png">
                                        </div>
                                        <small class="text-muted">Max 5MB (PDF/JPG/PNG)</small>
                                        <div class="preview-area mt-2" id="category_cert-preview">
                                            @if($documents->where('type', 'category_cert')->first())
                                                <div class="existing-preview mb-2">
                                                    <span class="badge bg-success-subtle text-success mb-2">Current</span>
                                                    @if(strpos($documents->where('type', 'category_cert')->first()->file_path, '.pdf') !== false)
                                                        <div class="pdf-preview"><i class="fas fa-file-pdf text-danger me-2"></i>PDF Uploaded</div>
                                                    @else
                                                        <img src="{{ Storage::url($documents->where('type', 'category_cert')->first()->file_path) }}" class="img-fluid rounded" alt="Current Category Certificate">
                                                    @endif
                                                    <a href="{{ Storage::url($documents->where('type', 'category_cert')->first()->file_path) }}" target="_blank" class="text-primary small mt-2 d-block">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="new-preview" id="category_cert-new-preview"></div>
                                        </div>
                                        @error('category_cert') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- PwBD Certificate -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-lg bg-white border">
                                    <div class="d-flex flex-column gap-2">
                                        <label for="pwbd_cert" class="form-label fw-medium text-dark">PwBD Certificate <span class="text-muted fw-normal">(Optional)</span></label>
                                        <div class="custom-file-upload">
                                            <input type="file" name="pwbd_cert" class="form-control" id="pwbd_cert" accept=".pdf,.jpg,.png">
                                        </div>
                                        <small class="text-muted">Max 5MB (PDF/JPG/PNG)</small>
                                        <div class="preview-area mt-2" id="pwbd_cert-preview">
                                            @if($documents->where('type', 'pwbd_cert')->first())
                                                <div class="existing-preview mb-2">
                                                    <span class="badge bg-success-subtle text-success mb-2">Current</span>
                                                    @if(strpos($documents->where('type', 'pwbd_cert')->first()->file_path, '.pdf') !== false)
                                                        <div class="pdf-preview"><i class="fas fa-file-pdf text-danger me-2"></i>PDF Uploaded</div>
                                                    @else
                                                        <img src="{{ Storage::url($documents->where('type', 'pwbd_cert')->first()->file_path) }}" class="img-fluid rounded" alt="Current PwBD Certificate">
                                                    @endif
                                                    <a href="{{ Storage::url($documents->where('type', 'pwbd_cert')->first()->file_path) }}" target="_blank" class="text-primary small mt-2 d-block">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="new-preview" id="pwbd_cert-new-preview"></div>
                                        </div>
                                        @error('pwbd_cert') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex flex-column flex-md-row justify-content-between mt-5 gap-3">
                            <a href="{{ route('application.step3', $application->id) }}" class="btn btn-outline-secondary w-100 w-md-auto">
                                <i class="fas fa-arrow-left me-2"></i> Previous
                            </a>
                            <button type="submit" class="btn btn-primary w-100 w-md-auto" id="submitBtn">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #6b7280;
            --light: #f8fafc;
            --dark: #1f2937;
            --border: #e5e7eb;
            --success: #15803d;
            --success-subtle: #dcfce7;
            --warning: #d97706;
            --warning-subtle: #fef3c7;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .upload-card {
            transition: all 0.2s ease;
            background-color: white;
        }

        .upload-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 0.65rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .btn-outline-secondary {
            border-color: var(--secondary);
            color: var(--secondary);
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-secondary:hover {
            background-color: var(--secondary);
            color: white;
        }

        .progress {
            background-color: var(--border);
            border-radius: 1rem;
        }

        .preview-area img {
            max-height: 120px;
            width: auto;
            border-radius: 0.5rem;
        }

        .existing-preview {
            position: relative;
            padding: 0.5rem;
            background-color: var(--light);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
        }

        .new-preview {
            position: relative;
            padding: 0.5rem;
            background-color: var(--warning-subtle);
            border: 1px dashed var(--warning);
            border-radius: 0.5rem;
            min-height: 50px;
        }

        .new-preview::before {
            content: "Will Replace Current";
            display: block;
            position: absolute;
            top: 0.25rem;
            left: 0.5rem;
            font-size: 0.75rem;
            color: var(--warning);
            background-color: var(--warning-subtle);
            padding: 0 0.5rem;
        }

        .pdf-preview {
            padding: 0.5rem;
            background-color: var(--light);
            border-radius: 0.5rem;
            color: var(--secondary);
        }

        @media (max-width: 768px) {
            .card-header, .card-body, .upload-card {
                padding: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        toastr.options = {
            positionClass: "toast-top-right",
            progressBar: true,
            timeOut: 5000,
            closeButton: true,
            preventDuplicates: true
        };

        @if(session('toastr'))
            toastr[{{ session('toastr.type') }}]('{{ session('toastr.message') }}');
        @endif

        @if(session('toastr'))
        toastr[{{ session('toastr.type') }}]('{{ session('toastr.message') }}');
    @endif

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
                            `<div class="pdf-preview"><i class="fas fa-file-pdf text-danger me-2"></i>PDF Selected</div>`;
                        newPreviewArea.innerHTML = `
                            ${content}
                            <a href="${e.target.result}" target="_blank" class="text-primary small mt-2 d-block">
                                <i class="fas fa-eye me-1"></i> Preview
                            </a>`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
@endsection