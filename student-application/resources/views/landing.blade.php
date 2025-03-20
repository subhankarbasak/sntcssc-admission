<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satyendra Nath Tagore Civil Services Study Centre | @yield('title')</title>
    <link rel="icon" href="https://csscwb.in/assets/front-end/images/others/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="https://csscwb.in/assets/front-end/images/others/favicon.ico">
    <meta name="Description" content="Satyendra Nath Tagore Civil Services Study Centre is ready to serve as a beacon for UPSC aspirants and provide guidance and mentorship to the leaders of tomorrow">
    <meta name="author" content="Subhankar Basak">
    <meta name="keywords" content="sntcssc, csscwb, satyendra nath tagore civil services study centre">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        :root {
            /* --primary-color: #2c3e50; */
            --primary-color: #0d6efd;
            --secondary-color: #34495e;
            --header-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            --footer-gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* New Header Styles */
        .header {
            background: #ffffff;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1000;
        }


        
        .footer {
            background: var(--footer-gradient);
            color: white;
            padding: 2.5rem 0 1rem;
            margin-top: auto;
        }

        .navbar {
            padding: 0;
            margin-bottom: 1rem;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .institute-info {
            line-height: 1.3;
        }

        .institute-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .institute-gov {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .navbar-nav .nav-link {
            color: #111827;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            text-transform: capitalize;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #1e40af;
        }

        .navbar-nav .nav-item {
            margin: 0 0.5rem;
        }

        .dropdown-menu {
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-radius: 4px;
            padding: 0.5rem 0;
            background: #ffffff;
            margin-top: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            color: #111827;
            font-weight: 500;
            font-size: 0.875rem;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            transition: color 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f9fafb;
            color: #1e40af;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem 0.75rem;
            background: transparent;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(17, 24, 39, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.5em;
            height: 1.5em;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(30,64,175,0.2);
        }

        .header-contact {
            font-size: 0.875rem;
            color: #6b7280;
            gap: 2rem;
            font-weight: 400;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
        }

        .mobile-contact {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .contact-wrapper {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .contact-wrapper .contact-item {
            padding: 0.25rem 0;
        }

        /* Hero Section */
        .hero {
            background: #ffffff;
            padding: 6rem 1rem 4rem;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        /* Timeline Section */
        .timeline-section {
            padding: 4rem 1rem;
            background: #f8f9fa;
        }

        .timeline {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 2rem;
            width: 2px;
            background: #0d6efd;
        }

        .timeline-item {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 2.5rem;
            padding: 1.5rem 1.5rem 1.5rem 3.5rem;
            position: relative;
            transition: box-shadow 0.3s ease;
        }

        .timeline-item:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .timeline-number {
            position: absolute;
            top: 1.5rem;
            left: -1.25rem;
            width: 2.5rem;
            height: 2.5rem;
            background: #0d6efd;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .timeline-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.75rem;
        }

        .timeline-content {
            font-size: 1rem;
            color: #495057;
        }

        .timeline-content a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .timeline-content a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
            font-size: 1.1rem;
            border-radius: 6px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background: #0a58ca;
            transform: translateY(-2px);
        }

        /* Footer */
        .social-links a {
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }
        
        .social-links a:hover {
            color: white;
            transform: translateY(-2px);
        }

        /* Mobile Responsiveness */
        @media (max-width: 991px) {
            .header {
                padding: 1rem 0;
            }
            
            .navbar-nav {
                padding: 1rem 0;
                border-top: 1px solid #e5e7eb;
            }
            
            .navbar-nav .nav-item {
                margin: 0.25rem 0;
            }
            
            .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
                text-align: left;
            }
            
            .header-brand {
                width: 100%;
                justify-content: space-between;
                align-items: center;
            }
            
            .institute-info {
                flex: 1;
                padding: 0 1rem;
            }
            
            .dropdown-menu {
                border: none;
                box-shadow: none;
                padding-left: 1rem;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 6rem 1rem 3rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .timeline-section {
                padding: 3rem 0.5rem;
            }

            .timeline::before {
                left: 1.5rem;
            }

            .timeline-item {
                padding: 1.2rem 1.2rem 1.2rem 3rem;
                margin-bottom: 2rem;
            }

            .timeline-number {
                width: 2rem;
                height: 2rem;
                font-size: 1rem;
                left: -1rem;
            }

            .timeline-title {
                font-size: 1.3rem;
            }

            .timeline-content {
                font-size: 0.9rem;
            }

            .btn-primary {
                padding: 0.6rem 1.5rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .institute-title {
                font-size: 1.125rem;
            }
            
            .institute-gov {
                font-size: 0.8125rem;
            }
            
            .header-brand {
                gap: 0.75rem;
            }
            
            .contact-wrapper .contact-item {
                font-size: 0.8125rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            .timeline::before {
                left: 1.25rem;
            }

            .timeline-item {
                padding: 1rem 1rem 1rem 2.5rem;
            }

            .timeline-number {
                top: 1rem;
                left: -0.75rem;
            }
        }

        @media (min-width: 992px) {
            .header-contact {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <!-- New Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid px-0">
                    <div class="header-brand">
                        <a href="{{ url('/') }}" class="navbar-brand">
                            <img src="https://csscwb.in/assets/front-end/images/others/sntcssc-logo.png" alt="Institute Logo" class="img-fluid" style="max-height: 45px;">
                        </a>
                        <div class="institute-info">
                            <h5 class="institute-title mb-0">Satyendra Nath Tagore Civil Services Study Centre</h5>
                            <p class="institute-gov mt-1 mb-0">Government of West Bengal</p>
                        </div>
                    </div>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://csscwb.in/whats-new">Notifications</a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" href="https://csscwb.in/about-us">About</a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" href="https://csscwb.in/contact">Contact</a>
                            </li>
                            <li class="nav-item dropdown d-none">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Resources
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Study Materials</a></li>
                                    <li><a class="dropdown-item" href="#">Previous Papers</a></li>
                                    <li><a class="dropdown-item" href="#">Important Links</a></li>
                                </ul>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @endauth
                            <li class="nav-item d-lg-none mobile-contact">
                                <div class="contact-wrapper">
                                    <p class="contact-item mb-1"><i class="bi bi-telephone me-2"></i> +91 9051829290</p>
                                    <p class="contact-item mb-1"><i class="bi bi-envelope me-2"></i> iascoaching.sntcssc@gmail.com</p>
                                    <p class="contact-item mb-0"><i class="bi bi-geo-alt me-2"></i> NSATI Campus, FC Block, Sector - III, Salt Lake, Kolkata-700106</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="header-contact d-none d-lg-flex justify-content-end">
                <div class="contact-item">
                    <i class="bi bi-telephone me-2"></i> +91 9051829290
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope me-2"></i> iascoaching.sntcssc@gmail.com
                </div>
                <div class="contact-item">
                    <i class="bi bi-geo-alt me-2"></i> NSATI Campus, FC Block, Sector - III, Salt Lake, Kolkata-700106
                </div>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1 class="hero-title">SNTCSSC Composite Course Batch 2026</h1>
            <p class="hero-subtitle">Follow these steps to register and apply for the SNTCSSC Admission Test with ease.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        </div>
    </section>

    <section class="timeline-section">
        <div class="container">
            <div class="timeline">
                <!-- Step 1 -->
                <div class="timeline-item">
                    <div class="timeline-number">1</div>
                    <h3 class="timeline-title">Create Your Account</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">Visit the <a href="https://admission.sntcssc.in" target="_blank">SNTCSSC Admission Test Portal</a> and click <strong>Register</strong>, or go directly to <a href="https://admission.sntcssc.in/register" target="_blank">https://admission.sntcssc.in/register</a>. Provide the following:</p>
                        <ul>
                            <li>Personal Details</li>
                            <li>Contact Information</li>
                            <li>Address</li>
                            <li>Academic Qualifications</li>
                            <li>Create Your New Password for Login</li>
                        </ul>
                        <p class="text-muted small"><strong>Note:</strong> Ensure all details are correct, as they cannot be modified after submission.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-item">
                    <div class="timeline-number">2</div>
                    <h3 class="timeline-title">Log In</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">Go to <a href="https://admission.sntcssc.in" target="_blank">SNTCSSC Admission Test Portal</a> and click <strong>Login</strong>, or use <a href="https://admission.sntcssc.in/login" target="_blank">https://admission.sntcssc.in/login</a>. Enter your <strong>Email ID</strong> and <strong>Password</strong>.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-item">
                    <div class="timeline-number">3</div>
                    <h3 class="timeline-title">Access Your Dashboard</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">After logging in, you’ll see your <strong>Dashboard</strong> with:</p>
                        <ul>
                            <li><strong>Available Notifications:</strong> Apply for ongoing admission tests.</li>
                            <li><strong>My Applications:</strong> View your submitted applications.</li>
                        </ul>
                        <p>Click <strong>Apply Now</strong> to proceed.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="timeline-item">
                    <div class="timeline-number">4</div>
                    <h3 class="timeline-title">Submit Application</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">Complete the application in four steps:</p>
                        <ol>
                            <li>Personal Details</li>
                            <li>Communication & Academic Qualifications</li>
                            <li>Other Information</li>
                            <li>Document Uploads</li>
                        </ol>
                        <p>Review all information before final submission—no changes are allowed afterward.</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="timeline-item">
                    <div class="timeline-number">5</div>
                    <h3 class="timeline-title">Make Payment</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">Submit payment details:</p>
                        <ul>
                            <li>Transaction Date</li>
                            <li>Transaction No. (UTR/ID)</li>
                            <li>Payment Screenshot</li>
                        </ul>
                        <p>Wait 3 days for confirmation: <strong>Paid</strong>, <strong>Pending</strong>, or <strong>Rejected</strong>.</p>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="timeline-item">
                    <div class="timeline-number">6</div>
                    <h3 class="timeline-title">Save Your Application</h3>
                    <div class="timeline-content">
                        <p class="timeline-text">Download and save the <strong>Application Form PDF</strong> (includes Application ID). Keep it safe for future reference.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fade-in Animation
            const items = document.querySelectorAll('.timeline-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                setTimeout(() => {
                    item.style.transition = 'opacity 0.5s ease';
                    item.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
</body>
</html>