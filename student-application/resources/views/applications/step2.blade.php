@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="mb-0 font-weight-bold">Application Step 2: Address & Academic Details</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('application.store.step2', $application->id) }}" id="step2Form">
                        @csrf

                        <!-- Addresses -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3 fw-bold">Addresses</h5>
                            <div id="address-container" class="border rounded p-3 bg-light">
                                @foreach($addresses as $index => $address)
                                <div class="address-block mb-3" data-index="{{ $index }}">
                                    <table class="table table-bordered table-hover bg-white shadow-sm">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th colspan="5">
                                                    {{ $address->type === 'present' ? 'Present Address' : 'Permanent Address' }}
                                                    @if($index > 0)
                                                    <button type="button" class="btn btn-danger btn-sm float-end remove-address">Remove</button>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="addresses[{{$index}}][id]" value="{{ $address->id ?? '' }}">
                                                    <input type="hidden" name="addresses[{{$index}}][type]" value="{{ $address->type }}">
                                                    <select name="addresses[{{$index}}][state]" class="form-control state-select" required>
                                                        <option value="">Select State</option>
                                                        @foreach(array_keys($stateDistrictData) as $state)
                                                            <option value="{{ $state }}" {{ $address->state === $state ? 'selected' : '' }}>{{ $state }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="addresses[{{$index}}][district]" class="form-control district-select" required data-selected="{{ $address->district }}">
                                                        <option value="">Select District</option>
                                                        @if($address->state && isset($stateDistrictData[$address->state]))
                                                            @foreach($stateDistrictData[$address->state] as $district)
                                                                <option value="{{ $district }}" {{ $address->district === $district ? 'selected' : '' }}>{{ $district }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="addresses[{{$index}}][address_line1]" 
                                                           class="form-control" value="{{ $address->address_line1 }}" 
                                                           placeholder="Address Line 1" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="addresses[{{$index}}][post_office]" 
                                                           class="form-control" value="{{ $address->post_office }}" 
                                                           placeholder="Post Office" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="addresses[{{$index}}][pin_code]" 
                                                           class="form-control" value="{{ $address->pin_code }}" 
                                                           placeholder="Pin Code" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success mt-2" id="add-address">
                                <i class="fas fa-plus"></i> Add Address
                            </button>
                        </div>

                        <!-- Academic Qualifications -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3 fw-bold">Academic Qualifications</h5>
                            <div id="academic-container" class="border rounded p-3 bg-light">
                                @foreach($academics as $index => $academic)
                                <div class="academic-block mb-3" data-index="{{ $index }}">
                                    <table class="table table-bordered table-hover bg-white shadow-sm">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th colspan="5">
                                                    Qualification Details
                                                    @if($index > 0)
                                                    <button type="button" class="btn btn-danger btn-sm float-end remove-academic">Remove</button>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="academic_qualifications[{{$index}}][id]" value="{{ $academic->id ?? '' }}">
                                                    <select name="academic_qualifications[{{$index}}][level]" class="form-control" required>
                                                        <option value="">Select Level</option>
                                                        <option value="Secondary" {{ $academic->level === 'Secondary' ? 'selected' : '' }}>Secondary</option>
                                                        <option value="Higher Secondary" {{ $academic->level === 'Higher Secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                                        <option value="Graduation" {{ $academic->level === 'Graduation' ? 'selected' : '' }}>Graduation</option>
                                                        <option value="Post Graduation" {{ $academic->level === 'Post Graduation' ? 'selected' : '' }}>Post Graduation</option>
                                                        <option value="Other" {{ $academic->level === 'Other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="academic_qualifications[{{$index}}][institute]" 
                                                           class="form-control" value="{{ $academic->institute }}" 
                                                           placeholder="Institute" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="academic_qualifications[{{$index}}][board_university]" 
                                                           class="form-control" value="{{ $academic->board_university }}" 
                                                           placeholder="Board/University" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="academic_qualifications[{{$index}}][year_passed]" 
                                                           class="form-control" value="{{ $academic->year_passed }}" 
                                                           placeholder="Year Passed" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-success mt-2" id="add-academic">
                                <i class="fas fa-plus"></i> Add Qualification
                            </button>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('application.create', $application->advertisement_id) }}" 
                               class="btn btn-outline-secondary">Previous</a>
                            <div>
                                <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#previewModal">
                                    <i class="fas fa-eye"></i> Preview
                                </button>
                                <button type="submit" class="btn btn-primary">Save and Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="previewModalLabel">Application Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary fw-bold">Addresses</h6>
                <table class="table table-bordered table-striped" id="preview-addresses">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Type</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Address Line 1</th>
                            <th>Post Office</th>
                            <th>Pin Code</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <h6 class="text-primary fw-bold mt-4">Academic Qualifications</h6>
                <table class="table table-bordered table-striped" id="preview-academics">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Level</th>
                            <th>Institute</th>
                            <th>Board/University</th>
                            <th>Year Passed</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// State and District JSON (passed from controller)
const stateDistrictData = {!! json_encode($stateDistrictData ?? [
    "Maharashtra" => ["Mumbai", "Pune", "Nagpur"],
    "Delhi" => ["New Delhi", "North Delhi", "South Delhi"],
    "Karnataka" => ["Bangalore", "Mysore", "Hubli"]
]) !!};

document.addEventListener('DOMContentLoaded', function() {
    let addressIndex = {{ count($addresses) }};
    let academicIndex = {{ count($academics) }};

    // Initialize state/district dropdowns for existing entries
    document.querySelectorAll('.state-select').forEach(select => {
        const districtSelect = select.closest('tr').querySelector('.district-select');
        const selectedDistrict = districtSelect.getAttribute('data-selected'); // Add this attribute in Blade if available

        if (select.value) {
            populateDistricts(districtSelect, select.value);
            if (selectedDistrict) {
                districtSelect.value = selectedDistrict; // Ensure pre-selected district is set
            }
        }

        select.addEventListener('change', function() {
            populateDistricts(districtSelect, this.value);
        });
    });

    // Add Address
    document.getElementById('add-address').addEventListener('click', function() {
        if (document.querySelectorAll('.address-block').length >= 2) {
                alert('Maximum 2 addresses allowed (Present and Permanent).');
                return;
            }
        const container = document.getElementById('address-container');
        const type = addressIndex === 0 ? 'present' : 'permanent';
        const html = `
            <div class="address-block mb-3" data-index="${addressIndex}">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th colspan="5">
                                ${type === 'present' ? 'Present Address' : 'Permanent Address'}
                                <button type="button" class="btn btn-danger btn-sm float-end remove-address">Remove</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="addresses[${addressIndex}][type]" value="${type}">
                                <select name="addresses[${addressIndex}][state]" class="form-control state-select" required>
                                    <option value="">Select State</option>
                                    ${Object.keys(stateDistrictData).map(state => 
                                        `<option value="${state}">${state}</option>`).join('')}
                                </select>
                            </td>
                            <td>
                                <select name="addresses[${addressIndex}][district]" class="form-control district-select" required>
                                    <option value="">Select District</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][address_line1]" 
                                       class="form-control" placeholder="Address Line 1" required>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][post_office]" 
                                       class="form-control" placeholder="Post Office" required>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][pin_code]" 
                                       class="form-control" placeholder="Pin Code" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        
        // Add change event to new state select
        const newStateSelect = container.querySelector(`[data-index="${addressIndex}"] .state-select`);
        newStateSelect.addEventListener('change', function() {
            const districtSelect = this.closest('tr').querySelector('.district-select');
            populateDistricts(districtSelect, this.value);
        });
        addressIndex++;
    });

    // Add Academic Qualification
    document.getElementById('add-academic').addEventListener('click', function() {
        const container = document.getElementById('academic-container');
        const html = `
            <div class="academic-block mb-3" data-index="${academicIndex}">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th colspan="5">
                                Qualification Details
                                <button type="button" class="btn btn-danger btn-sm float-end remove-academic">Remove</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="academic_qualifications[${academicIndex}][level]" class="form-control" required>
                                    <option value="">Select Level</option>
                                    <option value="Secondary">Secondary</option>
                                    <option value="Higher Secondary">Higher Secondary</option>
                                    <option value="Graduation">Graduation</option>
                                    <option value="Post Graduation">Post Graduation</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="academic_qualifications[${academicIndex}][institute]" 
                                       class="form-control" placeholder="Institute" required>
                            </td>
                            <td>
                                <input type="text" name="academic_qualifications[${academicIndex}][board_university]" 
                                       class="form-control" placeholder="Board/University" required>
                            </td>
                            <td>
                                <input type="number" name="academic_qualifications[${academicIndex}][year_passed]" 
                                       class="form-control" placeholder="Year Passed" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        academicIndex++;
    });

    // Remove handlers
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-address')) {
            const block = e.target.closest('.address-block');
            if (block) block.remove();
        }
        if (e.target.classList.contains('remove-academic')) {
            const block = e.target.closest('.academic-block');
            if (block) block.remove();
        }
    });

    // Populate districts function
    function populateDistricts(select, state) {
        select.innerHTML = '<option value="">Select District</option>';
        if (state && stateDistrictData[state]) {
            stateDistrictData[state].forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.text = district;
                select.appendChild(option);
            });
        }
    }

    // Preview Modal
    document.querySelector('[data-bs-target="#previewModal"]').addEventListener('click', function() {
        const addressTable = document.getElementById('preview-addresses').querySelector('tbody');
        const academicTable = document.getElementById('preview-academics').querySelector('tbody');
        
        addressTable.innerHTML = '';
        academicTable.innerHTML = '';

        document.querySelectorAll('.address-block').forEach(block => {
            const type = block.querySelector('input[name*="[type]"]').value;
            const state = block.querySelector('.state-select').value;
            const district = block.querySelector('.district-select').value;
            const addressLine1 = block.querySelector('input[name*="[address_line1]"]').value;
            const postOffice = block.querySelector('input[name*="[post_office]"]').value;
            const pinCode = block.querySelector('input[name*="[pin_code]"]').value;

            addressTable.innerHTML += `
                <tr>
                    <td>${type.charAt(0).toUpperCase() + type.slice(1)}</td>
                    <td>${state || '-'}</td>
                    <td>${district || '-'}</td>
                    <td>${addressLine1 || '-'}</td>
                    <td>${postOffice || '-'}</td>
                    <td>${pinCode || '-'}</td>
                </tr>`;
        });

        document.querySelectorAll('.academic-block').forEach(block => {
            const level = block.querySelector('select[name*="[level]"]').value;
            const institute = block.querySelector('input[name*="[institute]"]').value;
            const board = block.querySelector('input[name*="[board_university]"]').value;
            const year = block.querySelector('input[name*="[year_passed]"]').value;

            academicTable.innerHTML += `
                <tr>
                    <td>${level.charAt(0).toUpperCase() + level.slice(1) || '-'}</td>
                    <td>${institute || '-'}</td>
                    <td>${board || '-'}</td>
                    <td>${year || '-'}</td>
                </tr>`;
        });
    });

    toastr.options = {
        "positionClass": "toast-top-right",
        "progressBar": true
    };

    @if(session('toastr'))
        toastr[{{ session('toastr.type') }}]('{{ session('toastr.message') }}');
    @endif
});
</script>
@endpush

@push('styles')
<style>
    .card { border-radius: 10px; }
    .bg-gradient-primary { background: linear-gradient(45deg, #007bff, #00b4db); }
    .table { border-radius: 5px; overflow: hidden; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
    .btn { border-radius: 5px; padding: 8px 20px; }
    .form-control { border-radius: 5px; }
    .modal-content { border-radius: 10px; }
</style>
@endpush

@endsection