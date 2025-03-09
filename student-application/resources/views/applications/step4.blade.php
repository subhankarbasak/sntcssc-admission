<!-- resources/views/applications/step4.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Application Step 4: Document Upload</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('application.store.step4', $application->id) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Photo -->
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photograph <span class="text-danger">*</span></label>
                            <input type="file" name="photo" class="form-control" id="photo" accept="image/*" required>
                            @if($documents->where('type', 'photo')->first())
                                <small class="form-text text-muted">
                                    Current: <a href="{{ Storage::url($documents->where('type', 'photo')->first()->file_path) }}" target="_blank">View</a>
                                </small>
                            @endif
                            @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Signature -->
                        <div class="mb-3">
                            <label for="signature" class="form-label">Signature <span class="text-danger">*</span></label>
                            <input type="file" name="signature" class="form-control" id="signature" accept="image/*" required>
                            @if($documents->where('type', 'signature')->first())
                                <small class="form-text text-muted">
                                    Current: <a href="{{ Storage::url($documents->where('type', 'signature')->first()->file_path) }}" target="_blank">View</a>
                                </small>
                            @endif
                            @error('signature') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category Certificate -->
                        <div class="mb-3">
                            <label for="category_cert" class="form-label">Category Certificate (if applicable)</label>
                            <input type="file" name="category_cert" class="form-control" id="category_cert" accept=".pdf,.jpg,.png">
                            @if($documents->where('type', 'category_cert')->first())
                                <small class="form-text text-muted">
                                    Current: <a href="{{ Storage::url($documents->where('type', 'category_cert')->first()->file_path) }}" target="_blank">View</a>
                                </small>
                            @endif
                            @error('category_cert') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- PwBD Certificate -->
                        <div class="mb-3">
                            <label for="pwbd_cert" class="form-label">PwBD Certificate (if applicable)</label>
                            <input type="file" name="pwbd_cert" class="form-control" id="pwbd_cert" accept=".pdf,.jpg,.png">
                            @if($documents->where('type', 'pwbd_cert')->first())
                                <small class="form-text text-muted">
                                    Current: <a href="{{ Storage::url($documents->where('type', 'pwbd_cert')->first()->file_path) }}" target="_blank">View</a>
                                </small>
                            @endif
                            @error('pwbd_cert') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Preview Modal Trigger -->
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" 
                                    data-bs-target="#previewModal">Preview</button>
                            <a href="{{ route('application.step3', $application->id) }}" 
                               class="btn btn-secondary">Previous</a>
                            <button type="submit" class="btn btn-primary">Save and Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="preview-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-primary" onclick="$('form').submit()">Save and Next</button>
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

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const preview = document.getElementById('preview-content');
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const content = `<p><strong>${input.name}:</strong></p>` + 
                                (file.type.includes('image') ? 
                                `<img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">` : 
                                `<p>File selected: ${file.name}</p>`);
                    preview.innerHTML += content;
                };
                reader.readAsDataURL(file);
            }
        });
    });
    </script>
@endpush
@endsection