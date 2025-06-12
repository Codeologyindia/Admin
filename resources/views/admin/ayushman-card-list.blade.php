@extends('layouts.admin')

@section('title', 'Ayushman Card Query List')
@section('topbar-title', 'Ayushman Card Query List')

@section('content')
<div class="container-fluid">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4" style="border-radius:1rem;">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ayushman-card-query') }}" class="row g-3 align-items-end" id="ayushmanFilterForm">
                <div class="col-md-2">
                    <label class="form-label mb-1">Mobile Number</label>
                    <input type="text" name="mobile" value="{{ request('mobile') }}" class="form-control" placeholder="Enter mobile number" autocomplete="off">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Patient Name</label>
                    <input type="text" name="patient_name" value="{{ request('patient_name') }}" class="form-control" placeholder="Enter patient name">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Doctor</label>
                    <select name="doctor" class="form-select">
                        <option value="">All</option>
                        @foreach(\App\Models\Doctor::orderBy('name')->get() as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor')==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Hospital/Clinic</label>
                    <select name="hospital" class="form-select">
                        <option value="">All</option>
                        @foreach(\App\Models\Hospital::orderBy('hospital_name')->get() as $hospital)
                            <option value="{{ $hospital->id }}" {{ request('hospital')==$hospital->id ? 'selected' : '' }}>{{ $hospital->hospital_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                    <button type="button" class="btn btn-outline-secondary w-100" id="resetFilterBtn"><i class="bi bi-x-circle"></i> Reset</button>
                </div>
                <div class="col-12 text-end mt-2">
                    <a href="{{ route('admin.ayushman-card-query.add') }}" class="btn btn-success px-4 ms-2">
                        <i class="bi bi-plus-lg"></i> Add
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius:1rem;">
        <div class="card-body">
            <div class="table-responsive" style="zoom:90%;">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Mobile</th>
                            <th>Patient Name</th>
                            <th>Doctor(s)</th>
                            <th>Hospital(s)</th>
                            <th>Department(s)</th>
                            <th>State</th>
                            <th>City</th>
                            <th>District</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Left</th>
                            <th>Ayushman</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $card)
                        <tr>
                            <td>{{ $card->created_at ? $card->created_at->format('Y-m-d') : '' }}</td>
                            <td>{{ $card->mobile }}</td>
                            <td>{{ $card->patient_name }}</td>
                            <td>
                                @php
                                    $doctorNames = [];
                                    if ($card->doctor_names) {
                                        $ids = json_decode($card->doctor_names, true);
                                        $doctorNames = \App\Models\Doctor::whereIn('id', $ids)->pluck('name')->toArray();
                                        if (empty($doctorNames)) $doctorNames = $ids;
                                    }
                                @endphp
                                {{ implode(', ', $doctorNames) }}
                            </td>
                            <td>
                                @php
                                    $hospitalNames = [];
                                    if ($card->hospital_names) {
                                        $ids = json_decode($card->hospital_names, true);
                                        $hospitalNames = \App\Models\Hospital::whereIn('id', $ids)->pluck('hospital_name')->toArray();
                                        if (empty($hospitalNames)) $hospitalNames = $ids;
                                    }
                                @endphp
                                {{ implode(', ', $hospitalNames) }}
                            </td>
                            <td>
                                @php
                                    $departmentNames = [];
                                    if ($card->department_names) {
                                        $ids = json_decode($card->department_names, true);
                                        $departmentNames = \App\Models\Department::whereIn('id', $ids)->pluck('name')->toArray();
                                        if (empty($departmentNames)) $departmentNames = $ids;
                                    }
                                @endphp
                                {{ implode(', ', $departmentNames) }}
                            </td>
                            <td>
                                {{ isset($states[$card->state]) ? $states[$card->state] : $card->state }}
                            </td>
                            <td>
                                {{ isset($cities[$card->city]) ? $cities[$card->city] : $card->city }}
                            </td>
                            <td>
                                {{ isset($districts[$card->district]) ? $districts[$card->district] : $card->district }}
                            </td>
                            <td>{{ $card->amount }}</td>
                            <td>{{ $card->paid_amount }}</td>
                            <td>{{ $card->amount - $card->paid_amount }}</td>
                            <td>
                                @if($card->ayushman_upload)
                                    <a href="{{ asset('storage/' . $card->ayushman_upload) }}" target="_blank" class="btn btn-sm btn-info" title="View Ayushman Document">
                                        View
                                    </a>
                                @else
                                    <span class="text-muted">No File</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('admin.ayushman-card-query.edit', $card->id) }}" class="btn btn-sm btn-warning px-3" style="min-width:40px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success px-3" style="min-width:40px;" title="Payment" onclick="showPaymentModal({{ $card->id }}, {{ $card->paid_amount }}, {{ $card->amount - $card->paid_amount }})">
                                        <i class="bi bi-cash-coin"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info text-white px-3" style="min-width:40px;" title="Documents" onclick="showDocumentsModal({{ $card->id }})">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary px-3" style="min-width:40px;" title="View More" onclick="showAyushmanViewMoreModal({{ $card->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="text-center text-muted">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $cards->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('resetFilterBtn').onclick = function() {
    let form = document.getElementById('ayushmanFilterForm');
    form.querySelectorAll('input, select').forEach(function(el) {
        if (el.type === 'select-one' || el.type === 'text' || el.type === 'date') el.value = '';
    });
    form.submit();
};

