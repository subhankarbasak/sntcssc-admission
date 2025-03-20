@extends('layouts.form')

@push('styles')
<style>
    .preview-addresses, .preview-academics {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Desktop view - Table layout */
    @media (min-width: 768px) {
        .preview-addresses, .preview-academics {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .preview-row {
            display: table-row;
        }

        .preview-cell {
            display: table-cell;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .preview-header {
            display: table-row;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
        }
    }

    /* Mobile view - Card layout */
    @media (max-width: 767.98px) {
        .preview-addresses, .preview-academics {
            display: block;
        }

        .preview-row {
            display: block;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .preview-header {
            display: none; /* Hide headers on mobile */
        }

        .preview-cell {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #eee;
        }

        .preview-cell:last-child {
            border-bottom: none;
        }

        .preview-cell::before {
            content: attr(data-label);
            font-weight: bold;
            color: #495057;
            margin-right: 0.5rem;
            flex: 0 0 40%;
        }

        .preview-cell span {
            flex: 1;
            text-align: right;
            word-break: break-word;
        }
    }

    /* Modal adjustments */
    .modal-dialog {
        max-width: 100%;
        margin: 1rem;
    }

    @media (max-width: 575.98px) {
        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-content {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .modal-body {
            padding: 0.5rem;
        }

        .declaration-section {
            font-size: 0.85rem;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
    }

    /* Typography scaling */
    h6 {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
    }
</style>
@endpush

@section('content')
    <h4 class="mb-4"><i class="bi bi-telephone me-2"></i>Application Step 2: Address & Academic Details</h4>
    <form method="POST" action="{{ route('application.store.step2', $application) }}" id="step2Form" class="needs-validation" novalidate>
        @csrf

        <!-- Addresses -->
        <div class="mb-4">
            <h5 class="text-primary mb-3 fw-bold"><i class="bi bi-geo-alt-fill"></i>Addresses</h5>
            <div id="address-container" class="row g-3">
                @foreach($addresses as $index => $address)
                <div class="col-md-6 address-block" data-index="{{ $index }}">
                    <div class="border rounded p-3 bg-light shadow-sm">
                        <h6 class="mb-3 fw-bold">
                            {{ $address->type === 'present' ? 'Present Address' : 'Permanent Address' }}
                            @if($index > 0)
                            <button type="button" class="btn btn-danger btn-sm float-end remove-address d-none">Remove</button>
                            @endif
                        </h6>
                        <input type="hidden" name="addresses[{{$index}}][id]" value="{{ $address->id ?? '' }}">
                        <input type="hidden" name="addresses[{{$index}}][type]" value="{{ $address->type }}">
                        
                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="addresses[{{$index}}][state]" 
                                        class="form-select state-select @error("addresses.$index.state") is-invalid @enderror" 
                                        required>
                                    <option value="">Select State</option>
                                    @foreach(array_keys($stateDistrictData) as $state)
                                        <option value="{{ $state }}" {{ old("addresses.$index.state", $address->state) === $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>State</label>
                                <div class="invalid-feedback">Please select a state.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="addresses[{{$index}}][district]" 
                                        class="form-select district-select @error("addresses.$index.district") is-invalid @enderror" 
                                        required 
                                        data-selected="{{ $address->district }}">
                                    <option value="">Select District</option>
                                    @if($address->state && isset($stateDistrictData[$address->state]))
                                        @foreach($stateDistrictData[$address->state] as $district)
                                            <option value="{{ $district }}" {{ old("addresses.$index.district", $address->district) === $district ? 'selected' : '' }}>
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label>District</label>
                                <div class="invalid-feedback">Please select a district.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input name="addresses[{{$index}}][address_line1]" 
                                    class="form-control @error("addresses.$index.address_line1") is-invalid @enderror" 
                                    value="{{ old("addresses.$index.address_line1", $address->address_line1) }}" 
                                    required 
                                    placeholder="Address Line 1">
                                <label>Address Line 1</label>
                                <div class="invalid-feedback">Address Line 1 is required.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input name="addresses[{{$index}}][post_office]" 
                                    class="form-control @error("addresses.$index.post_office") is-invalid @enderror" 
                                    value="{{ old("addresses.$index.post_office", $address->post_office) }}" 
                                    required 
                                    placeholder="Post Office">
                                <label>Post Office</label>
                                <div class="invalid-feedback">Post Office is required.</div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="form-floating">
                                <input name="addresses[{{$index}}][pin_code]" 
                                    class="form-control @error("addresses.$index.pin_code") is-invalid @enderror" 
                                    value="{{ old("addresses.$index.pin_code", $address->pin_code) }}" 
                                    required 
                                    pattern="[0-9]{6}" 
                                    placeholder="Pin Code">
                                <label>Pin Code</label>
                                <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-success mt-3" id="add-address">
                <i class="bi bi-plus"></i> Add Address
            </button>
        </div>

        <!-- Academic Qualifications -->
        <div class="form-section">
            <h5 class="section-title"><i class="bi bi-book-fill"></i>Academic Qualifications</h5>
            <div id="academic-container">
                @foreach($academics as $index => $academic)
                <!-- Secondary -->
                <div class="mb-3 academic-entry" @if($index < 2) data-required="true" @endif data-index="{{ $index }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="hidden" name="academic_qualifications[{{$index}}][id]" value="{{ $academic->id ?? '' }}">
                                <select name="academic_qualifications[{{$index}}][level]" class="form-select" required>
                                    <option value="Secondary" {{ old("academic_qualifications.$index.level", $academic->level) === 'Secondary' ? 'selected' : '' }}>Secondary</option>
                                    <option value="Higher Secondary" {{ old("academic_qualifications.$index.level", $academic->level) === 'Higher Secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                    <option value="Graduation" {{ old("academic_qualifications.$index.level", $academic->level) === 'Graduation' ? 'selected' : '' }}>Graduation</option>
                                    <option value="Post Graduation" {{ old("academic_qualifications.$index.level", $academic->level) === 'Post Graduation' ? 'selected' : '' }}>Post Graduation</option>
                                    <option value="Other" {{ old("academic_qualifications.$index.level", $academic->level) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label>Level</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][institute]" class="form-control" value="{{ old("academic_qualifications.$index.institute", $academic->institute) }}" required placeholder="Enter Institute">
                                <label>Institute</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][board_university]" class="form-control" value="{{ old("academic_qualifications.$index.board_university", $academic->board_university) }}" required placeholder="Enter Board/University">
                                <label>Board/University</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][year_passed]" class="form-control" value="{{ old("academic_qualifications.$index.year_passed", $academic->year_passed) }}" pattern="[0-9]{4}" placeholder="Enter Year">
                                <label>Year Passed</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][subjects]" class="form-control" value="{{ old("academic_qualifications.$index.subjects", $academic->subjects) }}" placeholder="Enter Subjects" required>
                                <label>Subjects</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][total_marks]" class="form-control" value="{{ old("academic_qualifications.$index.total_marks", $academic->total_marks) }}" placeholder="Enter total_marks">
                                <label>Total Marks</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][marks_obtained]" class="form-control" value="{{ old("academic_qualifications.$index.marks_obtained", $academic->marks_obtained) }}" placeholder="Enter marks_obtained">
                                <label>Marks Obtained</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][cgpa]" class="form-control" value="{{ old("academic_qualifications.$index.cgpa", $academic->cgpa) }}" placeholder="Enter cgpa">
                                <label>GPA/CGPA/SGPA</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input name="academic_qualifications[{{$index}}][division]" class="form-control" value="{{ old("academic_qualifications.$index.division", $academic->division) }}" placeholder="Enter division">
                                <label>Division</label>
                            </div>
                        </div>
                        @if($index > 2)
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-academic" onclick="removeAcademic(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-primary mt-2" onclick="addAcademic()">Add Other Qualifications</button>
        </div>
    </form>
@endsection

@section('footer')
    <div class="form-footer">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('application.create', $advertisement) }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Previous</a>
            <button type="button" class="btn btn-primary shadow-sm" id="previewAndNextBtn">
                <i class="bi bi-eye"></i> Preview and Next
            </button>
        </div>
    </div>
@endsection

@section('preview')
    <div class="container-fluid p-0">
        <!-- Addresses Section -->
        <h6 class="text-primary fw-bold mb-3">Addresses</h6>
        <div class="preview-addresses mb-4" id="preview-addresses">
            <!-- Content will be dynamically populated -->
        </div>

        <!-- Academic Qualifications Section -->
        <h6 class="text-primary fw-bold mb-3">Academic Qualifications</h6>
        <div class="preview-academics mb-4" id="preview-academics">
            <!-- Content will be dynamically populated -->
        </div>

        <!-- Declaration -->
        <div class="mt-4 declaration-section">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="declarationCheck" required>
                <label class="form-check-label" for="declarationCheck">
                    I hereby declare that all the information provided is true and correct to the best of my knowledge.
                </label>
            </div>
        </div>
    </div>
@endsection

@section('preview-footer')
    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal"><i class="bi bi-pencil-square"></i> Edit</button>
    <button type="button" class="btn btn-primary shadow-sm" id="saveAndNextBtn" disabled>Save and Next<i class="bi bi-arrow-right ms-2"></i></button>
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
        const container = select.closest('.address-block');
        const districtSelect = container.querySelector('.district-select');
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
            <div class="col-md-6 address-block" data-index="${addressIndex}">
                <div class="border rounded p-3 bg-light shadow-sm">
                    <h6 class="mb-3 fw-bold">
                        ${type === 'present' ? 'Present Address' : 'Permanent Address'}
                        <button type="button" class="btn btn-danger btn-sm float-end remove-address">Remove</button>
                    </h6>
                    <input type="hidden" name="addresses[${addressIndex}][id]" value="">
                    <input type="hidden" name="addresses[${addressIndex}][type]" value="${type}">
                    <div class="mb-3">
                        <div class="form-floating">
                            <select name="addresses[${addressIndex}][state]" class="form-select state-select" required>
                                <option value="">Select State</option>
                                ${Object.keys(stateDistrictData).map(state => 
                                    `<option value="${state}">${state}</option>`).join('')}
                            </select>
                            <label>State</label>
                            <div class="invalid-feedback">Please select a state.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select name="addresses[${addressIndex}][district]" class="form-select district-select" required>
                                <option value="">Select District</option>
                            </select>
                            <label>District</label>
                            <div class="invalid-feedback">Please select a district.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input name="addresses[${addressIndex}][address_line1]" 
                                   class="form-control" 
                                   required 
                                   placeholder="Address Line 1">
                            <label>Address Line 1</label>
                            <div class="invalid-feedback">Address Line 1 is required.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input name="addresses[${addressIndex}][post_office]" 
                                   class="form-control" 
                                   required 
                                   placeholder="Post Office">
                            <label>Post Office</label>
                            <div class="invalid-feedback">Post Office is required.</div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="form-floating">
                            <input name="addresses[${addressIndex}][pin_code]" 
                                   class="form-control" 
                                   required 
                                   pattern="[0-9]{6}" 
                                   placeholder="Pin Code">
                            <label>Pin Code</label>
                            <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
                        </div>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        
        const newBlock = container.querySelector(`[data-index="${addressIndex}"]`);
        const newStateSelect = newBlock.querySelector('.state-select');
        newStateSelect.addEventListener('change', function() {
            const districtSelect = this.closest('.address-block').querySelector('.district-select');
            populateDistricts(districtSelect, this.value);
        });
        addressIndex++;
    });

    // Remove handlers
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-address')) {
            e.target.closest('.address-block').remove();
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

    // Preview and Next button handler
// Replace the existing previewAndNextBtn event listener with this
document.getElementById('previewAndNextBtn').addEventListener('click', function() {
    const form = document.getElementById('step2Form');
    let isValid = true;
    let errorMessages = [];

    // Check all required fields
    form.querySelectorAll('[required]').forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
            
            // Get label text for more specific error message
            const label = input.closest('.form-floating')?.querySelector('label')?.textContent || 'Field';
            const section = input.closest('.address-block') ? 'Address' : 'Academic';
            errorMessages.push(`${section}: ${label} is required`);
        } else {
            input.classList.remove('is-invalid');
        }
    });

    // Check PIN code format specifically
    form.querySelectorAll('input[name$="[pin_code]"]').forEach(pin => {
        if (pin.value && !/^[0-9]{6}$/.test(pin.value)) {
            pin.classList.add('is-invalid');
            isValid = false;
            errorMessages.push('Address: Please enter a valid 6-digit PIN code');
        }
    });

    // Check year format
    form.querySelectorAll('input[name$="[year_passed]"]').forEach(year => {
        if (year.value && !/^[0-9]{4}$/.test(year.value)) {
            year.classList.add('is-invalid');
            isValid = false;
            errorMessages.push('Academic: Please enter a valid 4-digit year');
        }
    });

    if (!isValid) {
        // Show all error messages in one toastr notification
        toastr.error(errorMessages.join('<br>'), 'Validation Error', {
            timeOut: 7000,  // Longer timeout to read multiple messages
            extendedTimeOut: 3000,
            allowHtml: true
        });
        return;
    }

    // If we get here, form is valid - proceed with preview population
    const addressContainer = document.getElementById('preview-addresses');
    const academicContainer = document.getElementById('preview-academics');
    addressContainer.innerHTML = '';
    academicContainer.innerHTML = '';

    // Address preview - Header (only for desktop)
    addressContainer.innerHTML = `
        <div class="preview-header">
            <div class="preview-cell">Type</div>
            <div class="preview-cell">State</div>
            <div class="preview-cell">District</div>
            <div class="preview-cell">Address Line 1</div>
            <div class="preview-cell">Post Office</div>
            <div class="preview-cell">Pin Code</div>
        </div>`;

    // Address preview - Data
    document.querySelectorAll('.address-block').forEach(block => {
        const type = block.querySelector('input[name*="[type]"]').value;
        const state = block.querySelector('.state-select').value;
        const district = block.querySelector('.district-select').value;
        const addressLine1 = block.querySelector('input[name*="[address_line1]"]').value;
        const postOffice = block.querySelector('input[name*="[post_office]"]').value;
        const pinCode = block.querySelector('input[name*="[pin_code]"]').value;

        addressContainer.innerHTML += `
            <div class="preview-row">
                <div class="preview-cell" data-label="Type"><span>${type.charAt(0).toUpperCase() + type.slice(1)}</span></div>
                <div class="preview-cell" data-label="State"><span>${state || '-'}</span></div>
                <div class="preview-cell" data-label="District"><span>${district || '-'}</span></div>
                <div class="preview-cell" data-label="Address Line 1"><span>${addressLine1 || '-'}</span></div>
                <div class="preview-cell" data-label="Post Office"><span>${postOffice || '-'}</span></div>
                <div class="preview-cell" data-label="Pin Code"><span>${pinCode || '-'}</span></div>
            </div>`;
    });

    // Academic preview - Header (only for desktop)
    academicContainer.innerHTML = `
        <div class="preview-header">
            <div class="preview-cell">Level</div>
            <div class="preview-cell">Institute</div>
            <div class="preview-cell">Board/University</div>
            <div class="preview-cell">Year Passed</div>
            <div class="preview-cell">Subjects</div>
            <div class="preview-cell">Total Marks</div>
            <div class="preview-cell">Marks Obtained</div>
            <div class="preview-cell">GPA/CGPA/SGPA</div>
            <div class="preview-cell">Division</div>
        </div>`;

    // Academic preview - Data
    document.querySelectorAll('.academic-entry').forEach(entry => {
        const level = entry.querySelector('select[name*="[level]"]').value;
        const institute = entry.querySelector('input[name*="[institute]"]').value;
        const board = entry.querySelector('input[name*="[board_university]"]').value;
        const year = entry.querySelector('input[name*="[year_passed]"]').value;
        const subjects = entry.querySelector('input[name*="[subjects]"]').value;
        const tmarks = entry.querySelector('input[name*="[total_marks]"]').value;
        const marksobt = entry.querySelector('input[name*="[marks_obtained]"]').value;
        const gpa = entry.querySelector('input[name*="[cgpa]"]').value;
        const division = entry.querySelector('input[name*="[division]"]').value;

        academicContainer.innerHTML += `
            <div class="preview-row">
                <div class="preview-cell" data-label="Level"><span>${level ? level.charAt(0).toUpperCase() + level.slice(1) : '-'}</span></div>
                <div class="preview-cell" data-label="Institute"><span>${institute || '-'}</span></div>
                <div class="preview-cell" data-label="Board/University"><span>${board || '-'}</span></div>
                <div class="preview-cell" data-label="Year Passed"><span>${year || '-'}</span></div>
                <div class="preview-cell" data-label="Subjects"><span>${subjects || '-'}</span></div>
                <div class="preview-cell" data-label="Total Marks"><span>${tmarks || '-'}</span></div>
                <div class="preview-cell" data-label="Marks Obtained"><span>${marksobt || '-'}</span></div>
                <div class="preview-cell" data-label="GPA/CGPA/SGPA"><span>${gpa || '-'}</span></div>
                <div class="preview-cell" data-label="Division"><span>${division || '-'}</span></div>
            </div>`;
    });
    
    // Show preview modal only if validation passes
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    previewModal.show();
});

    // Declaration checkbox handler
    const declarationCheck = document.getElementById('declarationCheck');
    const saveAndNextBtn = document.getElementById('saveAndNextBtn');
    
    declarationCheck.addEventListener('change', function() {
        saveAndNextBtn.disabled = !this.checked;
    });

    // Save and Next button handler
    saveAndNextBtn.addEventListener('click', function() {
        if (declarationCheck.checked) {
            document.getElementById('step2Form').submit();
        }
    });

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

