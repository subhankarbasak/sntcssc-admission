<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SNTCSSC - Application Form - Step {{ $step }} | @yield('title')</title>
    <link rel="icon" href="https://csscwb.in/assets/front-end/images/others/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="https://csscwb.in/assets/front-end/images/others/favicon.ico">
    <meta name="Description" content="Satyendra Nath Tagore Civil Services Study Centre is ready to serve as a beacon for UPSC aspirants and provide guidance and mentorship to the leaders of tomorrow">
    <meta name="author" content="Subhankar Basak">
    <meta name="keywords" content="sntcssc, csscwb, satyendra nath tagore civil services study centre">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            /* --primary-color: #2c3e50; */
            --primary-color: #0d6efd;
            --secondary-color: #34495e;
            --header-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            --footer-gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .header {
            background: var(--header-gradient);
            padding: 0.8rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .institute-info {
            position: relative;
            padding-left: 2rem;
        }
        
        .institute-info::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .main-content {
            min-height: calc(100vh - 180px);
            padding: 3rem 0;
            background-color: #f8f9fa;
        }
        
        .footer {
            background: var(--footer-gradient);
            color: white;
            padding: 2.5rem 0 1rem;
            margin-top: auto;
        }
        
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: var(--primary-color);
            z-index: 9999;
            transition: width 0.3s ease;
        }
        
        .social-links a {
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }
        
        .social-links a:hover {
            color: white;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 0.5rem 0;
            }
            
            .logo-container {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .institute-info::before {
                display: none;
            }
            
            .institute-info {
                padding-left: 0;
                text-align: center;
            }
            
            .header-contact {
                display: none;
            }
            
            .main-content {
                padding: 2rem 0;
            }
        }


    /* Style for the spinner */
    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    input[readonly] {
    cursor: not-allowed;
    }

/* Form Css */
.form-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .progress-bar {
            height: 25px;
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
        .form-step { padding: 10px; }
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
/* ./ Form css */

    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Scroll Progress Indicator -->
    <div class="scroll-progress" style="width: 0%;"></div>

    <!-- Sticky Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-1 col-md-2 text-center">
                    <a href="https://csscwb.in">
                        <img src="https://csscwb.in/assets/front-end/images/others/sntcssc-logo.png" alt="Institute Logo" class="img-fluid" style="max-height: 70px;">
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-12 text-center">
                    <div class="institute-info">
                        <h5 class="h5 mb-1 fw-bold text-primary" style="background: linear-gradient(45deg, #2c3e50, #34495e); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Satyendra Nath Tagore Civil Services Study Centre
                        </h5>
                        <h5 class="h5 mb-0 text-secondary fw-semibold">
                            Government of West Bengal
                        </h5>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4 d-none d-md-block header-contact">
                    <p class="text-end mb-0 small">
                        <i class="bi bi-telephone"></i> +91 9051829290<br>
                        <i class="bi bi-envelope"></i> iascoaching.sntcssc@gmail.com<br>
                        <i class="bi bi-geo-alt-fill"></i> NSATI Campus,Block FC, Sector - III, Salt Lake, Kolkata-700106
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content flex-grow-1">
        <div class="container-fluid">
            <x-errors.alert />
    <!--  -->
            <div class="form-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="color: #fff; width: {{ ($step/5)*100 }}%"> {{ $percentage }}%</div>
                </div>
                <div class="step-header">
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @php
                            $steps = [
                                ['icon' => 'bi-person', 'title' => 'Personal Details'],
                                ['icon' => 'bi-telephone', 'title' => 'Communication'],
                                ['icon' => 'bi-briefcase', 'title' => 'Others Detail'],
                                ['icon' => 'bi-shield', 'title' => 'Documents Uploads'],
                                ['icon' => 'bi-file-text', 'title' => 'Review']
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
    <!--  -->
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
        </div>
    </main>

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="mb-3">About Us</h5>
                    <p class="small opacity-75">
                    Satyendra Nath Tagore Civil Services Study Centre is ready to serve as a beacon for UPSC aspirants and provide guidance and mentorship to the leaders of tomorrow.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="https://csscwb.in" target="_blank" class="text-decoration-none text-white opacity-75">Home</a></li>
                        <li><a href="https://csscwb.in/contact" target="_blank" class="text-decoration-none text-white opacity-75">Contact</a></li>
                        <li><a href="https://csscwb.in/all-news" target="_blank" class="text-decoration-none text-white opacity-75">News</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Connect With Us</h5>
                    <div class="social-links">
                        <a href="https://www.facebook.com/sntcssc" target="_blank"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="https://x.com/sntcssc" target="_blank"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="https://www.youtube.com/@sntcssc" target="_blank"><i class="bi bi-youtube fs-5"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 small opacity-75">
                        &copy; {{ date('Y') }} Satyendra Nath Tagore Civil Services Study Centre. All rights reserved.<br>
                        <span class="d-block d-md-inline mt-1">Crafted with <i class="bi bi-heart-fill text-danger"></i> by Team SNTCSSC</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Scroll Progress Script -->
    <script>
        window.addEventListener('scroll', () => {
            const scrollProgress = document.querySelector('.scroll-progress');
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.scrollY / windowHeight) * 100;
            scrollProgress.style.width = scrolled + '%';
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>