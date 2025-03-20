@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to SNTCSSC!</div>

                <div class="card-body">
                    <h4>Account Creation Successful!</h4>
                    <p>Please save your login credentials (also sent to your email):</p>
                    
                    <div class="alert alert-info">
                        <strong>Email:</strong> {{ $email }}<br>
                        <strong>Password:</strong> {{ $password }}
                    </div>

                    <p class="text-warning">This page will only be shown once after registration.</p>
                    
                    <div class="alert alert-warning">
                        <strong>Important:</strong> This is only confirmation of your account creation. 
                        To appear for the admission test for SNTCSSC Composite Course 2026 batch, 
                        you need to apply from the Dashboard page in the "Available Notifications" section.
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button id="download-pdf" class="btn btn-success">
                            <i class="bi bi-file-pdf"></i> Save as PDF
                        </button>

                        @if (Auth::check())
                            <form action="{{ route('proceed-to-dashboard') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Proceed to Dashboard <i class="bi bi-arrow-right"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                Go to Login <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Color Scheme
            const darkBlue = [20, 40, 80];
            const midBlue = [60, 100, 160];
            const lightBlue = [120, 160, 200];
            const white = [255, 255, 255];
            const offWhite = [245, 248, 250];
            const textColor = [20, 20, 20];

            // Gradient Background
            for (let i = 0; i < 297; i++) {
                const gradient = i / 297;
                const r = white[0] + (lightBlue[0] - white[0]) * gradient;
                const g = white[1] + (lightBlue[1] - white[1]) * gradient;
                const b = white[2] + (lightBlue[2] - white[2]) * gradient;
                doc.setDrawColor(r, g, b);
                doc.setLineWidth(1);
                doc.line(0, i, 210, i);
            }

            // Header
            for (let i = 0; i < 50; i++) {
                const gradient = i / 50;
                const r = darkBlue[0] + (midBlue[0] - darkBlue[0]) * gradient;
                const g = darkBlue[1] + (midBlue[1] - darkBlue[1]) * gradient;
                const b = darkBlue[2] + (midBlue[2] - darkBlue[2]) * gradient;
                doc.setDrawColor(r, g, b);
                doc.setLineWidth(1);
                doc.line(0, i, 210, i);
            }

            doc.setFontSize(25);
            doc.setTextColor(...white);
            doc.setFont('helvetica', 'bold');
            doc.text('Welcome to SNTCSSC!', 20, 25);
            doc.setFontSize(12);
            doc.setFont('helvetica', 'normal');
            doc.text('Account Creation Confirmation', 20, 38);

            // Content Container
            doc.setFillColor(...offWhite);
            doc.roundedRect(15, 60, 180, 200, 5, 5, 'F');
            doc.setDrawColor(...midBlue);
            doc.setLineWidth(0.4);
            doc.roundedRect(15, 60, 180, 200, 5, 5);

            // Success Message
            doc.setFontSize(18);
            doc.setTextColor(...textColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Account Creation Successful!', 20, 75);
            doc.setFontSize(11);
            doc.setFont('helvetica', 'normal');
            doc.text('Please save your login credentials:', 20, 85);

            // Credentials Box
            doc.setFillColor(...white);
            doc.roundedRect(20, 95, 170, 60, 3, 3, 'F');
            doc.setDrawColor(...midBlue);
            doc.setLineWidth(0.3);
            doc.roundedRect(20, 95, 170, 60, 3, 3);

            doc.setFontSize(12);
            doc.setTextColor(...textColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Email:', 25, 110);
            doc.text('Password:', 25, 130);
            doc.setFont('helvetica', 'normal');
            doc.text(`{{ $email }}`, 55, 110);
            doc.text(`{{ $password }}`, 55, 130);
            
            // Login Link
            doc.setTextColor(...midBlue);
            doc.setFont('helvetica', 'bold');
            doc.text('Login Here:', 25, 150);
            doc.setFont('helvetica', 'normal');
            doc.textWithLink('https://admission.sntcssc.in', 55, 150, {
                url: 'https://admission.sntcssc.in'
            });

            // Warning Section
            doc.setFontSize(10);
            doc.setTextColor(...midBlue);
            doc.setFont('helvetica', 'italic');
            doc.text('This page will only be shown once after registration.', 20, 170);
            doc.setDrawColor(...lightBlue);
            doc.setLineWidth(0.2);
            doc.line(20, 173, 190, 173);

            // Important Notice
            doc.setFontSize(13);
            doc.setTextColor(...textColor);
            doc.setFont('helvetica', 'bold');
            doc.text('Important:', 20, 185);
            doc.setFontSize(11);
            doc.setFont('helvetica', 'normal');
            const importantText = [
                'This is only confirmation of your account creation.',
                'To appear for the admission test for SNTCSSC Composite',
                'Course 2026 batch, you need to apply from the Dashboard',
                'page in the "Available Notifications" section.'
            ];
            doc.text(importantText, 50, 185);

            // Footer
            for (let i = 0; i < 37; i++) {
                const gradient = i / 37;
                const r = midBlue[0] + (darkBlue[0] - midBlue[0]) * gradient;
                const g = midBlue[1] + (darkBlue[1] - midBlue[1]) * gradient;
                const b = midBlue[2] + (darkBlue[2] - midBlue[2]) * gradient;
                doc.setDrawColor(r, g, b);
                doc.setLineWidth(1);
                doc.line(0, 260 + i, 210, 260 + i);
            }

            doc.setFontSize(12);
            doc.setTextColor(...white);
            doc.text('SNTCSSC Account Creation', 20, 275);
            doc.setFontSize(9);
            doc.text(`Generated: {{ date('Y-m-d H:i:s') }}`, 190, 275, { align: 'right' });
            doc.setFontSize(10);
            doc.textWithLink('Visit us: https://csscwb.in', 20, 285, {
                url: 'https://csscwb.in'
            });
            doc.text('Confidential Document', 190, 285, { align: 'right' });

            // Decorative Elements
            doc.setDrawColor(...midBlue);
            doc.setLineWidth(0.5);
            doc.line(15, 55, 195, 55);
            doc.line(15, 265, 195, 265);

            // Save the PDF
            doc.save('SNTCSSC_Registration_Confirmation.pdf');
        });
    </script>
@endsection
@endsection