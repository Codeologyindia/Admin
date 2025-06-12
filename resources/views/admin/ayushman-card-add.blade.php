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
                    <form id="ayushmanCardForm" method="POST" action="{{ route('admin.ayushman-card-query.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <style>
                                .form-control, .form-select {
                                    border-radius: 0.4rem !important;
                                    font-size: 0.97rem;
                                }
                                .step-section {
                                    display: none;
                                }
                                .step-section.active {
                                    display: block;
                                }
                                .step-indicator {
                                    display: flex;
                                    gap: 10px;
                                    margin-bottom: 1.2rem;
                                }
                                .step-indicator .step {
                                    flex: 1;
                                    padding: 0.7rem 0;
                                    text-align: center;
                                    border-radius: 0.5rem;
                                    background: #f4f6fa;
                                    color: #232946;
                                    font-weight: 700;
                                    border: 2px solid #d1d5db;
                                    font-size: 1.01rem;
                                    letter-spacing: 0.5px;
                                }
                                .step-indicator .step.active {
                                    background: #232946;
                                    color: #fff;
                                    border-color: #232946;
                                }
                                .card-section {
                                    background: #fff;
                                    border-radius: 0.7rem;
                                    box-shadow: 0 2px 8px rgba(34,43,69,0.07);
                                    padding: 1.2rem 1.5rem 1.2rem 1.5rem;
                                    margin-bottom: 1.2rem;
                                }
                                .form-label {
                                    font-weight: 600;
                                    color: #232946;
                                }
                                .btn-primary, .btn-primary:focus {
                                    background: #232946;
                                    border-color: #232946;
                                }
                                .btn-primary:hover {
                                    background: #3b82f6;
                                    border-color: #3b82f6;
                                }
                                .btn-secondary {
                                    background: #b0b8d1;
                                    border-color: #b0b8d1;
                                    color: #232946;
                                }
                                .btn-secondary:hover {
                                    background: #232946;
                                    color: #fff;
                                }
                            </style>
                            {{-- Step Indicator --}}
                            <div class="col-12">
                                <div class="step-indicator">
                                    <div class="step step-1 active">1. Reference & Patient</div>
                                    <div class="step step-2">2. Medical</div>
                                    <div class="step step-3">3. Location</div>
                                    <div class="step step-4">4. Documentation</div>
                                    <div class="step step-5">5. Payment</div>
                                </div>
                            </div>
                            {{-- Step 1: Reference & Patient --}}
                            <div class="step-section step-section-1 active">
                                <div class="card-section mb-3">
                                    {{-- Reference Person Section --}}
                                    <div class="card border-0 shadow-sm mb-3 ref-person-section" style="background: #e9f5ff; border: 1px solid #b6e0fe; border-radius: 0.5rem;">
                                        <div class="card-body py-3 px-4">
                                            <h6 class="fw-bold mb-3" style="color:#232946;">Reference Person Details</h6>
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">Ref Person Name</label>
                                                    <input type="text" name="ref_person_name" class="form-control" placeholder="Enter reference person name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ref Person Number</label>
                                                    <input type="text" name="ref_person_number" class="form-control" placeholder="Enter reference person number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ref Person Address</label>
                                                    <input type="text" name="ref_person_address" class="form-control" placeholder="Enter reference person address">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Referral System</label>
                                                    <select name="referral_system" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="Doctor">Doctor</option>
                                                        <option value="Agent">Agent</option>
                                                        <option value="Patient">Patient</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Patient Info --}}
                                    <div class="row g-3 align-items-end">
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
                                    </div>
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="button" class="btn btn-primary px-5 py-2" onclick="showStep(2)">Next</button>
                                </div>
                            </div>
                            {{-- Step 2: Medical --}}
                            <div class="step-section step-section-2">
                                <div class="card-section mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">Problam</label>
                                            <input type="text" name="problam" class="form-control" placeholder="Enter problam">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Doctor Name</label>
                                            <select name="doctor_name[]" class="form-select" multiple id="doctorSelect" onchange="handleOtherInput(this, 'doctorOtherInput')">
                                                {{-- Options will be loaded dynamically via AJAX --}}
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" name="doctor_other" id="doctorOtherInput" class="form-control mt-2" placeholder="Please specify other doctor" style="display:none;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hospital/Clinic Name</label>
                                            <select name="hospital_name[]" class="form-select" multiple id="hospitalSelect" onchange="handleOtherInput(this, 'hospitalOtherInput')">
                                                {{-- Options will be loaded dynamically via AJAX --}}
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" name="hospital_other" id="hospitalOtherInput" class="form-control mt-2" placeholder="Please specify other hospital/clinic" style="display:none;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Department</label>
                                            <select name="department[]" class="form-select" multiple id="departmentSelect" onchange="handleOtherInput(this, 'departmentOtherInput')">
                                                {{-- Options will be loaded dynamically via AJAX --}}
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" name="department_other" id="departmentOtherInput" class="form-control mt-2" placeholder="Please specify other department" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary px-5 py-2" onclick="showStep(1)">Previous</button>
                                    <button type="button" class="btn btn-primary px-5 py-2" onclick="showStep(3)">Next</button>
                                </div>
                            </div>
                            {{-- Step 3: Location --}}
                            <div class="step-section step-section-3">
                                <div class="card-section mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">State</label>
                                            <select name="state" class="form-select" id="stateSelect"></select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">City</label>
                                            <select name="city" class="form-select" id="citySelect"></select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">District</label>
                                            <select name="district" class="form-select" id="districtSelect"></select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Village</label>
                                            <input type="text" name="village" class="form-control" placeholder="Enter village">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Block</label>
                                            <input type="text" name="block" class="form-control" placeholder="Enter block">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Pin Code</label>
                                            <input type="text" name="pin_code" class="form-control" placeholder="Enter pin code">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary px-5 py-2" onclick="showStep(2)">Previous</button>
                                    <button type="button" class="btn btn-primary px-5 py-2" onclick="showStep(4)">Next</button>
                                </div>
                            </div>
                            {{-- Step 4: Documentation --}}
                            <div class="step-section step-section-4">
                                <div class="card-section mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label">Aadhaar Number</label>
                                            <input type="text" name="aadhaar_number" class="form-control" placeholder="Enter Aadhaar number">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Other Documents</label>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-normal text-secondary">Add supporting documents (if any):</span>
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="addDocumentBtn">
                                                    <i class="bi bi-plus-circle"></i> Add Document
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Ayushman Document Upload</label>
                                            <input type="file" name="ayushman_upload" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <div id="otherDocumentsWrapper" class="mt-2">
                                                <div class="other-document-row p-3 mb-2 border rounded bg-light position-relative">
                                                    <div class="row g-2">
                                                        <div class="col-md-6">
                                                            <input type="text" name="other_document_names[]" class="form-control" placeholder="Document name">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="file" name="other_documents[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-center justify-content-end">
                                                            <button type="button" class="btn btn-danger btn-sm remove-document-btn" style="display:none;">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary px-5 py-2" onclick="showStep(3)">Previous</button>
                                    <button type="button" class="btn btn-primary px-5 py-2" onclick="showStep(5)">Next</button>
                                </div>
                            </div>
                            {{-- Step 5: Payment --}}
                            <div class="step-section step-section-5">
                                <div class="card-section mb-3">
                                    <div class="row g-3 align-items-end">
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
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary px-5 py-2" onclick="showStep(4)">Previous</button>
                                    <button type="submit" class="btn btn-primary px-5 py-2">Add Query</button>
                                </div>
                            </div>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function updateLeftPayment() {
    var amount = parseFloat(document.getElementById('amountInput').value) || 0;
    var paid = parseFloat(document.getElementById('paidAmountInput').value) || 0;
    var left = amount - paid;
    document.getElementById('leftPaymentInput').value = left > 0 ? left : 0;
}

