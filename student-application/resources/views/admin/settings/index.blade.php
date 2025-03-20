<!-- resources/views/settings/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application Settings</h5>
                    <span class="badge bg-light text-dark">
                        Last updated: {{ $settings->updated_at->format('d M Y H:i') }}
                    </span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            @if(session('maintenance_notice'))
                                <br>{{ session('maintenance_notice') }}
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- General Settings -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2">General Settings</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Application Name</label>
                                    <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                           name="app_name" value="{{ old('app_name', $settings->app_name) }}" required>
                                    @error('app_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" value="{{ old('title', $settings->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- SEO Settings -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2">SEO Settings</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           name="meta_title" value="{{ old('meta_title', $settings->meta_title) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              name="meta_description" rows="3">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Appearance -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2">Appearance</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                                    @if($settings->logo)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                    @endif
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Icon</label>
                                    <input type="file" class="form-control @error('icon') is-invalid @enderror" name="icon">
                                    @if($settings->icon)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->icon) }}" alt="Icon" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                    @endif
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Format Settings -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2">Format Settings</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Language</label>
                                    <select class="form-select @error('language') is-invalid @enderror" name="language">
                                        <option value="en" {{ $settings->language === 'en' ? 'selected' : '' }}>English</option>
                                        <option value="es" {{ $settings->language === 'es' ? 'selected' : '' }}>Spanish</option>
                                        <!-- Add more languages as needed -->
                                    </select>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date Format</label>
                                    <input type="text" class="form-control @error('date_format') is-invalid @enderror" 
                                           name="date_format" value="{{ old('date_format', $settings->date_format) }}" required>
                                    @error('date_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Time Format</label>
                                    <input type="text" class="form-control @error('time_format') is-invalid @enderror" 
                                           name="time_format" value="{{ old('time_format', $settings->time_format) }}" required>
                                    @error('time_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Currency</label>
                                    <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" 
                                           name="currency_symbol" value="{{ old('currency_symbol', $settings->currency_symbol) }}" required>
                                    @error('currency_symbol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Maintenance -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2">System Settings</h6>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Copyright Text</label>
                                    <input type="text" class="form-control @error('copyright_text') is-invalid @enderror" 
                                           name="copyright_text" value="{{ old('copyright_text', $settings->copyright_text) }}">
                                    @error('copyright_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" 
                                           value="1" {{ $settings->maintenance_mode ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold">Maintenance Mode</label>
                                    <small class="form-text text-muted d-block">
                                        Enable to put the application in maintenance mode (except admin routes)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Save Settings
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }
        .form-label.fw-bold {
            color: #2c3e50;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
    </style>
@endsection