function showPaymentModal(id, paid, left) {
    $('#paymentModalAyushman').modal('show');
    $('#paidAmountShowAyushman').text(paid);
    $('#leftAmountShowAyushman').text(left);
    $('#payAmountAyushman').val('');
    $('#transactionIdAyushman').val('');
    $('#paymentFormAyushman').attr('action', '/admin/ayushman-card-query/update/' + id);
    $('#ayushmanPaymentLogsArea').hide();
    $('#ayushmanPaymentLogsContent').html('');
    window.currentAyushmanCardId = id;
}

// Show payment logs in modal
function showAyushmanPaymentLogs() {
    if (!window.currentAyushmanCardId) return;
    $('#ayushmanPaymentLogsArea').show();
    $('#ayushmanPaymentLogsContent').html('<div class="text-muted">Loading...</div>');
    $.get('/admin/ayushman-card-query/payment-log/' + window.currentAyushmanCardId, function(html) {
        $('#ayushmanPaymentLogsContent').html(html);
        $('#ayushmanPaymentLogsArea')[0].scrollIntoView({behavior: "smooth"});
    });
}

$('#showAyushmanPaymentLogsBtn').on('click', showAyushmanPaymentLogs);

$('#paymentFormAyushman').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var payAmount = $('#payAmountAyushman').val();
    var transactionId = $('#transactionIdAyushman').val();
    var token = form.find('input[name="_token"]').val();

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            paid_amount: payAmount,
            payment_id: transactionId
        },
        success: function(resp) {
            location.reload();
        },
        error: function(xhr) {
            alert('Could not update payment.');
        }
    });
});

function showDocumentsModal(cardId) {
    $('#documentsModalAyushman').modal('show');
    $('#documentsModalAyushmanBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/ayushman-card-query/documents/' + cardId, function(html) {
        $('#documentsModalAyushmanBody').html(html);
    });
}

function copyAyushmanInfo(cardId) {
    $.get('/admin/ayushman-card-query/view/' + cardId + '?copy=1', function(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Copied!');
        });
    });
}

function showAyushmanViewMoreModal(id) {
    $('#ayushmanViewMoreModal').modal('show');
    $('#ayushmanViewMoreModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/ayushman-card-query/view/' + id + '?viewmore=1', function(html) {
        $('#ayushmanViewMoreModalBody').html(html);

        // By default, check basic fields for copy
        $('#ayushmanViewMoreModalBody input[type="checkbox"].copy-field').each(function() {
            var field = $(this).data('field');
            if (['patient_name','mobile','problam','doctor','hospital','amount','paid_amount','payment_id'].includes(field)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    });
}

function getSelectedAyushmanViewMoreText() {
    var lines = [];
    $('#ayushmanViewMoreModalBody input[type="checkbox"].copy-field:checked').each(function() {
        var label = $(this).closest('.viewmore-field').find('.copy-label').text().trim();
        var value = $(this).closest('.viewmore-field').find('.copy-value').text().trim();
        if (label && value) {
            lines.push(label + ' ' + value);
        }
    });
    return lines.join('\n');
}

$('#copyAyushmanViewMoreBtn').on('click', function() {
    var text = getSelectedAyushmanViewMoreText();
    if (!text) {
        Swal.fire({
            icon: 'warning',
            title: 'Nothing selected',
            text: 'Please select at least one field to copy.',
            timer: 1200,
            showConfirmButton: false
        });
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Selected details copied to clipboard.',
            timer: 1200,
            showConfirmButton: false
        });
    });
});

