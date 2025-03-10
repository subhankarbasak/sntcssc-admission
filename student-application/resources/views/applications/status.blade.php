<!-- resources/views/applications/status.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Application Status</h4>
                </div>
                <div class="card-body">
                    <!-- Application Overview -->
                    <div class="mb-4">
                        <h5>Application Details</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%">Application Number</th>
                                    <td>{{ $application->application_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Advertisement</th>
                                    <td>{{ $application->advertisement->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>
                                        <span class="badge {{ $application->status === 'submitted' ? 'bg-success' : ($application->status === 'draft' ? 'bg-warning' : 'bg-info') }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Payment Status</th>
                                    <td>
                                        <span class="badge {{ $application->payment_status === 'paid' ? 'bg-success' : ($application->payment_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($application->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($application->applied_at)
                                <tr>
                                    <th scope="row">Submitted On</th>
                                    <td>{{ \Carbon\Carbon::parse($application->applied_at)->format('d M Y H:i') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Details -->
                    @if($application->payment)
                        <div class="mb-4">
                            <h5>Payment Details</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 30%">Amount</th>
                                        <td>₹{{ number_format($application->payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Method</th>
                                        <td>{{ $application->payment->method }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Transaction Date</th>
                                        <td>{{ \Carbon\Carbon::parse($application->payment->transaction_date)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Transaction ID</th>
                                        <td>{{ $application->payment->transaction_id }}</td>
                                    </tr>
                                    @if($application->payment->screenshot)
                                    <tr>
                                        <th scope="row">Screenshot</th>
                                        <td>
                                            <a href="{{ Storage::url($application->payment->screenshot->file_path) }}" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Personal Details -->
                    <h5 class="mb-3">Personal Details</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 30%">Name</th>
                                <td>{{ $details['profile']->first_name }} {{ $details['profile']->last_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Gender</th>
                                <td>{{ $details['profile']->gender }}</td>
                            </tr>
                            <tr>
                                <th scope="row">DOB</th>
                                <td>{{ \Carbon\Carbon::parse($details['profile']->dob)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Category</th>
                                <td>{{ $details['profile']->category }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ $details['profile']->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile</th>
                                <td>{{ $details['profile']->mobile }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Addresses -->
                    <h5 class="mb-3 mt-4">Addresses</h5>
                    @foreach($details['addresses'] as $address)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6>{{ ucfirst($address->type) }} Address</h6>
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>{{ $address->address_line1 }}, {{ $address->district }}, {{ $address->state }} - {{ $address->pin_code }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <!-- Academic Qualifications -->
                    <h5 class="mb-3 mt-4">Academic Qualifications</h5>
                    @foreach($details['academics'] as $academic)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6>{{ $academic->level }}</h6>
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 30%">Institute</th>
                                            <td>{{ $academic->institute }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Board/University</th>
                                            <td>{{ $academic->board_university }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Year</th>
                                            <td>{{ $academic->year_passed }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <!-- Employment History -->
                    <h5 class="mb-3 mt-4">Employment History</h5>
                    @if($details['employment'])
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%">Employed</th>
                                    <td>{{ $details['employment']->is_employed ? 'Yes' : 'No' }}</td>
                                </tr>
                                @if($details['employment']->is_employed)
                                <tr>
                                    <th scope="row">Designation</th>
                                    <td>{{ $details['employment']->designation }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Employer</th>
                                    <td>{{ $details['employment']->employer }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Location</th>
                                    <td>{{ $details['employment']->location }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    @else
                        <p>No employment details provided.</p>
                    @endif

                    <!-- Current Enrollment -->
                    <h5 class="mb-3 mt-4">Current Enrollment</h5>
                    @if($details['enrollment'] && ($details['enrollment']->course_name || $details['enrollment']->institute))
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%">Course</th>
                                    <td>{{ $details['enrollment']->course_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Institute</th>
                                    <td>{{ $details['enrollment']->institute }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No current enrollment details provided.</p>
                    @endif

                    <!-- UPSC Attempts -->
                    <h5 class="mb-3 mt-4">UPSC Attempts</h5>
                    @forelse($details['upsc_attempts'] as $attempt)
                        <div class="card mb-2">
                            <div class="card-body">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 30%">Year</th>
                                            <td>{{ $attempt->exam_year }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Roll Number</th>
                                            <td>{{ $attempt->roll_number }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Prelims Cleared</th>
                                            <td>{{ $attempt->prelims_cleared ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Mains Cleared</th>
                                            <td>{{ $attempt->mains_cleared ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p>No UPSC attempts recorded.</p>
                    @endforelse

                    <!-- Documents -->
                    <h5 class="mb-3 mt-4">Documents</h5>
                    <table class="table table-bordered">
                        <tbody>
                            @foreach($details['documents'] as $document)
                            <tr>
                                <th scope="row" style="width: 30%">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</th>
                                <td>
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-end mt-4">
                        <a href="{{ route('application.download', $application->id) }}" 
                        class="btn btn-success me-2">Download PDF</a>
                        <a href="{{ route('dashboard') }}" 
                        class="btn btn-primary">Back to Dashboard</a>
                    </div>
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