<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Form - Step {{ $step }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .form-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .progress-bar {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px 4px 0 0;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #00c4ff);
            transition: width 0.3s ease;
        }
        .step-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .step-item {
            display: flex;
            align-items: center;
            padding: 8px;
        }
        .step-number {
            width: 24px;
            height: 24px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 0.9rem;
        }
        .active .step-number { background: #0d6efd; color: white; }
        .completed .step-number { background: #198754; }
        .form-step { padding: 30px; }
        .form-footer {
            padding: 20px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 0 0 10px 10px;
        }
        .required::after { content: ' *'; color: #dc3545; }
        .error-message { color: #dc3545; font-size: 0.875rem; }
        .btn-primary {
            background: linear-gradient(90deg, #007bff, #00c4ff);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #0096cc);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ ($step/6)*100 }}%"></div>
            </div>
            <div class="step-header">
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @php
                        $steps = [
                            ['icon' => 'bi-person', 'title' => 'Personal Details'],
                            ['icon' => 'bi-telephone', 'title' => 'Communication'],
                            ['icon' => 'bi-briefcase', 'title' => 'Professional'],
                            ['icon' => 'bi-shield', 'title' => 'Security'],
                            ['icon' => 'bi-file-text', 'title' => 'Documents'],
                            ['icon' => 'bi-check-circle', 'title' => 'Review']
                        ];
                    @endphp
                    @foreach($steps as $index => $stepInfo)
                        <div class="col">
                            <div class="step-item {{ $step == $index + 1 ? 'active' : ($step > $index + 1 ? 'completed' : '') }}">
                                <span class="step-number">{{ $index + 1 }}</span>
                                <span><i class="bi {{ $stepInfo['icon'] }} me-2"></i>{{ $stepInfo['title'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-step">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
            @yield('footer')
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary" id="previewModalLabel">Application Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @yield('preview')
                </div>
                <div class="modal-footer bg-light border-top">
                    @yield('preview-footer')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('scripts')
</body>
</html>