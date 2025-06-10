@extends('layouts.admin')

@section('title', 'Add Ayushman Card Query')
@section('topbar-title', 'Add Ayushman Card Query')

@section('content')
<div class="container-fluid p-0 m-0">
    <div class="row justify-content-center g-0 m-0">
         <div class="col-12 col-md-12 p-0 m-0">
            <div class="card shadow-sm border-0" style="border-radius:0;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4 text-center" style="color:#232946;">Add Ayushman Card Query</h3>
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <style>
                                .form-control, .form-select {
                                    border-radius: 0 !important;
                                }
                            </style>
                        
                            <div class="col-md-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div style="min-width:110px; margin-right:10px;">
                                    <label class="form-label">Title</label>
                                    <select name="title" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Miss">Miss</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label">Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gurdian Name</label>
                                <input type="text" name="guardian_name" class="form-control" placeholder="Enter guardian name">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" placeholder="Enter date of birth">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <select name="state" class="form-select" id="stateSelect">
                                    <option value="">Select state</option>
                                    {{-- Options will be loaded dynamically --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <select name="city" class="form-select" id="citySelect">
                                    <option value="">Select city</option>
                                    {{-- Options will be loaded dynamically --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">District</label>
                                <select name="district" class="form-select" id="districtSelect">
                                    <option value="">Select district</option>
                                    {{-- Options will be loaded dynamically --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Problam</label>
                                <input type="text" name="problam" class="form-control" placeholder="Enter problam">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Aadhaar Number</label>
                                <input type="text" name="aadhaar_number" class="form-control" placeholder="Enter Aadhaar number">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ayushman Number</label>
                                <input type="text" name="ayushman_number" class="form-control" placeholder="Enter Ayushman number">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Other Document</label>
                                <input type="file" name="other_document_upload" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ayushman Document Upload</label>
                                <input type="file" name="ayushman_upload" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Doctor Name</label>
                                <select name="doctor_name[]" class="form-select" multiple id="doctorSelect" onchange="handleOtherInput(this, 'doctorOtherInput')">
                                    <option value="Dr. Smith">Dr. Smith</option>
                                    <option value="Dr. Patel">Dr. Patel</option>
                                    <option value="Dr. Gupta">Dr. Gupta</option>
                                    <option value="Dr. Sharma">Dr. Sharma</option>
                                    <option value="Dr. Khan">Dr. Khan</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" name="doctor_other" id="doctorOtherInput" class="form-control mt-2" placeholder="Please specify other doctor" style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Hospital/Clinic Name</label>
                                <select name="hospital_name[]" class="form-select" multiple id="hospitalSelect" onchange="handleOtherInput(this, 'hospitalOtherInput')">
                                    <option value="City Hospital">City Hospital</option>
                                    <option value="Care Clinic">Care Clinic</option>
                                    <option value="Health Center">Health Center</option>
                                    <option value="Wellness Clinic">Wellness Clinic</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" name="hospital_other" id="hospitalOtherInput" class="form-control mt-2" placeholder="Please specify other hospital/clinic" style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Department</label>
                                <select name="department[]" class="form-select" multiple id="departmentSelect" onchange="handleOtherInput(this, 'departmentOtherInput')">
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Neurology">Neurology</option>
                                    <option value="Orthopedics">Orthopedics</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" name="department_other" id="departmentOtherInput" class="form-control mt-2" placeholder="Please specify other department" style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Full Payment</label>
                                <input type="number" name="amount" id="amountInput" class="form-control" placeholder="Enter full payment amount" oninput="updateLeftPayment()">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Paid Now</label>
                                <input type="number" name="paid_amount" id="paidAmountInput" class="form-control" placeholder="Enter amount paid now" oninput="updateLeftPayment()">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Left Payment</label>
                                <input type="number" id="leftPaymentInput" class="form-control" placeholder="Left payment" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payment Transaction ID</label>
                                <input type="text" name="payment_id" class="form-control" placeholder="Enter payment transaction ID">
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                Add Query
                            </button>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Choices.js CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
function updateLeftPayment() {
    var amount = parseFloat(document.getElementById('amountInput').value) || 0;
    var paid = parseFloat(document.getElementById('paidAmountInput').value) || 0;
    var left = amount - paid;
    document.getElementById('leftPaymentInput').value = left > 0 ? left : 0;
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.doctorChoices) window.doctorChoices.destroy();
    if (window.hospitalChoices) window.hospitalChoices.destroy();
    if (window.departmentChoices) window.departmentChoices.destroy();
    if (window.stateChoices) window.stateChoices.destroy();
    if (window.cityChoices) window.cityChoices.destroy();
    if (window.districtChoices) window.districtChoices.destroy();

    window.doctorChoices = new Choices(document.getElementById('doctorSelect'), {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select doctor(s)'
    });
    window.hospitalChoices = new Choices(document.getElementById('hospitalSelect'), {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select hospital/clinic(s)'
    });
    window.departmentChoices = new Choices(document.getElementById('departmentSelect'), {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select department(s)'
    });
    window.stateChoices = new Choices(document.getElementById('stateSelect'), {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select state',
        shouldSort: false,
        searchResultLimit: 10,
        renderChoiceLimit: 10,
        duplicateItemsAllowed: false,
        removeItemButton: false,
        addItems: false,
        callbackOnCreateTemplates: null
    });
    window.cityChoices = new Choices(document.getElementById('citySelect'), {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select city',
        shouldSort: false,
        searchResultLimit: 10,
        renderChoiceLimit: 10,
        duplicateItemsAllowed: false,
        removeItemButton: false,
        addItems: false,
        callbackOnCreateTemplates: null
    });
    window.districtChoices = new Choices(document.getElementById('districtSelect'), {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: 'Select district',
        shouldSort: false,
        searchResultLimit: 10,
        renderChoiceLimit: 10,
        duplicateItemsAllowed: false,
        removeItemButton: false,
        addItems: false,
        callbackOnCreateTemplates: null
    });

    // Helper to simulate AJAX fetch (replace with real AJAX in production)
    function fetchOptions(type, search, callback) {
        // Simulated data for demo
        const data = {
            state: ['Uttar Pradesh', 'Madhya Pradesh', 'Delhi', 'Bihar', 'Maharashtra', 'Punjab', 'Rajasthan', 'Gujarat'],
            city: ['Lucknow', 'Kanpur', 'Delhi', 'Patna', 'Mumbai', 'Indore', 'Jaipur', 'Ahmedabad'],
            district: ['Lucknow', 'Kanpur Nagar', 'Patna', 'Mumbai City', 'Bhopal', 'Jaipur', 'Ahmedabad']
        };
        const filtered = data[type].filter(item => item.toLowerCase().includes(search.toLowerCase()));
        callback(filtered.map(val => ({ value: val, label: val })));
    }

    function setupDynamicChoices(choicesInstance, type) {
        const input = choicesInstance.input.element;
        input.addEventListener('input', function () {
            const val = input.value;
            if (val.length >= 3) {
                fetchOptions(type, val, function(options) {
                    choicesInstance.clearChoices();
                    choicesInstance.setChoices(options, 'value', 'label', true);
                });
            } else {
                choicesInstance.clearChoices();
            }
        });
    }

    setupDynamicChoices(window.stateChoices, 'state');
    setupDynamicChoices(window.cityChoices, 'city');
    setupDynamicChoices(window.districtChoices, 'district');

    document.getElementById('doctorSelect').addEventListener('change', function() {
        handleOtherInput(this, 'doctorOtherInput');
    });
    document.getElementById('hospitalSelect').addEventListener('change', function() {
        handleOtherInput(this, 'hospitalOtherInput');
    });
    document.getElementById('departmentSelect').addEventListener('change', function() {
        handleOtherInput(this, 'departmentOtherInput');
    });
});

function handleOtherInput(select, inputId) {
    var choices = Array.from(select.selectedOptions).map(opt => opt.value);
    var otherInput = document.getElementById(inputId);
    if (choices.includes('Other')) {
        otherInput.style.display = '';
    } else {
        otherInput.style.display = 'none';
        otherInput.value = '';
    }
}
</script>
@endsection