// WhatsApp share
$('#whatsappAyushmanViewMoreBtn').on('click', function() {
    var text = getSelectedAyushmanViewMoreText();
    if (!text) {
        Swal.fire({
            icon: 'warning',
            title: 'Nothing selected',
            text: 'Please select at least one field to share.',
            timer: 1200,
            showConfirmButton: false
        });
        return;
    }
    var url = 'https://wa.me/?text=' + encodeURIComponent(text);
    window.open(url, '_blank');
});
</script>

{{-- Payment Modal --}}
<div class="modal fade" id="paymentModalAyushman" tabindex="-1" aria-labelledby="paymentModalAyushmanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="paymentFormAyushman" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalAyushmanLabel">Payment Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <dl class="row mb-0">
            <dt class="col-sm-6">Paid</dt>
            <dd class="col-sm-6" id="paidAmountShowAyushman"></dd>
            <dt class="col-sm-6">Payment Left</dt>
            <dd class="col-sm-6" id="leftAmountShowAyushman"></dd>
          </dl>
          <div class="mb-3 row align-items-center mt-3">
            <label for="payAmountAyushman" class="col-sm-5 col-form-label">Add Payment Amount</label>
            <div class="col-sm-7">
              <input type="number" min="1" class="form-control" id="payAmountAyushman" name="payAmount" placeholder="Enter amount">
            </div>
          </div>
          <div class="mb-3 row align-items-center">
            <label for="transactionIdAyushman" class="col-sm-5 col-form-label">Transaction ID</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="transactionIdAyushman" name="transactionId" placeholder="Enter transaction id">
            </div>
          </div>
          <div class="mb-3 text-end">
            <button type="button" class="btn btn-outline-info btn-sm" id="showAyushmanPaymentLogsBtn">
              <i class="bi bi-clock-history"></i> Show Old Payments
            </button>
          </div>
          <div id="ayushmanPaymentLogsArea" style="display:none;">
            <div class="border rounded p-2 bg-light mb-2">
              <h6 class="mb-2 fw-bold text-primary"><i class="bi bi-clock-history"></i> Payment History</h6>
              <div id="ayushmanPaymentLogsContent" class="small"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Documents Modal --}}
<div class="modal fade" id="documentsModalAyushman" tabindex="-1" aria-labelledby="documentsModalAyushmanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentsModalAyushmanLabel">Uploaded Documents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="documentsModalAyushmanBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- View More Modal -->
<div class="modal fade" id="ayushmanViewMoreModal" tabindex="-1" aria-labelledby="ayushmanViewMoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 1.2rem; box-shadow: 0 4px 32px rgba(34,43,69,0.13);">
      <div class="modal-header align-items-center" style="background:#f4f6fa; border-top-left-radius:1.2rem; border-top-right-radius:1.2rem;">
        <h5 class="modal-title" id="ayushmanViewMoreModalLabel" style="font-weight:700; color:#232946;">Ayushman Card Details</h5>
        <div class="ms-auto d-flex gap-2 align-items-center">
          <button type="button" class="btn btn-outline-primary btn-sm" id="copyAyushmanViewMoreBtn" title="Copy Selected">
            <i class="bi bi-clipboard"></i> Copy Selected
          </button>
          <button type="button" class="btn btn-outline-success btn-sm" id="whatsappAyushmanViewMoreBtn" title="Send to WhatsApp">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </button>
          <button type="button" class="btn btn-close ms-2" data-bs-dismiss="modal" aria-label="Close" style="font-size:1.3rem;"></button>
        </div>
      </div>
      <div class="modal-body" id="ayushmanViewMoreModalBody" style="background:#f8fafc; border-bottom-left-radius:1.2rem; border-bottom-right-radius:1.2rem; padding:2rem 2.2rem;">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>
