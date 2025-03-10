<!-- resources/views/applications/application_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Application Form - {{ $details['application']->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 20mm;
        }
        h1 {
            text-align: center;
            color: #003087;
            border-bottom: 2px solid #003087;
            padding-bottom: 10px;
        }
        h2 {
            color: #003087;
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section {
            page-break-inside: avoid;
        }
        .photo-signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        img {
            max-height: 100px;
            width: auto;
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Student Application Form</h1>
    <p style="text-align: center;">Application ID: {{ $details['application']->id }} | Date: {{ now()->format('d M Y') }}</p>

    <!-- Personal Details -->
    <div class="section">
        <h2>Personal Details</h2>
        <table>
            <tr><th>Full Name</th><td>{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td></tr>
            <tr><th>Gender</th><td>{{ $details['profile']->gender }}</td></tr>
            <tr><th>Date of Birth</th><td>{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</td></tr>
            <tr><th>Category</th><td>{{ $details['profile']->category }}</td></tr>
            <tr><th>Email</th><td>{{ $details['profile']->email }}</td></tr>
            <tr><th>Mobile</th><td>{{ $details['profile']->mobile }}</td></tr>
        </table>
        <div class="photo-signature">
            <div>
                <strong>Photo:</strong><br>
                @if($details['documents']->where('type', 'photo')->first())
                    <img src="{{ public_path(Storage::url($details['documents']->where('type', 'photo')->first()->file_path)) }}" alt="Photo">
                @else
                    <span>No photo uploaded</span>
                @endif
            </div>
            <div>
                <strong>Signature:</strong><br>
                @if($details['documents']->where('type', 'signature')->first())
                    <img src="{{ public_path(Storage::url($details['documents']->where('type', 'signature')->first()->file_path)) }}" alt="Signature">
                @else
                    <span>No signature uploaded</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Addresses -->
    <div class="section">
        <h2>Addresses</h2>
        @foreach($details['addresses'] as $address)
            <table>
                <tr><th>{{ ucfirst($address->type) }} Address</th><td>{{ $address->address_line1 }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}</td></tr>
            </table>
        @endforeach
    </div>

    <!-- Academic Qualifications -->
    <div class="section">
        <h2>Academic Qualifications</h2>
        <table>
            <thead>
                <tr><th>Level</th><th>Institute</th><th>Board/University</th><th>Year Passed</th></tr>
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
    </div>

    <!-- Employment History -->
    <div class="section">
        <h2>Employment History</h2>
        <table>
            @if($details['employment'])
                <tr><th>Employed</th><td>{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</td></tr>
                @if($details['employment']->is_employed)
                    <tr><th>Designation</th><td>{{ $details['employment']->designation }}</td></tr>
                    <tr><th>Employer</th><td>{{ $details['employment']->employer }}</td></tr>
                    <tr><th>Location</th><td>{{ $details['employment']->location }}</td></tr>
                @endif
            @else
                <tr><td colspan="2">No employment details provided.</td></tr>
            @endif
        </table>
    </div>

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i:s') }} | Page <span class="pageNumber"></span> of <span class="totalPages"></span>
    </div>
</body>
</html>