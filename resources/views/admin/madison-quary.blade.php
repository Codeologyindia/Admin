@extends('layouts.admin')

@section('title', 'Madison Quary')
@section('topbar-title', 'Madison Quary')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4" style="border-radius:1rem;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end" id="madisonFilterForm">
                <div class="col-md-2">
                    <label class="form-label mb-1">Mobile Number</label>
                    <input type="text" name="mobile" value="{{ request('mobile') }}" class="form-control" placeholder="Enter mobile number" autocomplete="off">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">All</option>
                        <option value="done" {{ request('payment_status')=='done' ? 'selected' : '' }}>Done</option>
                        <option value="pending" {{ request('payment_status')=='pending' ? 'selected' : '' }}>Pending</option>
                    </select>
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
                    <a href="{{ route('admin.madison-quary.add') }}" class="btn btn-success px-4 ms-2">
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
                            <th>Doctor</th>
                            <th>Hospital/Clinic</th>
                            <th>Problam</th>
                            <th>State</th>
                            <th>City</th>
                            <th>District</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Left</th>
                            <th>Madison </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($madisonQuaries as $quary)
                        <tr>
                            <td>{{ $quary->created_at ? $quary->created_at->format('Y-m-d') : '' }}</td>
                            <td>{{ $quary->mobile }}</td>
                            <td>{{ $quary->patient_name }}</td>
                            <td>
                                {{-- Show doctor names if available --}}
                                @php
                                    $doctorNames = [];
                                    if ($quary->doctor_ids) {
                                        $ids = json_decode($quary->doctor_ids, true);
                                        $doctorNames = \App\Models\Doctor::whereIn('id', $ids)->pluck('name')->toArray();
                                    }
                                @endphp
                                {{ implode(', ', $doctorNames) }}
                            </td>
                            <td>
                                @php
                                    $hospitalNames = [];
                                    if ($quary->hospital_ids) {
                                        $ids = json_decode($quary->hospital_ids, true);
                                        $hospitalNames = \App\Models\Hospital::whereIn('id', $ids)->pluck('hospital_name')->toArray();
                                    }
                                @endphp
                                {{ implode(', ', $hospitalNames) }}
                            </td>
                            <td>{{ $quary->problam }}</td>
                            <td>
                                @php
                                    $stateName = '';
                                    if ($quary->state_id) {
                                        $state = \App\Models\State::find($quary->state_id);
                                        $stateName = $state ? $state->name : '';
                                    }
                                @endphp
                                {{ $stateName }}
                            </td>
                            <td>
                                @php
                                    $cityName = '';
                                    if ($quary->city_id) {
                                        $city = \App\Models\City::find($quary->city_id);
                                        $cityName = $city ? $city->name : '';
                                    }
                                @endphp
                                {{ $cityName }}
                            </td>
                            <td>
                                @php
                                    $districtName = '';
                                    if ($quary->district_id) {
                                        $district = \App\Models\District::find($quary->district_id);
                                        $districtName = $district ? $district->name : '';
                                    }
                                @endphp
                                {{ $districtName }}
                            </td>
                            <td>{{ $quary->amount }}</td>
                            <td>{{ $quary->paid_amount }}</td>
                            <td>{{ $quary->amount - $quary->paid_amount }}</td>
                            <td>
                                @if($quary->madison_upload)
                                    <a href="{{ asset('storage/' . $quary->madison_upload) }}" target="_blank" class="btn btn-sm btn-info">
                                        View
                                    </a>
                                @else
                                    <span class="text-muted">No File</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('admin.madison-quary.edit', $quary->id) }}" class="btn btn-sm btn-warning px-3" style="min-width:40px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success px-3" style="min-width:40px;" title="Payment" onclick="showPaymentModal({{ $quary->id }}, {{ $quary->paid_amount }}, {{ $quary->amount - $quary->paid_amount }})">
                                        <i class="bi bi-cash-coin"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info text-white px-3" style="min-width:40px;" title="Prescription" onclick="showPrescriptionModal({{ $quary->id }})">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary px-3" style="min-width:40px;" title="View More" onclick="showViewMoreModal({{ $quary->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="mt-3">
                {{ $madisonQuaries->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="paymentForm" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <dl class="row mb-0">
            <dt class="col-sm-6">Paid</dt>
            <dd class="col-sm-6" id="paidAmountShow"></dd>
            <dt class="col-sm-6">Payment Left</dt>
            <dd class="col-sm-6" id="leftAmountShow"></dd>
          </dl>
          <div class="mb-3 row align-items-center mt-3">
            <label for="payAmount" class="col-sm-5 col-form-label">Add Payment Amount</label>
            <div class="col-sm-7">
              <input type="number" min="1" class="form-control" id="payAmount" name="payAmount" placeholder="Enter amount">
            </div>
          </div>
          <div class="mb-3 row align-items-center">
            <label for="transactionId" class="col-sm-5 col-form-label">Transaction ID</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="transactionId" name="transactionId" placeholder="Enter transaction id">
            </div>
          </div>
          <div class="mb-3 text-end">
            <button type="button" class="btn btn-outline-info btn-sm" id="showPaymentLogsBtn">
              <i class="bi bi-clock-history"></i> Show Old Payments
            </button>
          </div>
          <div id="paymentLogsArea" style="display:none;">
            <div class="border rounded p-2 bg-light mb-2">
              <h6 class="mb-2 fw-bold text-primary"><i class="bi bi-clock-history"></i> Payment History</h6>
              <div id="paymentLogsContent" class="small"></div>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let currentPaymentQuaryId = null;

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

function showPaymentModal(id, paid, left) {
    $('#paymentModal').modal('show');
    $('#paidAmountShow').text(paid);
    $('#leftAmountShow').text(left);
    $('#payAmount').val('');
    $('#transactionId').val('');
    $('#paymentForm').attr('action', '/admin/madison-quary/update/' + id);
    $('#paymentLogsArea').hide();
    $('#paymentLogsContent').html('');
    currentPaymentQuaryId = id;
}

$('#showPaymentLogsBtn').on('click', function() {
    if (!currentPaymentQuaryId) return;
    $('#paymentLogsArea').show();
    $('#paymentLogsContent').html('<div class="text-muted">Loading...</div>');
    $.get('/admin/madison-quary/payment-logs/' + currentPaymentQuaryId, function(html) {
        $('#paymentLogsContent').html(html);
        // Optional: scroll to payment history
        $('#paymentLogsArea')[0].scrollIntoView({behavior: "smooth"});
    });
});

$('#paymentForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var payAmount = $('#payAmount').val();
    var transactionId = $('#transactionId').val();
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
            Swal.fire({
                icon: 'success',
                title: 'Payment Updated',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.reload();
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Could not update payment.'
            });
        }
    });
});
</script>

