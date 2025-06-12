@extends('layouts.admin')

@section('title', 'Edit Ayushman Card Query')
@section('topbar-title', 'Edit Ayushman Card Query')

@section('content')
<div class="container-fluid p-0 m-0">
    <div class="row justify-content-center g-0 m-0">
        <div class="col-12 col-md-12 p-0 m-0">
            <div class="card shadow-sm border-0" style="border-radius:0;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4 text-center" style="color:#232946;">Edit Ayushman Card Query</h3>
                    <form id="ayushmanCardForm" method="POST" action="{{ route('admin.ayushman-card-query.update', $card->id) }}" enctype="multipart/form-data">
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
                                                    <input type="text" name="ref_person_name" class="form-control" placeholder="Enter reference person name" value="{{ old('ref_person_name', $card->ref_person_name) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ref Person Number</label>
                                                    <input type="text" name="ref_person_number" class="form-control" placeholder="Enter reference person number" value="{{ old('ref_person_number', $card->ref_person_number) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ref Person Address</label>
                                                    <input type="text" name="ref_person_address" class="form-control" placeholder="Enter reference person address" value="{{ old('ref_person_address', $card->ref_person_address) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Referral System</label>
                                                    <select name="referral_system" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="Doctor" {{ old('referral_system', $card->referral_system) == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                                        <option value="Agent" {{ old('referral_system', $card->referral_system) == 'Agent' ? 'selected' : '' }}>Agent</option>
                                                        <option value="Patient" {{ old('referral_system', $card->referral_system) == 'Patient' ? 'selected' : '' }}>Patient</option>
                                                        <option value="Other" {{ old('referral_system', $card->referral_system) == 'Other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Patient Information Section --}}
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" value="{{ old('mobile', $card->mobile) }}">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <div style="min-width:110px; margin-right:10px;">
                                                <label class="form-label">Title</label>
                                                <select name="title" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="Mr." {{ old('title', $card->title) == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                    <option value="Mrs." {{ old('title', $card->title) == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Miss" {{ old('title', $card->title) == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                </select>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Patient Name</label>
                                                <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name" value="{{ old('patient_name', $card->patient_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Gurdian Name</label>
                                            <input type="text" name="guardian_name" class="form-control" placeholder="Enter guardian name" value="{{ old('guardian_name', $card->guardian_name) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">DOB</label>
                                            <input type="date" name="dob" class="form-control" placeholder="Enter date of birth" value="{{ old('dob', $card->dob) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-select">
                                                <option value="">Select gender</option>
                                                <option value="Male" {{ old('gender', $card->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $card->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $card->gender) == 'Other' ? 'selected' : '' }}>Other</option>
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
                                            <input type="text" name="problam" class="form-control" placeholder="Enter problam" value="{{ old('problam', $card->problam) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Doctor Name</label>
                                            <select name="doctor_name[]" class="form-select" multiple id="doctorSelect" onchange="handleOtherInput(this, 'doctorOtherInput')">
                                                @foreach($doctorOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ in_array($id, old('doctor_name', $selectedDoctorIds ?? [])) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                                <option value="Other" {{ (collect(old('doctor_name', []))->contains('Other')) ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <input type="text" name="doctor_other" id="doctorOtherInput" class="form-control mt-2" placeholder="Please specify other doctor" style="display:none;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hospital/Clinic Name</label>
                                            <select name="hospital_name[]" class="form-select" multiple id="hospitalSelect" onchange="handleOtherInput(this, 'hospitalOtherInput')">
                                                @foreach($hospitalOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ in_array($id, old('hospital_name', $selectedHospitalIds ?? [])) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                                <option value="Other" {{ (collect(old('hospital_name', []))->contains('Other')) ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <input type="text" name="hospital_other" id="hospitalOtherInput" class="form-control mt-2" placeholder="Please specify other hospital/clinic" style="display:none;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Department</label>
                                            <select name="department[]" class="form-select" multiple id="departmentSelect" onchange="handleOtherInput(this, 'departmentOtherInput')">
                                                @foreach($departmentOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ in_array($id, old('department', $selectedDepartmentIds ?? [])) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                                <option value="Other" {{ (collect(old('department', []))->contains('Other')) ? 'selected' : '' }}>Other</option>
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
                                            <select name="state" class="form-select" id="stateSelect">
                                                @foreach($stateOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ old('state', $selectedStateId ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">City</label>
                                            <select name="city" class="form-select" id="citySelect">
                                                @foreach($cityOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ old('city', $selectedCityId ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">District</label>
                                            <select name="district" class="form-select" id="districtSelect">
                                                @foreach($districtOptions as $id => $name)
                                                    <option value="{{ $id }}" {{ old('district', $selectedDistrictId ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Village</label>
                                            <input type="text" name="village" class="form-control" placeholder="Enter village" value="{{ old('village', $card->village) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Block</label>
                                            <input type="text" name="block" class="form-control" placeholder="Enter block" value="{{ old('block', $card->block) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Pin Code</label>
                                            <input type="text" name="pin_code" class="form-control" placeholder="Enter pin code" value="{{ old('pin_code', $card->pin_code) }}">
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
                                            <input type="text" name="aadhaar_number" class="form-control" placeholder="Enter Aadhaar number" value="{{ old('aadhaar_number', $card->aadhaar_number) }}">
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
                                            @if($card->ayushman_upload)
                                                <a href="{{ asset('storage/' . $card->ayushman_upload) }}" target="_blank" class="btn btn-link btn-sm mt-1">View Current</a>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div id="otherDocumentsWrapper" class="mt-2">
                                                @if(isset($otherDocuments) && count($otherDocuments))
                                                    <div class="table-responsive mb-3">
                                                        <table class="table table-bordered table-sm align-middle">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Document Name</th>
                                                                    <th>File</th>
                                                                    <th>Uploaded At</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($otherDocuments as $doc)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" name="other_document_names[]" class="form-control" value="{{ $doc->name }}" placeholder="Document name">
                                                                            <input type="hidden" name="existing_document_ids[]" value="{{ $doc->id }}">
                                                                        </td>
                                                                        <td>
                                                                            @if(!empty($doc->file_path))
                                                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-link btn-sm">View</a>
                                                                            @endif
                                                                            <input type="file" name="other_documents[]" class="form-control mt-1">
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-muted small">{{ $doc->created_at ? $doc->created_at->format('Y-m-d') : '' }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-danger btn-sm remove-document-btn">
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                                {{-- Add new document row --}}
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
                                            <input type="number" name="amount" id="amountInput" class="form-control" placeholder="Enter full payment amount" oninput="updateLeftPayment()" value="{{ old('amount', $card->amount) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Paid Now</label>
                                            <input type="number" name="paid_amount" id="paidAmountInput" class="form-control" placeholder="Enter amount paid now" oninput="updateLeftPayment()" value="{{ old('paid_amount', $card->paid_amount) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Left Payment</label>
                                            <input type="number" id="leftPaymentInput" class="form-control" placeholder="Left payment" readonly value="{{ max(0, ($card->amount ?? 0) - ($card->paid_amount ?? 0)) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Payment Transaction ID</label>
                                            <input type="text" name="payment_id" class="form-control" placeholder="Enter payment transaction ID" value="{{ old('payment_id', $card->payment_id) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary px-5 py-2" onclick="showStep(4)">Previous</button>
                                    <button type="submit" class="btn btn-primary px-5 py-2">Update Query</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Correct CSS/JS includes for Choices.js --}}
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

// Step navigation logic
function showStep(step) {
    document.querySelectorAll('.step-section').forEach(function(section, idx) {
        section.classList.toggle('active', idx === (step - 1));
    });
    document.querySelectorAll('.step-indicator .step').forEach(function(stepEl, idx) {
        stepEl.classList.toggle('active', idx === (step - 1));
    });
}

$(document).ready(function () {
    // --- FIX: Prevent double-initialization of Choices.js for all selects ---

    // Store Choices instances globally
    window._choicesInstances = {};

    function destroyChoicesInstance(selectId) {
        if (window._choicesInstances && window._choicesInstances[selectId]) {
            window._choicesInstances[selectId].destroy();
            window._choicesInstances[selectId] = null;
        }
    }

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
                        choicesInstance.clearChoices();
                        choicesInstance.setChoices(response, 'id', 'name', true);
                    }
                });
            }
        });

        return choicesInstance;
    }

    function setupAjaxChoicesSingle(selectId, url, selectedId, selectedName, extraDataFn) {
        destroyChoicesInstance(selectId);
        var select = document.getElementById(selectId);
        var choicesInstance = new Choices(select, {
            searchEnabled: true,
            shouldSort: false,
            removeItemButton: false,
            placeholder: true,
            placeholderValue: 'Select ' + selectId.replace('Select', '').replace(/([A-Z])/g, ' $1').toLowerCase(),
            duplicateItemsAllowed: false,
            addItems: false,
            maxItemCount: 1,
            renderChoiceLimit: 10,
        });
        window._choicesInstances[selectId] = choicesInstance;

        choicesInstance.clearChoices();
        if (selectedId && selectedName) {
            choicesInstance.setChoices([{value: selectedId, label: selectedName, selected: true}], 'value', 'label', false);
        }

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
                        var choices = [];
                        if (selectedId && selectedName) {
                            choices.push({value: selectedId, label: selectedName, selected: true});
                        }
                        response.forEach(function(item) {
                            if (!selectedId || item.id != selectedId) {
                                choices.push({value: item.id, label: item.name});
                            }
                        });
                        choicesInstance.clearChoices();
                        choicesInstance.setChoices(choices, 'value', 'label', false);
                    }
                });
            }
        });

        return choicesInstance;
    }

    // Always destroy before re-initializing
    destroyChoicesInstance('doctorSelect');
    destroyChoicesInstance('hospitalSelect');
    destroyChoicesInstance('departmentSelect');
    destroyChoicesInstance('stateSelect');
    destroyChoicesInstance('citySelect');
    destroyChoicesInstance('districtSelect');

    window.doctorChoices = setupAjaxChoices('doctorSelect', '/admin/ajax/doctors', null, true);
    window.hospitalChoices = setupAjaxChoices('hospitalSelect', '/admin/ajax/hospitals', null, true);
    window.departmentChoices = setupAjaxChoices('departmentSelect', '/admin/ajax/departments', null, true);

    setupAjaxChoicesSingle('stateSelect', '/admin/ajax/states', @json($madisonQuary->state_id ?? ''), @json($stateName ?? ''));
    setupAjaxChoicesSingle('citySelect', '/admin/ajax/cities', @json($madisonQuary->city_id ?? ''), @json($cityName ?? ''), function() {
        return { state_id: $('#stateSelect').val() };
    });
    setupAjaxChoicesSingle('districtSelect', '/admin/ajax/districts', @json($madisonQuary->district_id ?? ''), @json($districtName ?? ''), function() {
        return { state_id: $('#stateSelect').val(), city_id: $('#citySelect').val() };
    });

    // Attach change event for all selects needing "Other" input
    $('#doctorSelect').on('change', function() {
        handleOtherInput(this, 'doctorOtherInput');
    });
    $('#hospitalSelect').on('change', function() {
        handleOtherInput(this, 'hospitalOtherInput');
    });
    $('#departmentSelect').on('change', function() {
        handleOtherInput(this, 'departmentOtherInput');
    });
    $('#stateSelect').on('change', function() {
        handleOtherInput(this, 'stateOtherInput');
    });
    $('#citySelect').on('change', function() {
        handleOtherInput(this, 'cityOtherInput');
    });
    $('#districtSelect').on('change', function() {
        handleOtherInput(this, 'districtOtherInput');
    });

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
        var row = $(this).closest('.other-document-row');
        // Remove the hidden input so the doc ID is not sent, and remove the row
        row.find('input[name="existing_document_ids[]"]').remove();
        row.remove();
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        var rows = $('#otherDocumentsWrapper .other-document-row');
        rows.find('.remove-document-btn').toggle(rows.length > 1);
    }
    updateRemoveButtons();

    $('#madisonQuaryForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        // For Choices.js multi-selects, append selected values manually if needed
        // Example for doctor_name[]
        var doctorSelect = document.getElementById('doctorSelect');
        if (doctorSelect) {
            var selectedDoctors = Array.from(doctorSelect.selectedOptions).map(opt => opt.value);
            formData.delete('doctor_name[]');
            selectedDoctors.forEach(val => formData.append('doctor_name[]', val));
        }
        // Repeat for other multi-selects if needed...

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                alert('Form submitted! Check console for data.');
                console.log(resp);
            },
            error: function(xhr) {
                alert('Error submitting form');
                console.log(xhr.responseText);
            }
        });
    });
});

function handleOtherInput(select, inputId) {
    var choices = Array.isArray(select.selectedOptions)
        ? Array.from(select.selectedOptions).map(opt => opt.value)
        : [select.value];
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