function destroyChoicesInstance(selectId) {
    if (window._choicesInstances && window._choicesInstances[selectId]) {
        window._choicesInstances[selectId].destroy();
        window._choicesInstances[selectId] = null;
    }
}

$(document).ready(function () {
    // Store Choices instances globally
    window._choicesInstances = window._choicesInstances || {};

    // Always destroy before re-initializing
    destroyChoicesInstance('doctorSelect');
    destroyChoicesInstance('hospitalSelect');
    destroyChoicesInstance('departmentSelect');
    destroyChoicesInstance('stateSelect');
    destroyChoicesInstance('citySelect');
    destroyChoicesInstance('districtSelect');

    function setupAjaxChoices(selectId, url, extraDataFn, isMultiple = false) {
        destroyChoicesInstance(selectId);
        var select = document.getElementById(selectId);
        var choicesInstance = new Choices(select, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select ' + selectId.replace('Select', '').replace(/([A-Z])/g, ' $1').toLowerCase(),
            shouldSort: false,
            searchResultLimit: 10,
            renderChoiceLimit: 10,
            duplicateItemsAllowed: false,
            removeItemButton: isMultiple,
            addItems: false,
            maxItemCount: isMultiple ? -1 : 1
        });
        window._choicesInstances[selectId] = choicesInstance;

        select.addEventListener('search', function(e) {
            var value = e.detail.value;
            if (value.length >= 3) {
                var data = { q: value };
                if (typeof extraDataFn === 'function') {
                    Object.assign(data, extraDataFn());
                }
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        // Always keep "Other" at the end for multi-selects
                        var options = response.map(function(item) {
                            return { value: item.id, label: item.name };
                        });
                        if (isMultiple) {
                            options.push({ value: "Other", label: "Other" });
                        }
                        choicesInstance.clearChoices();
                        choicesInstance.setChoices(options, 'value', 'label', true);
                    }
                });
            }
        });

        return choicesInstance;
    }

    window.doctorChoices = setupAjaxChoices('doctorSelect', '/admin/ajax/doctors', null, true);
    window.hospitalChoices = setupAjaxChoices('hospitalSelect', '/admin/ajax/hospitals', null, true);
    window.departmentChoices = setupAjaxChoices('departmentSelect', '/admin/ajax/departments', null, true);

    window.stateChoices = setupAjaxChoices('stateSelect', '/admin/ajax/states');
    window.cityChoices = setupAjaxChoices('citySelect', '/admin/ajax/cities', function() {
        return { state_id: $('#stateSelect').val() };
    });
    window.districtChoices = setupAjaxChoices('districtSelect', '/admin/ajax/districts', function() {
        return { state_id: $('#stateSelect').val(), city_id: $('#citySelect').val() };
    });

    // Attach change event for all selects needing "Other" input
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

function showStep(step) {
    document.querySelectorAll('.step-section').forEach(function(section, idx) {
        section.classList.toggle('active', idx === (step - 1));
    });
    document.querySelectorAll('.step-indicator .step').forEach(function(stepEl, idx) {
        stepEl.classList.toggle('active', idx === (step - 1));
    });
}
</script>
<script>
$(document).ready(function () {
    // Add/Remove Other Document fields
    $('#addDocumentBtn').on('click', function() {
        var newRow = `<div class="other-document-row p-3 mb-2 border rounded bg-light position-relative">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="other_document_names[]" class="form-control" placeholder="Document name">
                </div>
                <div class="col-md-5">
                    <input type="file" name="other_documents[]" class="form-control">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-danger btn-sm remove-document-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
        $('#otherDocumentsWrapper').append(newRow);
        updateRemoveButtons();
    });

    // Remove document row
    $(document).on('click', '.remove-document-btn', function() {
        $(this).closest('.other-document-row').remove();
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        var rows = $('#otherDocumentsWrapper .other-document-row');
        rows.find('.remove-document-btn').toggle(rows.length > 1);
    }
    updateRemoveButtons();
});
</script>
@endsection
