<div class="container-fluid">
    <div class="mb-3">
        <strong style="font-size:1.2rem;color:#232946;">Ayushman Card Details</strong>
    </div>
    <div class="row g-3">
        @php
            $fields = [
                ['patient_name', 'Patient Name', $card->patient_name, true],
                ['gender', 'Gender', $card->gender, false],
                ['dob', 'DOB', $card->dob, false],
                ['guardian_name', 'Guardian Name', $card->guardian_name, false],
                ['mobile', 'Mobile', $card->mobile, true],
                ['problam', 'Problam', $card->problam, true],
                ['doctor', 'Doctor(s)', isset($doctorNames) ? implode(', ', $doctorNames) : '', true],
                ['hospital', 'Hospital(s)', isset($hospitalNames) ? implode(', ', $hospitalNames) : '', true],
                ['department', 'Department(s)', isset($departmentNames) ? implode(', ', $departmentNames) : '', false],
                ['state', 'State', isset($state) && $state ? $state->name : $card->state, false],
                ['city', 'City', isset($city) && $city ? $city->name : $card->city, false],
                ['district', 'District', isset($district) && $district ? $district->name : $card->district, false],
                ['village', 'Village', $card->village, false],
                ['block', 'Block', $card->block, false],
                ['pin_code', 'Pin Code', $card->pin_code, false],
                ['aadhaar_number', 'Aadhaar Number', $card->aadhaar_number, false],
                ['amount', 'Amount', $card->amount, true],
                ['paid_amount', 'Paid Amount', $card->paid_amount, true],
                ['left', 'Left', $card->amount - $card->paid_amount, false],
                ['payment_id', 'Payment ID', $card->payment_id, true],
                ['created_at', 'Created At', $card->created_at ? $card->created_at->format('Y-m-d H:i:s') : '', false],
            ];
        @endphp
        @foreach($fields as $i => [$field, $label, $value, $checked])
            <div class="col-md-4 viewmore-field d-flex align-items-center">
                <input type="checkbox" class="copy-field me-2" data-field="{{ $field }}" {{ $checked ? 'checked' : '' }}>
                <label class="copy-label mb-0">{{ $label }}:</label>
                <span class="copy-value ms-2">{{ $value }}</span>
            </div>
        @endforeach

        {{-- Show uploaded other documents --}}
        @if(isset($otherDocs) && count($otherDocs))
            <div class="col-12 mt-2">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-2 px-3">
                        <h6 class="fw-bold mb-2" style="color:#232946;">Other Uploaded Documents</h6>
                        <div class="row">
                            @foreach($otherDocs as $doc)
                                <div class="col-md-4 mb-2">
                                    <div class="border rounded p-2 bg-light d-flex flex-column h-100">
                                        <div>
                                            <strong>{{ $doc->name }}</strong>
                                        </div>
                                        <div class="mt-1 mb-1">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" style="word-break:break-all;">
                                                View / Download
                                            </a>
                                        </div>
                                        <div>
                                            <span class="text-muted small">{{ $doc->created_at ? $doc->created_at->format('Y-m-d') : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<style>
#ayushmanViewMoreModal .viewmore-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}
#ayushmanViewMoreModal .viewmore-field {
    background: #fff;
    border-radius: 0.7rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(34,43,69,0.05);
    padding: 0.8rem 1.1rem 0.8rem 1.1rem;
    margin-bottom: 0;
    min-width: 260px;
    flex: 1 1 30%;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}
@media (max-width: 991px) {
    #ayushmanViewMoreModal .viewmore-grid {
        flex-direction: column;
        gap: 10px;
    }
    #ayushmanViewMoreModal .viewmore-field {
        min-width: 0;
        width: 100%;
        flex: 1 1 100%;
    }
}
</style>
