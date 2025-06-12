@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h3 class="mb-4 text-primary fw-bold">Booking Details</h3>
            <form id="copy-fields-form">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary btn-sm" id="copy_selected_fields_btn">
                        <i class="bi bi-clipboard"></i> Copy Selected Fields
                    </button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>
                            <input type="checkbox" class="copy-field-checkbox" value="ID">
                        </th>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="ID"></td>
                        <td>ID</td>
                        <td>{{ $booking->id }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Person Name"></td>
                        <td>Person Name</td>
                        <td>{{ $booking->person_name }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Phone"></td>
                        <td>Phone</td>
                        <td>{{ $booking->phone }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Gender"></td>
                        <td>Gender</td>
                        <td>{{ $booking->gender }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="State"></td>
                        <td>State</td>
                        <td>{{ $booking->state->name ?? $booking->new_state ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="City"></td>
                        <td>City</td>
                        <td>{{ $booking->city->name ?? $booking->new_city ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Hospital"></td>
                        <td>Hospital</td>
                        <td>{{ $booking->hospital->hospital_name ?? $booking->new_hospital ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Department"></td>
                        <td>Department</td>
                        <td>{{ $booking->department->name ?? $booking->new_department ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Problem"></td>
                        <td>Problem</td>
                        <td>{{ $booking->problem }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Appointment Date"></td>
                        <td>Appointment Date</td>
                        <td>{{ $booking->appointment_date }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Appointment Time"></td>
                        <td>Appointment Time</td>
                        <td>{{ $booking->appointment }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Amount"></td>
                        <td>Amount</td>
                        <td>{{ $booking->amount }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Left"></td>
                        <td>Left</td>
                        <td>{{ (float)($booking->amount ?? 0) - (float)($booking->paid_amount ?? 0) }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Payment ID"></td>
                        <td>Payment ID</td>
                        <td>{{ $booking->payment_id }}</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="copy-field-checkbox" value="Created At"></td>
                        <td>Created At</td>
                        <td>{{ $booking->created_at }}</td>
                    </tr>
                </table>
            </form>
            <a href="{{ route('admin.booking-list') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('copy_selected_fields_btn').addEventListener('click', function() {
        let rows = document.querySelectorAll('.copy-field-checkbox');
        let table = document.querySelector('.table.table-bordered');
        let selected = [];
        rows.forEach(function(cb, idx) {
            if (cb.checked) {
                // Get the value from the same row's 3rd cell (value)
                let tr = cb.closest('tr');
                if (tr && tr.children.length >= 3) {
                    let label = tr.children[1].innerText.trim();
                    let value = tr.children[2].innerText.trim();
                    selected.push(label + ': ' + value);
                }
            }
        });
        if (selected.length > 0) {
            navigator.clipboard.writeText(selected.join('\n'));
            this.innerHTML = '<i class="bi bi-clipboard-check"></i> Copied!';
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-clipboard"></i> Copy Selected Fields';
            }, 1200);
        } else {
            this.innerHTML = '<i class="bi bi-clipboard-x"></i> Select at least one';
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-clipboard"></i> Copy Selected Fields';
            }, 1200);
        }
    });
});
</script>
@endsection