<!-- Prescription Modal (dynamic) -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="prescriptionModalLabel">Prescription & Uploaded Documents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="prescriptionModalBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function showPrescriptionModal(quaryId) {
    $('#prescriptionModal').modal('show');
    $('#prescriptionModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/madison-quary/prescription-files/' + quaryId, function(html) {
        $('#prescriptionModalBody').html(html);
    });
}
</script>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreModal1" tabindex="-1" aria-labelledby="viewMoreModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header align-items-center" style="background:#f4f6fa;">
        <h5 class="modal-title" id="viewMoreModalLabel1">Madison Quary Details</h5>
        <div class="ms-auto d-flex gap-2 align-items-center">
          <button type="button" class="btn btn-outline-primary btn-sm" id="copyViewMoreBtn" title="Copy Selected">
            <i class="bi bi-clipboard"></i> Copy Selected
          </button>
          <button type="button" class="btn btn-outline-success btn-sm" id="whatsappViewMoreBtn" title="Send to WhatsApp">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </button>
          <button type="button" class="btn btn-close ms-2" data-bs-dismiss="modal" aria-label="Close" style="font-size:1.3rem;"></button>
        </div>
      </div>
      <div class="modal-body" id="viewMoreModalBody" style="background:#f8fafc;">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<style>
#viewMoreModal1 .modal-content {
    border-radius: 1rem;
    box-shadow: 0 4px 32px rgba(34,43,69,0.13);
}
#viewMoreModal1 .modal-header {
    border-bottom: 1px solid #e5e7eb;
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    padding-top: 0.7rem;
    padding-bottom: 0.7rem;
}
#viewMoreModal1 .modal-body {
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    padding-left: 1.2rem;
    padding-right: 1.2rem;
}
#viewMoreModal1 .copy-label {
    font-weight: 600;
    color: #232946;
}
#viewMoreModal1 .copy-value {
    color: #232946;
}
#viewMoreModal1 .copy-field {
    accent-color: #232946;
}
</style>

<script>
function showViewMoreModal(id) {
    $('#viewMoreModal1').modal('show');
    $('#viewMoreModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/madison-quary/view-more/' + id, function(html) {
        $('#viewMoreModalBody').html(html);

        // By default, check basic fields for copy
        $('#viewMoreModalBody input[type="checkbox"].copy-field').each(function() {
            var field = $(this).data('field');
            if (['patient_name','mobile','problam','doctor','hospital','amount','paid_amount','payment_id'].includes(field)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    });
}

function getSelectedViewMoreText() {
    var lines = [];
    $('#viewMoreModalBody input[type="checkbox"].copy-field:checked').each(function() {
        var label = $(this).closest('.viewmore-field').find('.copy-label').text().trim();
        var value = $(this).closest('.viewmore-field').find('.copy-value').text().trim();
        if (label && value) {
            lines.push(label + ' ' + value);
        }
    });
    return lines.join('\n');
}

$('#copyViewMoreBtn').on('click', function() {
    var text = getSelectedViewMoreText();
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
$('#whatsappViewMoreBtn').on('click', function() {
    var text = getSelectedViewMoreText();
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
<script>
document.getElementById('resetFilterBtn').onclick = function() {
    let form = document.getElementById('madisonFilterForm');
    form.querySelectorAll('input, select').forEach(function(el) {
        if (el.type === 'select-one' || el.type === 'text' || el.type === 'date') el.value = '';
    });
    form.submit();
};
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

function showPrescriptionModal(quaryId) {
    $('#prescriptionModal').modal('show');
    $('#prescriptionModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $.get('/admin/madison-quary/prescription-files/' + quaryId, function(html) {
        $('#prescriptionModalBody').html(html);
    });
}
</script>
