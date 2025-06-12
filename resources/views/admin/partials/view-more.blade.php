<div class="container-fluid">
    <div class="row">
        @php
            $fields = [
                ['patient_name', 'Patient Name', $quary->patient_title ? $quary->patient_title . ' ' . $quary->patient_name : $quary->patient_name],
                ['gender', 'Gender', $quary->gender],
                ['dob', 'DOB', $quary->dob],
                ['guardian_name', 'Guardian Name', $quary->guardian_name],
                ['mobile', 'Mobile', $quary->mobile],
                ['alternate_number', 'Alternate Number', $quary->alternate_number],
                ['problam', 'Problam', $quary->problam],
                ['doctor', 'Doctor(s)', implode(', ', $doctorNames)],
                ['hospital', 'Hospital(s)', implode(', ', $hospitalNames)],
                ['department', 'Department(s)', implode(', ', $departmentNames)],
                ['state', 'State', $state ? $state->name : ''],
                ['city', 'City', $city ? $city->name : ''],
                ['district', 'District', $district ? $district->name : ''],
                ['village', 'Village', $quary->village],
                ['block', 'Block', $quary->block],
                ['pin_code', 'Pin Code', $quary->pin_code],
                ['aadhaar_number', 'Aadhaar Number', $quary->aadhaar_number],
                ['amount', 'Amount', $quary->amount],
                ['paid_amount', 'Paid Amount', $quary->paid_amount],
                ['payment_id', 'Payment ID', $quary->payment_id],
                ['created_at', 'Created At', $quary->created_at],
            ];
        @endphp
        @foreach($fields as $i => [$field, $label, $value])
            <div class="col-12 col-md-4 mb-2 viewmore-field">
                <div class="border rounded p-2 h-100 bg-white d-flex align-items-center gap-2">
                    <input type="checkbox" class="copy-field me-2" data-field="{{ $field }}">
                    <span class="copy-label">{{ $label }}:</span>
                    <span class="copy-value ms-1">{{ $value }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
