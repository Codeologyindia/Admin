@extends('layouts.admin')

@section('title', 'Online Booking')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center text-primary fw-bold">Book an Appointment</h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Step Indicator -->
                    <div class="mb-4">
                        <ul class="nav nav-pills justify-content-center flex-wrap gap-2">
                            <li class="nav-item">
                                <span class="nav-link active step-indicator" id="step-indicator-1">1. Basic Details</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link step-indicator" id="step-indicator-2">2. Location</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link step-indicator" id="step-indicator-3">3. Hospital</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link step-indicator" id="step-indicator-4">4. Documents</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link step-indicator" id="step-indicator-5">5. Slot</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link step-indicator" id="step-indicator-6">6. Payment</span>
                            </li>
                        </ul>
                    </div>

                    <form id="bookingForm" method="POST" action="{{ route('admin.online-booking.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Query For Section (before Person Name) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Query For <span class="text-danger">*</span></label>
                                <select name="query_type" id="query_type_select" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($queryTypes as $qt)
                                        <option value="{{ $qt->slug }}">{{ $qt->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="query_type_other_div" style="display:none;">
                                <label class="form-label fw-semibold">Other Query Type <span class="text-danger">*</span></label>
                                <input type="text" name="query_type_other" id="query_type_other_input" class="form-control" placeholder="Enter other query type">
                            </div>
                        </div>
                        <!-- Step 1: Basic Details -->
                        <div class="booking-step step-1" style="display:block;">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Person Name <span class="text-danger">*</span></label>
                                    <input type="text" name="person_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Alternate Number</label>
                                    <input type="text" name="alternate_number" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4" onclick="showStep(2)">Next <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                        <!-- Step 2: Location -->
                        <div class="booking-step step-2" style="display:none;">
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary fw-semibold"><i class="bi bi-geo-alt"></i> Location Details</h5>
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                                        <select name="state_id" id="state_select" class="form-select" required style="width:100%">
                                            <option value="all">All</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <input type="text" name="new_state" id="new_state_input" class="form-control mt-2" placeholder="Enter new state name" style="display:none;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                        <select name="city_id" id="city_select" class="form-select" required style="width:100%">
                                            <option value="all">All</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <input type="text" name="new_city" id="new_city_input" class="form-control mt-2" placeholder="Enter new city name" style="display:none;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">District <span class="text-danger">*</span></label>
                                        <select name="district_id" id="district_select" class="form-select" required style="width:100%">
                                            <option value="all">All</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <input type="text" name="new_district" id="new_district_input" class="form-control mt-2" placeholder="Enter new district name" style="display:none;">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="showStep(1)"><i class="bi bi-arrow-left"></i> Previous</button>
                                <button type="button" class="btn btn-primary px-4" onclick="showStep(3)">Next <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                        <!-- Step 3: Hospital & Problem Details -->
                        <div class="booking-step step-3" style="display:none;">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Hospital Name <span class="text-danger">*</span></label>
                                    <select name="hospital_id" id="hospital_select" class="form-select" required style="width:100%">
                                        <option value="all">All</option>
                                    </select>
                                    <input type="text" name="new_hospital" id="new_hospital_input" class="form-control mt-2" placeholder="Enter new hospital name" style="display:none;">
                                    <!-- New: Show type selection if "other" is selected -->
                                    <div id="hospital_type_section" style="display:none;" class="mt-2">
                                        <label class="form-label fw-semibold">Type</label>
                                        <select name="new_hospital_type" id="new_hospital_type" class="form-select">
                                            <option value="">Select Type</option>
                                            <option value="Hospital">Hospital</option>
                                            <option value="Clinic">Clinic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department_select" class="form-select" required style="width:100%">
                                        <option value="all">All</option>
                                    </select>
                                    <input type="text" name="new_department" id="new_department_input" class="form-control mt-2" placeholder="Enter new department name" style="display:none;">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Problem <span class="text-danger">*</span></label>
                                    <input type="text" name="problem" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="showStep(2)"><i class="bi bi-arrow-left"></i> Previous</button>
                                <button type="button" class="btn btn-primary px-4" onclick="showStep(4)">Next <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                        <!-- Step 4: Document Upload & Current Report -->
                        <div class="booking-step step-4" style="display:none;">
                            <div class="mb-4">
                                <div class="card border-0 shadow-sm" style="background: #f8fafc;">
                                    <div class="card-body">
                                        <h5 class="mb-3 text-primary fw-semibold">
                                            <i class="bi bi-file-earmark-arrow-up"></i> Upload Documents
                                        </h5>
                                        <div id="document-upload-section">
                                            <div class="row g-2 document-upload-row mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" name="document_names[]" class="form-control" placeholder="Document Name">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="file" name="documents[]" class="form-control">
                                                </div>
                                                <div class="col-md-2 d-flex align-items-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-document-btn" style="display:none;">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mb-3 mt-2" id="add-document-btn" style="font-weight:600;">
                                            <i class="bi bi-plus-circle"></i> Add Another Document
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="showStep(3)">
                                    <i class="bi bi-arrow-left"></i> Previous
                                </button>
                                <button type="button" class="btn btn-primary px-4" onclick="showStep(5)">
                                    Next <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Step 5: Meeting Slot -->
                        <div class="booking-step step-5" style="display:none;">
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary fw-semibold"><i class="bi bi-calendar-check"></i> Meeting Slot</h5>
                                <div class="mb-3">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold mb-1" for="appointment_date">Select Preferred Date <span class="text-danger">*</span></label>
                                            <input
                                                type="date"
                                                id="appointment_date"
                                                name="appointment_date"
                                                class="form-control"
                                                required
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold mb-1" for="appointment">Select Preferred Time Slot <span class="text-danger">*</span></label>
                                            <input
                                                type="time"
                                                id="appointment"
                                                name="appointment"
                                                class="form-control"
                                                min="09:00"
                                                max="18:00"
                                                required
                                            />
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="showStep(4)"><i class="bi bi-arrow-left"></i> Previous</button>
                                <button type="button" class="btn btn-primary px-4" onclick="showStep(6)">
                                    Next <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Step 6: Payment Details -->
                        <div class="booking-step step-6" style="display:none;">
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary fw-semibold"><i class="bi bi-credit-card"></i> Payment Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control" min="0" step="0.01" placeholder="Total Amount" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Paid Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="paid_amount" class="form-control" min="0" step="0.01" placeholder="Paid Amount" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Payment ID / Reference <span class="text-danger">*</span></label>
                                        <input type="text" name="payment_id" class="form-control" placeholder="Payment Reference" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="showStep(5)"><i class="bi bi-arrow-left"></i> Previous</button>
                                <button type="submit" class="btn btn-success px-4">Book Now <i class="bi bi-check-circle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Choices.js CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    .step-indicator {
        cursor: default;
        opacity: 0.7;
        background: #e9ecef;
        color: #232946;
        margin-right: 5px;
        border-radius: 20px;
        padding: 0.4em 1.2em;
        font-weight: 600;
        font-size: 1rem;
        border: 2px solid #e0e7ef;
        transition: background 0.2s, color 0.2s;
    }
    .step-indicator.active {
        background: #3b82f6 !important;
        color: #fff !important;
        opacity: 1;
        border: 2px solid #3b82f6;
    }
    .card {
        border-radius: 1.1rem;
        box-shadow: 0 2px 16px rgba(34,43,69,0.07);
    }
    .form-label {
        font-size: 0.98rem;
        font-weight: 600;
    }
    .form-control, .form-select {
        border-radius: 0.5rem;
        font-size: 0.97rem;
        border: 1.5px solid #e0e7ef;
        background: #f8fafc;
        transition: border-color 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 0.12rem rgba(59,130,246,0.10);
    }
    .btn-primary, .btn-success, .btn-secondary {
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(59,130,246,0.07);
    }
    .btn-outline-primary {
        border-radius: 0.5rem;
    }
    .booking-step {
        background: #fff;
        border-radius: 0.8rem;
        padding: 1.5rem 1.2rem 1.2rem 1.2rem;
        margin-bottom: 1.2rem;
        border: 1px solid #e0e7ef;
        box-shadow: 0 2px 8px rgba(34,43,69,0.04);
    }
    .booking-step:not(:first-child) {
        margin-top: 1.2rem;
    }
    .booking-step h5 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    .booking-step .btn-outline-primary {
        border-width: 2px;
        font-size: 1rem;
    }
    .booking-step textarea.form-control {
        background: #fff;
        border-radius: 0.5rem;
    }
    .booking-step .row.g-3 > .col-md-4,
    .booking-step .row.g-3 > .col-md-6,
    .booking-step .row.g-3 > .col-md-12 {
        margin-bottom: 0.7rem;
    }
    .booking-step .form-control,
    .booking-step .form-select {
        margin-bottom: 0.2rem;
    }
    .booking-step .form-label {
        margin-bottom: 0.2rem;
    }
    .booking-step .btn {
        min-width: 110px;
    }
    @media (max-width: 991.98px) {
        .booking-step {
            padding: 1rem 0.5rem 1rem 0.5rem;
        }
    }
</style>
<script>
function showStep(step) {
    document.querySelectorAll('.booking-step').forEach(function(div, idx) {
        div.style.display = (idx === (step-1)) ? '' : 'none';
    });
    // Step indicator highlight
    for(let i=1; i<=6; i++) {
        let indicator = document.getElementById('step-indicator-' + i);
        if (indicator) {
            indicator.classList.remove('active');
        }
    }
    let activeIndicator = document.getElementById('step-indicator-' + step);
    if (activeIndicator) {
        activeIndicator.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Hospital Choices
    const hospitalSelect = document.getElementById('hospital_select');
    const newHospitalInput = document.getElementById('new_hospital_input');
    const hospitalTypeSection = document.getElementById('hospital_type_section');
    let hospitalChoices = new Choices(hospitalSelect, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Type at least 3 characters to search',
        searchPlaceholderValue: 'Type at least 3 characters to search',
        shouldSort: false,
        removeItemButton: false,
        searchResultLimit: 10,
        noResultsText: 'No hospitals found',
        itemSelectText: '',
        duplicateItemsAllowed: false,
        renderChoiceLimit: 10,
        searchFields: ['label', 'value'],
        callbackOnCreateTemplates: function(template) { return template; }
    });
    hospitalChoices.clearChoices();
    // Add "All" option initially
    hospitalChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);

    hospitalSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ route('admin.ajax.hospital-search') }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    options = options.concat(data.results.map(h => ({
                        value: h.id,
                        label: h.text,
                        customProperties: {}
                    })));
                    options.push({value: 'other', label: 'Other', customProperties: {}});
                    hospitalChoices.setChoices(options, 'value', 'label', true);
                });
        } else {
            hospitalChoices.clearChoices();
            hospitalChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });

    hospitalSelect.addEventListener('change', function() {
        if (hospitalSelect.value === 'other') {
            newHospitalInput.style.display = 'block';
            hospitalTypeSection.style.display = 'block';
        } else {
            newHospitalInput.style.display = 'none';
            hospitalTypeSection.style.display = 'none';
        }
    });

    // Department Choices
    const departmentSelect = document.getElementById('department_select');
    const newDepartmentInput = document.getElementById('new_department_input');
    let departmentChoices = new Choices(departmentSelect, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Type at least 3 characters to search',
        searchPlaceholderValue: 'Type at least 3 characters to search',
        shouldSort: false,
        removeItemButton: false,
        searchResultLimit: 10,
        noResultsText: 'No departments found',
        itemSelectText: '',
        duplicateItemsAllowed: false,
        renderChoiceLimit: 10,
        searchFields: ['label', 'value'],
        callbackOnCreateTemplates: function(template) { return template; }
    });
    departmentChoices.clearChoices();
    // Add "All" option initially
    departmentChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);

    departmentSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ route('admin.ajax.department-search') }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    options = options.concat(data.results.map(d => ({
                        value: d.id,
                        label: d.text,
                        customProperties: {}
                    })));
                    options.push({value: 'other', label: 'Other', customProperties: {}});
                    departmentChoices.setChoices(options, 'value', 'label', true);
                });
        } else {
            departmentChoices.clearChoices();
            departmentChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });

    departmentSelect.addEventListener('change', function() {
        if (departmentSelect.value === 'other') {
            newDepartmentInput.style.display = 'block';
        } else {
            newDepartmentInput.style.display = 'none';
        }
    });

    // State, City, District Choices
    const stateSelect = document.getElementById('state_select');
    const citySelect = document.getElementById('city_select');
    const districtSelect = document.getElementById('district_select');

    let stateChoices = new Choices(stateSelect, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Type to search state',
        searchPlaceholderValue: 'Type to search state',
        shouldSort: false,
        removeItemButton: false,
        searchResultLimit: 10,
        noResultsText: 'No states found',
        itemSelectText: '',
        duplicateItemsAllowed: false,
        renderChoiceLimit: 20,
        searchFields: ['label', 'value'],
        callbackOnCreateTemplates: function(template) { return template; }
    });
    let cityChoices = new Choices(citySelect, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Type to search city',
        searchPlaceholderValue: 'Type to search city',
        shouldSort: false,
        removeItemButton: false,
        searchResultLimit: 10,
        noResultsText: 'No cities found',
        itemSelectText: '',
        duplicateItemsAllowed: false,
        renderChoiceLimit: 20,
        searchFields: ['label', 'value'],
        callbackOnCreateTemplates: function(template) { return template; }
    });
    let districtChoices = new Choices(districtSelect, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Type to search district',
        searchPlaceholderValue: 'Type to search district',
        shouldSort: false,
        removeItemButton: false,
        searchResultLimit: 10,
        noResultsText: 'No districts found',
        itemSelectText: '',
        duplicateItemsAllowed: false,
        renderChoiceLimit: 20,
        searchFields: ['label', 'value'],
        callbackOnCreateTemplates: function(template) { return template; }
    });

    // State AJAX search
    stateSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/states") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(state) {
                        options.push({value: state.id, label: state.name});
                    });
                    stateChoices.clearChoices();
                    stateChoices.setChoices(options, 'value', 'label', true);
                });
        } else {
            stateChoices.clearChoices();
            stateChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });

    // City AJAX search (no state_id)
    citySelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/cities") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(city) {
                        options.push({value: city.id, label: city.name});
                    });
                    cityChoices.clearChoices();
                    cityChoices.setChoices(options, 'value', 'label', true);
                });
        } else {
            cityChoices.clearChoices();
            cityChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });

    // District AJAX search (no state_id)
    districtSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/districts") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(dist) {
                        options.push({value: dist.id, label: dist.name});
                    });
                    districtChoices.clearChoices();
                    districtChoices.setChoices(options, 'value', 'label', true);
                });
        } else {
            districtChoices.clearChoices();
            districtChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });

    // When state changes, reset city/district
    stateSelect.addEventListener('change', function() {
        cityChoices.clearChoices();
        cityChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        districtChoices.clearChoices();
        districtChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
    });

    // Add "Other" option to Choices.js dynamically for state/city/district
    function ensureOtherOption(choicesInstance) {
        const currentChoices = choicesInstance._store.choices;
        if (!currentChoices.some(opt => opt.value === 'other')) {
            choicesInstance.setChoices([{value: 'other', label: 'Other'}], 'value', 'label', false);
        }
    }

    // State Choices
    stateSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/states") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(state) {
                        options.push({value: state.id, label: state.name});
                    });
                    stateChoices.clearChoices();
                    stateChoices.setChoices(options, 'value', 'label', true);
                    // After setting choices:
                    ensureOtherOption(stateChoices);
                });
        } else {
            stateChoices.clearChoices();
            stateChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });
    stateSelect.addEventListener('change', function() {
        document.getElementById('new_state_input').style.display = (stateSelect.value === 'other') ? 'block' : 'none';
    });

    // City Choices
    citySelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/cities") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(city) {
                        options.push({value: city.id, label: city.name});
                    });
                    cityChoices.clearChoices();
                    cityChoices.setChoices(options, 'value', 'label', true);
                    // After setting choices:
                    ensureOtherOption(cityChoices);
                });
        } else {
            cityChoices.clearChoices();
            cityChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });
    citySelect.addEventListener('change', function() {
        document.getElementById('new_city_input').style.display = (citySelect.value === 'other') ? 'block' : 'none';
    });

    // District Choices
    districtSelect.addEventListener('search', function(e) {
        const searchValue = e.detail.value;
        if (searchValue.length >= 3) {
            fetch(`{{ url("/admin/ajax/districts") }}?term=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    let options = [{value: 'all', label: 'All'}];
                    data.forEach(function(dist) {
                        options.push({value: dist.id, label: dist.name});
                    });
                    districtChoices.clearChoices();
                    districtChoices.setChoices(options, 'value', 'label', true);
                    // After setting choices:
                    ensureOtherOption(districtChoices);
                });
        } else {
            districtChoices.clearChoices();
            districtChoices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
        }
    });
    districtSelect.addEventListener('change', function() {
        document.getElementById('new_district_input').style.display = (districtSelect.value === 'other') ? 'block' : 'none';
    });

    // Multiple document upload logic
    document.getElementById('add-document-btn').addEventListener('click', function() {
        const section = document.getElementById('document-upload-section');
        const row = document.createElement('div');
        row.className = 'row g-2 document-upload-row mb-2';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="document_names[]" class="form-control" placeholder="Document Name">
            </div>
            <div class="col-md-5">
                <input type="file" name="documents[]" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-document-btn"><i class="bi bi-x"></i></button>
            </div>
        `;
        section.appendChild(row);
        row.querySelector('.remove-document-btn').addEventListener('click', function() {
            row.remove();
        });
        document.querySelectorAll('.remove-document-btn').forEach(function(btn, idx) {
            btn.style.display = idx === 0 ? 'none' : '';
        });
    });

    document.querySelectorAll('.remove-document-btn').forEach(function(btn, idx) {
        btn.style.display = idx === 0 ? 'none' : '';
        btn.addEventListener('click', function() {
            btn.closest('.document-upload-row').remove();
        });
    });
    // SweetAlert2 required fields validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        let missing = [];
        this.querySelectorAll('[required]').forEach(function(input) {
            if (!input.value || (input.type === 'select-one' && input.value === '')) {
                let label = input.closest('.form-group')?.querySelector('label')?.innerText
                    || input.closest('div')?.querySelector('label')?.innerText
                    || input.name;
                missing.push(label ? label.replace('*', '').trim() : input.name);
            }
        });
        if (missing.length > 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Missing Required Fields',
                html: 'Please fill the following required fields:<br><b>' + missing.join(', ') + '</b>',
            });
            return false;
        }
    });

    // Query For: Show input if "Other" selected, hide otherwise
    var queryTypeSelect = document.getElementById('query_type_select');
    var queryTypeOtherDiv = document.getElementById('query_type_other_div');
    var queryTypeOtherInput = document.getElementById('query_type_other_input');
    if(queryTypeSelect && queryTypeOtherDiv && queryTypeOtherInput) {
        queryTypeSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                queryTypeOtherDiv.style.display = 'block';
                queryTypeOtherInput.required = true;
            } else {
                queryTypeOtherDiv.style.display = 'none';
                queryTypeOtherInput.required = false;
                queryTypeOtherInput.value = '';
            }
        });
    }
});
</script>
@endsection
