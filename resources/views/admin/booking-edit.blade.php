@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-primary fw-bold">Edit Booking</h3>
                    <form method="POST" action="{{ route('admin.booking-update', $booking->id) }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Person Name</label>
                                <input type="text" name="person_name" class="form-control" value="{{ old('person_name', $booking->person_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $booking->phone) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Alternate Number</label>
                                <input type="text" name="alternate_number" class="form-control" value="{{ old('alternate_number', $booking->alternate_number) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob', $booking->dob) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Male" {{ old('gender', $booking->gender)=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ old('gender', $booking->gender)=='Female'?'selected':'' }}>Female</option>
                                    <option value="Other" {{ old('gender', $booking->gender)=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">State</label>
                                <select name="state_id" id="state_select" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $booking->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_state" id="new_state_input" class="form-control mt-2" placeholder="Enter new state name" value="{{ old('new_state', $booking->new_state) }}" style="display:{{ $booking->state_id=='other'?'block':'none' }};">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City</label>
                                <select name="city_id" id="city_select" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $booking->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_city" id="new_city_input" class="form-control mt-2" placeholder="Enter new city name" value="{{ old('new_city', $booking->new_city) }}" style="display:{{ $booking->city_id=='other'?'block':'none' }};">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">District</label>
                                <select name="district_id" id="district_select" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ $booking->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_district" id="new_district_input" class="form-control mt-2" placeholder="Enter new district name" value="{{ old('new_district', $booking->new_district) }}" style="display:{{ $booking->district_id=='other'?'block':'none' }};">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Hospital</label>
                                <select name="hospital_id" id="hospital_select" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}" {{ $booking->hospital_id == $hospital->id ? 'selected' : '' }}>{{ $hospital->hospital_name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_hospital" id="new_hospital_input" class="form-control mt-2" placeholder="Enter new hospital name" value="{{ old('new_hospital', $booking->new_hospital) }}" style="display:{{ $booking->hospital_id=='other'?'block':'none' }};">
                                <div id="hospital_type_section" style="display:none;" class="mt-2">
                                    <label class="form-label fw-semibold">Type</label>
                                    <select name="new_hospital_type" id="new_hospital_type" class="form-select">
                                        <option value="">Select Type</option>
                                        <option value="Hospital" {{ old('new_hospital_type', $booking->new_hospital_type)=='Hospital'?'selected':'' }}>Hospital</option>
                                        <option value="Clinic" {{ old('new_hospital_type', $booking->new_hospital_type)=='Clinic'?'selected':'' }}>Clinic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department</label>
                                <select name="department_id" id="department_select" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $booking->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_department" id="new_department_input" class="form-control mt-2" placeholder="Enter new department name" value="{{ old('new_department', $booking->new_department) }}" style="display:{{ $booking->department_id=='other'?'block':'none' }};">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Problem</label>
                                <input type="text" name="problem" class="form-control" value="{{ old('problem', $booking->problem) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Appointment Date</label>
                                <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date', $booking->appointment_date) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Appointment Time</label>
                                <input type="time" name="appointment" class="form-control" value="{{ old('appointment', $booking->appointment) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Amount</label>
                                <input type="number" name="amount" class="form-control" min="0" step="0.01" value="{{ old('amount', $booking->amount) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Paid Amount</label>
                                <input type="number" name="paid_amount" class="form-control" min="0" step="0.01" value="{{ old('paid_amount', $booking->paid_amount) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Payment ID / Reference</label>
                                <input type="text" name="payment_id" class="form-control" value="{{ old('payment_id', $booking->payment_id) }}">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success px-4">Update Booking</button>
                            <a href="{{ route('admin.booking-list') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
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
    .card {
        border-radius: 1.1rem;
        box-shadow: 0 2px 16px rgba(34,43,69,0.07);
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Choices.js for dynamic search/select
    function setupChoices(id, url, newInputId) {
        const select = document.getElementById(id);
        if (!select) return;
        let choices = new Choices(select, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Type at least 3 characters to search',
            searchPlaceholderValue: 'Type at least 3 characters to search',
            shouldSort: false,
            removeItemButton: false,
            searchResultLimit: 10,
            noResultsText: 'No results found',
            itemSelectText: '',
            duplicateItemsAllowed: false,
            renderChoiceLimit: 10,
            searchFields: ['label', 'value'],
            callbackOnCreateTemplates: function(template) { return template; }
        });
        select.addEventListener('search', function(e) {
            const searchValue = e.detail.value;
            if (searchValue.length >= 3) {
                fetch(url + '?term=' + encodeURIComponent(searchValue))
                    .then(response => response.json())
                    .then(data => {
                        let options = [{value: 'all', label: 'All'}];
                        if (Array.isArray(data.results)) {
                            options = options.concat(data.results.map(item => ({
                                value: item.id,
                                label: item.text,
                                customProperties: {}
                            })));
                        } else if (Array.isArray(data)) {
                            options = options.concat(data.map(item => ({
                                value: item.id,
                                label: item.name,
                                customProperties: {}
                            })));
                        }
                        options.push({value: 'other', label: 'Other', customProperties: {}});
                        choices.setChoices(options, 'value', 'label', true);
                    });
            } else {
                choices.clearChoices();
                choices.setChoices([{value: 'all', label: 'All'}], 'value', 'label', true);
            }
        });
        select.addEventListener('change', function() {
            const newInput = document.getElementById(newInputId);
            if (select.value === 'other') {
                if (newInput) newInput.style.display = 'block';
            } else {
                if (newInput) newInput.style.display = 'none';
            }
        });
    }
    setupChoices('state_select', '{{ url("/admin/ajax/states") }}', 'new_state_input');
    setupChoices('city_select', '{{ url("/admin/ajax/cities") }}', 'new_city_input');
    setupChoices('district_select', '{{ url("/admin/ajax/districts") }}', 'new_district_input');
    setupChoices('hospital_select', '{{ route('admin.ajax.hospital-search') }}', 'new_hospital_input');
    setupChoices('department_select', '{{ route('admin.ajax.department-search') }}', 'new_department_input');

    // Show/hide hospital type section
    const hospitalSelect = document.getElementById('hospital_select');
    const hospitalTypeSection = document.getElementById('hospital_type_section');
    if (hospitalSelect && hospitalTypeSection) {
        hospitalSelect.addEventListener('change', function() {
            if (hospitalSelect.value === 'other') {
                hospitalTypeSection.style.display = 'block';
            } else {
                hospitalTypeSection.style.display = 'none';
            }
        });
        if (hospitalSelect.value === 'other') {
            hospitalTypeSection.style.display = 'block';
        }
    }
});
</script>
@endsection
