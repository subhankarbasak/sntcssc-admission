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
        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: #ffffff;
            /* padding: 1.2rem 0; */
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0d6efd !important;
        }

        .nav-link {
            color: #495057 !important;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #0d6efd !important;
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
        .footer {
            background: #ffffff;
            color: #6c757d;
            padding: 2rem 1rem;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid #e9ecef;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .header {
                /* padding: 1rem 0; */
            }

            .navbar-brand {
                font-size: 1.5rem;
            }

            .nav-link {
                padding: 0.5rem 1rem;
            }

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
            .navbar-brand {
                font-size: 1.3rem;
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
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">SNTCSSC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
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
                        <p class="timeline-text">Visit the <a href="https://admission.sntcssc.in" target="_blank">SNTCSSC Admission Portal</a> and click <strong>Register</strong>, or go directly to <a href="https://admission.sntcssc.in/register" target="_blank">https://admission.sntcssc.in/register</a>. Provide the following:</p>
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
                        <p class="timeline-text">Go to <a href="https://admission.sntcssc.in" target="_blank">SNTCSSC Admission Portal</a> and click <strong>Login</strong>, or use <a href="https://admission.sntcssc.in/login" target="_blank">https://admission.sntcssc.in/login</a>. Enter your <strong>Email ID</strong> and <strong>Password</strong>.</p>
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

    <footer class="footer">
        <div class="container">
            <p>© 2025 SNTCSSC. All Rights Reserved.</p>
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