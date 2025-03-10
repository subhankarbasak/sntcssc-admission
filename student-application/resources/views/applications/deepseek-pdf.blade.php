<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application - {{ $application->application_number }}</title>
    <style>
        @page { 
            margin: 15mm; 
            margin-top: 25mm; 
            margin-bottom: 20mm; 
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            line-height: 1.3; 
            color: #333; 
        }
        .container { 
            width: 98%; 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 10px; 
        }
        .header { 
            position: fixed; 
            top: -25mm; 
            left: 0; 
            right: 0; 
            height: 25mm; 
            text-align: center; 
            padding: 5px 0; 
            border-bottom: 2px solid #003087; 
        }
        .header img { 
            max-height: 20mm; 
            margin-right: 10px; 
            vertical-align: middle; 
        }
        .header .institute { 
            display: inline-block; 
            vertical-align: middle; 
        }
        .header .institute h1 { 
            margin: 0; 
            font-size: 12pt; 
            color: #003087; 
            font-weight: bold; 
        }
        .header .institute p { 
            margin: 2px 0; 
            font-size: 9pt; 
            color: #666; 
        }
        .footer { 
            position: fixed; 
            bottom: -15mm; 
            left: 0; 
            right: 0; 
            text-align: center; 
            font-size: 8pt; 
            color: #666; 
            padding: 5px 0; 
        }
        .section { 
            margin-bottom: 15px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 10px; 
        }
        .section-title { 
            color: #003087; 
            font-size: 11pt; 
            font-weight: bold; 
            margin-bottom: 8px; 
        }
        .info-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 10px; 
        }
        .info-table th, .info-table td { 
            border: 1px solid #eee; 
            padding: 6px; 
            text-align: left; 
            font-size: 9pt; 
        }
        .info-table th { 
            background-color: #f5f5f5; 
            color: #003087; 
            font-weight: bold; 
        }
        .info-table td { 
            color: #333; 
        }
        .image-container { 
            text-align: center; 
            margin: 10px 0; 
        }
        .image-container img { 
            max-width: 120px; 
            max-height: 120px; 
            border: 1px solid #ddd; 
            padding: 3px; 
        }
        .status-badge { 
            display: inline-block; 
            padding: 3px 8px; 
            border-radius: 4px; 
            font-size: 8pt; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .success { 
            background-color: #28a745; 
            color: white; 
        }
        .warning { 
            background-color: #ffc107; 
            color: white; 
        }
        .info { 
            background-color: #17a2b8; 
            color: white; 
        }
    </style>
</head>
<body>
    <!-- Header with Logo and Institute Details -->
    <div class="header">
        @if($logo_base64)
            <img src="data:image/png;base64,{{ $logo_base64 }}" alt="Institute Logo">
        @endif
        <div class="institute">
            <h1>{{ $institute_name }}</h1>
            <p>{{ $institute_address }}</p>
        </div>
    </div>

    <!-- Footer with Page Numbers -->
    <div class="footer">
        Page <span class="pageNumber"></span> of <span class="totalPages"></span>
    </div>

    <div class="container">
        <!-- Application Overview -->
        <div class="section">
            <div class="section-title">Application Overview</div>
            <table class="info-table">
                <tr>
                    <th>Application Number</th>
                    <td>{{ $application->application_number }}</td>
                    <th>Status</th>
                    <td><span class="status-badge {{ $application->status === 'submitted' ? 'success' : ($application->status === 'draft' ? 'warning' : 'info') }}">{{ ucfirst($application->status) }}</span></td>
                </tr>
                <tr>
                    <th>Advertisement</th>
                    <td>{{ $application->advertisement->title }}</td>
                    <th>Payment Status</th>
                    <td><span class="status-badge {{ $application->payment_status === 'paid' ? 'success' : ($application->payment_status === 'pending' ? 'warning' : 'info') }}">{{ ucfirst($application->payment_status) }}</span></td>
                </tr>
                @if($application->applied_at)
                <tr>
                    <th>Submitted On</th>
                    <td colspan="3">{{ \Carbon\Carbon::parse($application->applied_at)->format('d M Y H:i') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Personal Details -->
        <div class="section">
            <div class="section-title">Personal Details</div>
            <table class="info-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td>
                    <th>Gender</th>
                    <td>{{ $details['profile']->gender }}</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</td>
                    <th>Category</th>
                    <td>{{ $details['profile']->category }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $details['profile']->email }}</td>
                    <th>Mobile</th>
                    <td>{{ $details['profile']->mobile }}</td>
                </tr>
            </table>
        </div>

        <!-- Addresses -->
        <div class="section">
            <div class="section-title">Addresses</div>
            @foreach($details['addresses'] as $address)
                <table class="info-table">
                    <tr>
                        <th colspan="2">{{ ucfirst($address->type) }} Address</th>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $address->address_line1 }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $address->district }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $address->state }}</td>
                    </tr>
                    <tr>
                        <th>Pin Code</th>
                        <td>{{ $address->pin_code }}</td>
                    </tr>
                </table>
            @endforeach
        </div>

        <!-- Academic Qualifications -->
        <div class="section">
            <div class="section-title">Academic Qualifications</div>
            @foreach($details['academics'] as $academic)
                <table class="info-table">
                    <tr>
                        <th colspan="2">{{ $academic->level }}</th>
                    </tr>
                    <tr>
                        <th>Institute</th>
                        <td>{{ $academic->institute }}</td>
                    </tr>
                    <tr>
                        <th>Board/University</th>
                        <td>{{ $academic->board_university }}</td>
                    </tr>
                    <tr>
                        <th>Year Passed</th>
                        <td>{{ $academic->year_passed }}</td>
                    </tr>
                </table>
            @endforeach
        </div>

        <!-- Employment History -->
        <div class="section">
            <div class="section-title">Employment History</div>
            <table class="info-table">
                <tr>
                    <th>Employed</th>
                    <td>{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</td>
                    <th>Designation</th>
                    <td>{{ $details['employment']->is_employed ? $details['employment']->designation : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Employer</th>
                    <td>{{ $details['employment']->is_employed ? $details['employment']->employer : 'N/A' }}</td>
                    <th>Location</th>
                    <td>{{ $details['employment']->is_employed ? $details['employment']->location : 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Current Enrollment -->
        <div class="section">
            <div class="section-title">Current Enrollment</div>
            <table class="info-table">
                <tr>
                    <th>Course Name</th>
                    <td>{{ $details['enrollment']->course_name ?? 'N/A' }}</td>
                    <th>Institute</th>
                    <td>{{ $details['enrollment']->institute ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- UPSC Attempts -->
        <div class="section">
            <div class="section-title">UPSC Attempts</div>
            @forelse($details['upsc_attempts'] as $attempt)
                <table class="info-table">
                    <tr>
                        <th>Exam Year</th>
                        <td>{{ $attempt->exam_year }}</td>
                        <th>Roll Number</th>
                        <td>{{ $attempt->roll_number }}</td>
                    </tr>
                    <tr>
                        <th>Prelims Cleared</th>
                        <td>{{ $attempt->prelims_cleared ? 'Yes' : 'No' }}</td>
                        <th>Mains Cleared</th>
                        <td>{{ $attempt->mains_cleared ? 'Yes' : 'No' }}</td>
                    </tr>
                </table>
            @empty
                <p>No UPSC attempts recorded.</p>
            @endforelse
        </div>

        <!-- Payment Details -->
        @if($application->payment)
            <div class="section">
                <div class="section-title">Payment Details</div>
                <table class="info-table">
                    <tr>
                        <th>Amount</th>
                        <td>₹{{ number_format($application->payment->amount, 2) }}</td>
                        <th>Method</th>
                        <td>{{ $application->payment->method }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{ \Carbon\Carbon::parse($application->payment->transaction_date)->format('d M Y') }}</td>
                        <th>Transaction ID</th>
                        <td>{{ $application->payment->transaction_id }}</td>
                    </tr>
                </table>
            </div>
        @endif

        <!-- Documents -->
        <div class="section">
            <div class="section-title">Documents</div>
            <table class="info-table">
                @foreach($details['documents'] as $document)
                    <tr>
                        <th>{{ ucfirst(str_replace('_', ' ', $document->type)) }}</th>
                        <td>Attached</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <!-- Photograph and Signature -->
        <div class="section">
            <div class="section-title">Photograph and Signature</div>
            <div class="image-container">
                @if($photo_base64)
                    <img src="data:image/jpeg;base64,{{ $photo_base64 }}" alt="Photo">
                @else
                    <p>No photo available</p>
                @endif
            </div>
            <div class="image-container">
                @if($signature_base64)
                    <img src="data:image/jpeg;base64,{{ $signature_base64 }}" alt="Signature">
                @else
                    <p>No signature available</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>