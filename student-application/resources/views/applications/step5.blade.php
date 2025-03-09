<!-- resources/views/applications/step5.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Application Step 5: Final Preview & Submission</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('application.submit', $details['application']->id) }}">
                        @csrf

                        <!-- Personal Details -->
                        <h5 class="mb-3">Personal Details</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Name:</strong> {{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</div>
                            <div class="col-md-4"><strong>Gender:</strong> {{ $details['profile']->gender }}</div>
                            <div class="col-md-4"><strong>DOB:</strong>  {{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</div>
                            <div class="col-md-4"><strong>Category:</strong> {{ $details['profile']->category }}</div>
                            <div class="col-md-4"><strong>Email:</strong> {{ $details['profile']->email }}</div>
                            <div class="col-md-4"><strong>Mobile:</strong> {{ $details['profile']->mobile }}</div>
                        </div>

                        <!-- Addresses -->
                        <h5 class="mb-3 mt-4">Addresses</h5>
                        @foreach($details['addresses'] as $address)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>{{ ucfirst($address->type) }} Address</h6>
                                    <p>{{ $address->address_line1 }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Academic Qualifications -->
                        <h5 class="mb-3 mt-4">Academic Qualifications</h5>
                        @foreach($details['academics'] as $academic)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>{{ $academic->level }}</h6>
                                    <p>Institute: {{ $academic->institute }}<br>
                                       Board/University: {{ $academic->board_university }}<br>
                                       Year: {{ $academic->year_passed }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Employment History -->
                        <h5 class="mb-3 mt-4">Employment History</h5>
                        @if($details['employment'])
                            <p>
                                Employed: {{ $details['employment']->is_employed ? 'Yes' : 'No' }}<br>
                                @if($details['employment']->is_employed)
                                    Designation: {{ $details['employment']->designation }}<br>
                                    Employer: {{ $details['employment']->employer }}<br>
                                    Location: {{ $details['employment']->location }}
                                @endif
                            </p>
                        @else
                            <p>No employment details provided.</p>
                        @endif

                        <!-- Current Enrollment -->
                        <h5 class="mb-3 mt-4">Current Enrollment</h5>
                        @if($details['enrollment'] && ($details['enrollment']->course_name || $details['enrollment']->institute))
                            <p>Course: {{ $details['enrollment']->course_name }}<br>
                               Institute: {{ $details['enrollment']->institute }}</p>
                        @else
                            <p>No current enrollment details provided.</p>
                        @endif

                        <!-- UPSC Attempts -->
                        <h5 class="mb-3 mt-4">UPSC Attempts</h5>
                        @forelse($details['upsc_attempts'] as $attempt)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p>Year: {{ $attempt->exam_year }}<br>
                                       Roll Number: {{ $attempt->roll_number }}<br>
                                       Prelims Cleared: {{ $attempt->prelims_cleared ? 'Yes' : 'No' }}<br>
                                       Mains Cleared: {{ $attempt->mains_cleared ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        @empty
                            <p>No UPSC attempts recorded.</p>
                        @endforelse

                        <!-- Documents -->
                        <h5 class="mb-3 mt-4">Documents</h5>
                        @foreach($details['documents'] as $document)
                            <div class="mb-2">
                                <strong>{{ ucfirst(str_replace('_', ' ', $document->type)) }}:</strong>
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank">View</a>
                            </div>
                        @endforeach

                        <div class="text-end mt-4">
                            <a href="{{ route('application.step4', $details['application']->id) }}" 
                               class="btn btn-secondary">Previous</a>
                            <button type="submit" class="btn btn-success">Submit Application</button>
                        </div>
                    </form>
                </div>
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
    </script>
@endpush
@endsection