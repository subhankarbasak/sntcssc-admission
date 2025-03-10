<!-- resources/views/applications/step5_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Step 5 - PDF Preview</title>
    <style>
        /* PDF-specific styles */
        @page {
            margin: 20mm;
            size: A4;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        /* For Watermark */
        body::before {
            content: "Confidential";
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 50pt;
            color: rgba(0, 0, 0, 0.1);
            z-index: -1;
        }
        /* ./ */
        .container {
            width: 100%;
            max-width: 210mm; /* A4 width */
            margin: 0 auto;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            page-break-after: avoid;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .header .badge {
            background-color: #ffffff;
            color: #1e3a8a;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 11pt;
        }
        .content {
            padding: 20px;
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        h2 {
            font-size: 14pt;
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
            page-break-after: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            color: #374151;
            font-weight: 500;
            width: 25%;
        }
        td {
            color: #6b7280;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .col-md-6 {
            width: 50%;
            padding: 0 10px;
            box-sizing: border-box;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
        }
        .card h3 {
            font-size: 12pt;
            color: #374151;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .card p, .card dl {
            margin: 0;
            color: #6b7280;
            font-size: 11pt;
        }
        dl dt {
            font-weight: 500;
            color: #374151;
            width: 30%;
            float: left;
            clear: left;
            margin-bottom: 5px;
        }
        dl dd {
            margin-left: 30%;
            margin-bottom: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-top: 5px;
            page-break-inside: avoid;
        }
        .alert {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            font-size: 11pt;
        }
        .document-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .document-list li {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 11pt;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 10pt;
            color: #6b7280;
            page-break-before: avoid;
        }
        /* Prevent page breaks inside key elements */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Application Step 5: Final Preview</h1>
            <span class="badge">Application ID: {{ $details['application']->id }}</span>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Personal Details -->
            <section class="no-break">
                <h2>Personal Details</h2>
                <table>
                    <tbody>
                        <tr>
                            <th>Full Name</th>
                            <td colspan="3">{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</td>
                            <th>Gender</th>
                            <td>{{ $details['profile']->gender }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $details['profile']->email }}</td>
                            <th>Mobile</th>
                            <td>{{ $details['profile']->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td colspan="3">{{ $details['profile']->category }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Photo and Signature -->
            <section class="no-break">
                <h2>Photo & Signature</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <h3>Student Photo</h3>
                            @if($details['documents']->where('type', 'photo')->first())
                                <img src="{{ public_path(Storage::url($details['documents']->where('type', 'photo')->first()->file_path)) }}"
                                     alt="Student Photo" style="max-height: 150px;">
                            @else
                                <div class="alert">No photo uploaded</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <h3>Signature</h3>
                            @if($details['documents']->where('type', 'signature')->first())
                                <img src="{{ public_path(Storage::url($details['documents']->where('type', 'signature')->first()->file_path)) }}"
                                     alt="Signature" style="max-height: 100px;">
                            @else
                                <div class="alert">No signature uploaded</div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Addresses -->
            <section>
                <h2>Addresses</h2>
                <div class="row">
                    @foreach($details['addresses'] as $address)
                        <div class="col-md-6">
                            <div class="card no-break">
                                <h3>{{ ucfirst($address->type) }} Address</h3>
                                <p>{{ $address->address_line1 }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Academic Qualifications -->
            <section>
                <h2>Academic Qualifications</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Institute</th>
                            <th>Board/University</th>
                            <th>Year Passed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details['academics'] as $academic)
                            <tr>
                                <td>{{ $academic->level }}</td>
                                <td>{{ $academic->institute }}</td>
                                <td>{{ $academic->board_university }}</td>
                                <td>{{ $academic->year_passed }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            <!-- Employment History -->
            <section class="no-break">
                <h2>Employment History</h2>
                <div class="card">
                    @if($details['employment'])
                        <dl>
                            <dt>Employed</dt>
                            <dd>{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</dd>
                            @if($details['employment']->is_employed)
                                <dt>Designation</dt>
                                <dd>{{ $details['employment']->designation }}</dd>
                                <dt>Employer</dt>
                                <dd>{{ $details['employment']->employer }}</dd>
                                <dt>Location</dt>
                                <dd>{{ $details['employment']->location }}</dd>
                            @endif
                        </dl>
                    @else
                        <div class="alert">No employment details provided</div>
                    @endif
                </div>
            </section>

            <!-- Current Enrollment -->
            <section class="no-break">
                <h2>Current Enrollment</h2>
                <div class="card">
                    @if($details['enrollment'] && ($details['enrollment']->course_name || $details['enrollment']->institute))
                        <dl>
                            <dt>Course</dt>
                            <dd>{{ $details['enrollment']->course_name }}</dd>
                            <dt>Institute</dt>
                            <dd>{{ $details['enrollment']->institute }}</dd>
                        </dl>
                    @else
                        <div class="alert">No enrollment details provided</div>
                    @endif
                </div>
            </section>

            <!-- UPSC Attempts -->
            <section>
                <h2>UPSC Attempts</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Roll Number</th>
                            <th>Prelims Cleared</th>
                            <th>Mains Cleared</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details['upsc_attempts'] as $attempt)
                            <tr>
                                <td>{{ $attempt->exam_year }}</td>
                                <td>{{ $attempt->roll_number }}</td>
                                <td>{{ $attempt->prelims_cleared ? 'Yes' : 'No' }}</td>
                                <td>{{ $attempt->mains_cleared ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="alert">No UPSC attempts recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <!-- Documents -->
            <section>
                <h2>Uploaded Documents</h2>
                <ul class="document-list">
                    @foreach($details['documents'] as $document)
                        <li class="no-break">
                            <span>{{ ucfirst(str_replace('_', ' ', $document->type)) }}</span>
                            <span>[Attached]</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <!-- Footer -->
            <div class="footer">
                Generated on: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}<br>
                Page <span class="pageNumber"></span> of <span class="totalPages"></span>
            </div>
        </div>
    </div>
</body>
</html>