<script>
    function addAcademic() {
        const container = document.getElementById('academic-container');
        const index = container.children.length;
        const html = `
            <div class="mb-3 academic-entry">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select name="academic_qualifications[${index}][level]" class="form-select" required>
                                <option value="">Select Level</option>
                                <option value="Post Graduation">Post Graduation</option>
                                <option value="Others">Others</option>
                            </select>
                            <label>Level</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][institute]" class="form-control" required placeholder="Enter Institute">
                            <label>Institute</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][board_university]" class="form-control" required placeholder="Enter Board/University">
                            <label>Board/University</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input name="academic_qualifications[${index}][year_passed]" class="form-control" required pattern="[0-9]{4}" placeholder="Enter Year">
                            <label>Year Passed</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-academic" onclick="removeAcademic(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeAcademic(button) {
        const entry = button.closest('.academic-entry');
        if (!entry.dataset.required) {
            entry.remove();
            // Re-index remaining entries
            const container = document.getElementById('academic-container');
            Array.from(container.children).forEach((entry, index) => {
                const inputs = entry.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.name.replace(/academic_qualifications\[\d+\]/, `academic_qualifications[${index}]`);
                    input.name = name;
                });
            });
        }
    }
</script>
<script>
    const form = document.getElementById('step2Form');
    const nextBtn = document.getElementById('saveAndNextBtn');
    nextBtn.addEventListener('click', function() {
        // Add spinner and disable button
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<span class="spinner"></span>Processing...';
        
        // Submit the form
        form.submit();
    });
</script>
@endpush

@php
    $step = 2;
    $percentage = 20;
@endphp