<style>
#ayushmanViewMoreModal .modal-content {
    border-radius: 1.2rem;
    box-shadow: 0 4px 32px rgba(34,43,69,0.13);
}
#ayushmanViewMoreModal .modal-header {
    border-bottom: 1px solid #e5e7eb;
    border-top-left-radius: 1.2rem;
    border-top-right-radius: 1.2rem;
    padding-top: 0.9rem;
    padding-bottom: 0.9rem;
}
#ayushmanViewMoreModal .modal-body {
    border-bottom-left-radius: 1.2rem;
    border-bottom-right-radius: 1.2rem;
    padding-left: 2.2rem;
    padding-right: 2.2rem;
    padding-top: 2rem;
    padding-bottom: 2rem;
}
#ayushmanViewMoreModal .copy-label {
    font-weight: 600;
    color: #232946;
    min-width: 120px;
    display: inline-block;
}
#ayushmanViewMoreModal .copy-value {
    color: #232946;
    margin-left: 0.5rem;
    font-weight: 500;
}
#ayushmanViewMoreModal .copy-field {
    accent-color: #232946;
    margin-left: 0.8rem;
    margin-right: 0.5rem;
}
#ayushmanViewMoreModal .viewmore-field {
    display: flex;
    align-items: center;
    margin-bottom: 1.1rem;
    padding: 0.5rem 0.3rem;
    border-bottom: 1px solid #f1f1f1;
}
#ayushmanViewMoreModal .viewmore-field:last-child {
    border-bottom: none;
}
@media (max-width: 767px) {
    #ayushmanViewMoreModal .modal-body {
        padding-left: 0.7rem;
        padding-right: 0.7rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    #ayushmanViewMoreModal .viewmore-field {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.3rem;
    }
}
</style>
<script>
function showAyushmanViewMoreModal(id) {
    $('#ayushmanViewMoreModal').modal('show');
    $('#ayushmanViewMoreModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/ayushman-card-query/view/' + id + '?viewmore=1', function(html) {
        $('#ayushmanViewMoreModalBody').html(html);

        // By default, check basic fields for copy
        $('#ayushmanViewMoreModalBody input[type="checkbox"].copy-field').each(function() {
            var field = $(this).data('field');
            if (['patient_name','mobile','problam','doctor','hospital','amount','paid_amount','payment_id'].includes(field)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    });
}

function getSelectedAyushmanViewMoreText() {
    var lines = [];
    $('#ayushmanViewMoreModalBody input[type="checkbox"].copy-field:checked').each(function() {
        var label = $(this).closest('.viewmore-field').find('.copy-label').text().trim();
        var value = $(this).closest('.viewmore-field').find('.copy-value').text().trim();
        if (label && value) {
            lines.push(label + ' ' + value);
        }
    });
    return lines.join('\n');
}

$('#copyAyushmanViewMoreBtn').on('click', function() {
    var text = getSelectedAyushmanViewMoreText();
    if (!text) {
        Swal.fire({
            icon: 'warning',
            title: 'Nothing selected',
            text: 'Please select at least one field to copy.',
            timer: 1200,
            showConfirmButton: false
        });
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Selected details copied to clipboard.',
            timer: 1200,
            showConfirmButton: false
        });
    });
});

// WhatsApp share
$('#whatsappAyushmanViewMoreBtn').on('click', function() {
    var text = getSelectedAyushmanViewMoreText();
    if (!text) {
        Swal.fire({
            icon: 'warning',
            title: 'Nothing selected',
            text: 'Please select at least one field to share.',
            timer: 1200,
            showConfirmButton: false
        });
        return;
    }
    var url = 'https://wa.me/?text=' + encodeURIComponent(text);
    window.open(url, '_blank');
});
</script>
@endsection

{{-- SweetAlert2 for success messages --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonColor: '#232946'
        }).then(function() {
            window.location.reload();
        });
    @endif
});
</script>
