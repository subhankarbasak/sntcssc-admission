@extends('layouts.form')

@section('content')
    <h4 class="mb-4"><i class="bi bi-telephone me-2"></i>Application Step 2: Address & Academic Details</h4>
    <form method="POST" action="{{ route('application.store.step2', $application) }}" id="step2Form" class="needs-validation" novalidate>
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
                                            <option value="{{ $state }}" {{ old("addresses.$index.state", $address->state) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a state.</div>
                                </td>
                                <td>
                                    <select name="addresses[{{$index}}][district]" class="form-control district-select" required data-selected="{{ $address->district }}">
                                        <option value="">Select District</option>
                                        @if($address->state && isset($stateDistrictData[$address->state]))
                                            @foreach($stateDistrictData[$address->state] as $district)
                                                <option value="{{ $district }}" {{ old("addresses.$index.district", $address->district) === $district ? 'selected' : '' }}>{{ $district }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Please select a district.</div>
                                </td>
                                <td>
                                    <input type="text" name="addresses[{{$index}}][address_line1]" 
                                           class="form-control" value="{{ old("addresses.$index.address_line1", $address->address_line1) }}" 
                                           placeholder="Address Line 1" required>
                                    <div class="invalid-feedback">Address Line 1 is required.</div>
                                </td>
                                <td>
                                    <input type="text" name="addresses[{{$index}}][post_office]" 
                                           class="form-control" value="{{ old("addresses.$index.post_office", $address->post_office) }}" 
                                           placeholder="Post Office" required>
                                    <div class="invalid-feedback">Post Office is required.</div>
                                </td>
                                <td>
                                    <input type="text" name="addresses[{{$index}}][pin_code]" 
                                           class="form-control" value="{{ old("addresses.$index.pin_code", $address->pin_code) }}" 
                                           placeholder="Pin Code" required pattern="[0-9]{6}">
                                    <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-success mt-2" id="add-address">
                <i class="bi bi-plus"></i> Add Address
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
                                <th colspan="4">
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
                                        <option value="Secondary" {{ old("academic_qualifications.$index.level", $academic->level) === 'Secondary' ? 'selected' : '' }}>Secondary</option>
                                        <option value="Higher Secondary" {{ old("academic_qualifications.$index.level", $academic->level) === 'Higher Secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                        <option value="Graduation" {{ old("academic_qualifications.$index.level", $academic->level) === 'Graduation' ? 'selected' : '' }}>Graduation</option>
                                        <option value="Post Graduation" {{ old("academic_qualifications.$index.level", $academic->level) === 'Post Graduation' ? 'selected' : '' }}>Post Graduation</option>
                                        <option value="Other" {{ old("academic_qualifications.$index.level", $academic->level) === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a level.</div>
                                </td>
                                <td>
                                    <input type="text" name="academic_qualifications[{{$index}}][institute]" 
                                           class="form-control" value="{{ old("academic_qualifications.$index.institute", $academic->institute) }}" 
                                           placeholder="Institute" required>
                                    <div class="invalid-feedback">Institute is required.</div>
                                </td>
                                <td>
                                    <input type="text" name="academic_qualifications[{{$index}}][board_university]" 
                                           class="form-control" value="{{ old("academic_qualifications.$index.board_university", $academic->board_university) }}" 
                                           placeholder="Board/University" required>
                                    <div class="invalid-feedback">Board/University is required.</div>
                                </td>
                                <td>
                                    <input type="number" name="academic_qualifications[{{$index}}][year_passed]" 
                                           class="form-control" value="{{ old("academic_qualifications.$index.year_passed", $academic->year_passed) }}" 
                                           placeholder="Year Passed" min="1900" max="{{ date('Y') }}">
                                    <div class="invalid-feedback">Please enter a valid year.</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-success mt-2" id="add-academic">
                <i class="bi bi-plus"></i> Add Qualification
            </button>
        </div>
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.create', $advertisement) }}" class="btn btn-outline-secondary">Previous</a>
            <div>
                <button type="button" class="btn btn-outline-info me-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                    <i class="bi bi-eye"></i> Preview
                </button>
                <button type="submit" form="step2Form" class="btn btn-primary shadow-sm">Save and Next</button>
            </div>
        </div>
    </div>
@endsection

@section('preview')
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
@endsection

@section('preview-footer')
    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Edit</button>
    <button type="button" class="btn btn-primary shadow-sm" onclick="$('#step2Form').submit()">Save and Next</button>
@endsection

@push('styles')
<style>
    .table { border-radius: 5px; overflow: hidden; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #dc3545; }
</style>
@endpush

@push('scripts')
<script>
const stateDistrictData = {!! json_encode($stateDistrictData) !!};

document.addEventListener('DOMContentLoaded', function() {
    let addressIndex = {{ count($addresses) }};
    let academicIndex = {{ count($academics) }};

    // Initialize state/district dropdowns
    document.querySelectorAll('.state-select').forEach(select => {
        const districtSelect = select.closest('tr').querySelector('.district-select');
        const selectedDistrict = districtSelect.getAttribute('data-selected');

        if (select.value) {
            populateDistricts(districtSelect, select.value);
            if (selectedDistrict) districtSelect.value = selectedDistrict;
        }

        select.addEventListener('change', function() {
            populateDistricts(districtSelect, this.value);
        });
    });

    // Add Address
    document.getElementById('add-address').addEventListener('click', function() {
        if (document.querySelectorAll('.address-block').length >= 2) {
            toastr.error('Maximum 2 addresses allowed (Present and Permanent).');
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
                                <div class="invalid-feedback">Please select a state.</div>
                            </td>
                            <td>
                                <select name="addresses[${addressIndex}][district]" class="form-control district-select" required>
                                    <option value="">Select District</option>
                                </select>
                                <div class="invalid-feedback">Please select a district.</div>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][address_line1]" 
                                       class="form-control" placeholder="Address Line 1" required>
                                <div class="invalid-feedback">Address Line 1 is required.</div>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][post_office]" 
                                       class="form-control" placeholder="Post Office" required>
                                <div class="invalid-feedback">Post Office is required.</div>
                            </td>
                            <td>
                                <input type="text" name="addresses[${addressIndex}][pin_code]" 
                                       class="form-control" placeholder="Pin Code" required pattern="[0-9]{6}">
                                <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        
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
                            <th colspan="4">
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
                                <div class="invalid-feedback">Please select a level.</div>
                            </td>
                            <td>
                                <input type="text" name="academic_qualifications[${academicIndex}][institute]" 
                                       class="form-control" placeholder="Institute" required>
                                <div class="invalid-feedback">Institute is required.</div>
                            </td>
                            <td>
                                <input type="text" name="academic_qualifications[${academicIndex}][board_university]" 
                                       class="form-control" placeholder="Board/University" required>
                                <div class="invalid-feedback">Board/University is required.</div>
                            </td>
                            <td>
                                <input type="number" name="academic_qualifications[${academicIndex}][year_passed]" 
                                       class="form-control" placeholder="Year Passed" required min="1900" max="${new Date().getFullYear()}">
                                <div class="invalid-feedback">Please enter a valid year.</div>
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
            e.target.closest('.address-block').remove();
        }
        if (e.target.classList.contains('remove-academic')) {
            e.target.closest('.academic-block').remove();
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

    // Form validation
    const form = document.getElementById('step2Form');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        form.querySelectorAll('[required]').forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        form.querySelectorAll('input[name$="[pin_code]"]').forEach(pin => {
            if (pin.value && !/^[0-9]{6}$/.test(pin.value)) {
                pin.classList.add('is-invalid');
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please correct the errors in the form.');
        } else {
            toastr.success('Form saved successfully!');
        }
    });

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
                    <td>${level ? level.charAt(0).toUpperCase() + level.slice(1) : '-'}</td>
                    <td>${institute || '-'}</td>
                    <td>${board || '-'}</td>
                    <td>${year || '-'}</td>
                </tr>`;
        });
    });

});

document.addEventListener('DOMContentLoaded', function() {
    // Toastr configuration
    toastr.options = {
        positionClass: 'toast-top-right',
        progressBar: true,
        timeOut: 5000,
        closeButton: true
    };

    @if(session('toastr'))
        toastr['{{ session('toastr.type') }}']('{{ session('toastr.message') }}', 'Notification');
    @endif
});
</script>
@endpush

@php
    $step = 1;
    $percentage = 20;
@endphp