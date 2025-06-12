@extends('layouts.admin')

@section('title', 'All Online Bookings')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h2 class="mb-4 text-primary fw-bold">All Online Bookings</h2>
            <!-- Filter Section -->
            <form method="GET" class="mb-3" id="bookingFilterForm">
                <div class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label mb-1">Person Name</label>
                        <input type="text" name="person_name" class="form-control" placeholder="Person Name" value="{{ request('person_name') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ request('phone') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Gender</option>
                            <option value="Male" {{ request('gender')=='Male'?'selected':'' }}>Male</option>
                            <option value="Female" {{ request('gender')=='Female'?'selected':'' }}>Female</option>
                            <option value="Other" {{ request('gender')=='Other'?'selected':'' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1">State</label>
                        <input type="text" name="state" class="form-control" placeholder="State" value="{{ request('state') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1">City</label>
                        <input type="text" name="city" class="form-control" placeholder="City" value="{{ request('city') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1">Hospital</label>
                        <input type="text" name="hospital" class="form-control" placeholder="Hospital" value="{{ request('hospital') }}">
                    </div>
                    <div class="col-md-2 mt-2">
                        <label class="form-label mb-1">Department</label>
                        <input type="text" name="department" class="form-control" placeholder="Department" value="{{ request('department') }}">
                    </div>
                    <div class="col-md-2 mt-2">
                        <label class="form-label mb-1">Problem</label>
                        <input type="text" name="problem" class="form-control" placeholder="Problem" value="{{ request('problem') }}">
                    </div>
                    <div class="col-md-2 mt-2">
                        <label class="form-label mb-1">Appointment Date</label>
                        <input type="date" name="appointment_date" class="form-control" value="{{ request('appointment_date') }}">
                    </div>
                    <div class="col-md-2 mt-2">
                        <label class="form-label mb-1">Show</label>
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page', $perPage ?? 10)==10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ request('per_page', $perPage ?? 10)==50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page', $perPage ?? 10)==100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i> Filter</button>
                        <a href="{{ route('admin.booking-list') }}" class="btn btn-secondary flex-fill"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
                    </div>
                    <div class="col-md-3 mt-2">
                        <button type="button" class="btn btn-success w-100" id="excelDownloadBtn">
                            <i class="bi bi-file-earmark-excel"></i> Download Excel
                        </button>
                    </div>
                </div>
            </form>
            <!-- Excel Download Modal -->
            <div class="modal fade" id="excelDownloadModal" tabindex="-1" aria-labelledby="excelDownloadModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <form method="GET" action="{{ route('admin.booking-list-excel') }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="excelDownloadModalLabel"><i class="bi bi-file-earmark-excel"></i> Download Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="bi bi-download"></i> Download</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Person Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Hospital</th>
                            <th>Department</th>
                            <th>Problem</th>
                            <th>Appointment Date</th>
                            <th>Amount</th>
                            <th>Left</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        @php
                            $total = (float)($booking->amount ?? 0);
                            $paid = (float)($booking->paid_amount ?? 0);
                            $left = $total - $paid;
                        @endphp
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->person_name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->gender }}</td>
                            <td>{{ $booking->state->name ?? $booking->new_state ?? '-' }}</td>
                            <td>{{ $booking->city->name ?? $booking->new_city ?? '-' }}</td>
                            <td>{{ $booking->hospital->hospital_name ?? $booking->new_hospital ?? '-' }}</td>
                            <td>{{ $booking->department->name ?? $booking->new_department ?? '-' }}</td>
                            <td>{{ $booking->problem }}</td>
                            <td>{{ $booking->appointment_date }}</td>
                            <td>{{ $total }}</td>
                            <td>
                                <span class="{{ $left > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                    {{ $left > 0 ? $left : '0' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.booking-view', $booking->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.booking-edit', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @if($left > 0)
                                <button type="button" class="btn btn-sm btn-warning payment-btn" 
                                    data-id="{{ $booking->id }}"
                                    data-amount="{{ $total }}"
                                    data-paid="{{ $paid }}"
                                    data-left="{{ $left }}"
                                    data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="bi bi-cash-coin"></i> Payment
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>
                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries
                </div>
                <div>
                    @if ($bookings->lastPage() > 1)
                    <nav>
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            <li class="page-item {{ $bookings->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $bookings->previousPageUrl() ?? '#' }}" tabindex="-1">Previous</a>
                            </li>
                            {{-- Page Numbers --}}
                            @php
                                $current = $bookings->currentPage();
                                $last = $bookings->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                                if ($current == 1) $end = min($last, 3);
                                if ($current == $last) $start = max(1, $last - 2);
                            @endphp
                            @for ($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $bookings->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            {{-- Next Page Link --}}
                            <li class="page-item {{ $current == $last ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $bookings->nextPageUrl() ?? '#' }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="paymentUpdateForm" method="POST" action="{{ route('admin.booking-payment-update') }}">
      @csrf
      <input type="hidden" name="booking_id" id="modal_booking_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel"><i class="bi bi-cash-coin"></i> Update Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Total Amount</label>
            <input type="number" class="form-control" id="modal_amount" name="amount" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Payment Left</label>
            <input type="number" class="form-control" id="modal_left" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Payment ID / Reference</label>
            <input type="text" class="form-control" id="modal_payment_id" name="payment_id" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Pay Now</label>
            <input type="number" class="form-control" id="modal_paid_amount" name="paid_amount" min="0" step="0.01" required>
          </div>
          <hr>
          <h6>Payment History</h6>
          <div id="payment-history-list" style="max-height:150px;overflow:auto;">
            <div class="text-muted small">Loading...</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save Payment</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.payment-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modal_booking_id').value = btn.dataset.id;
            document.getElementById('modal_amount').value = btn.dataset.amount;
            document.getElementById('modal_paid_amount').value = '';
            document.getElementById('modal_left').value = btn.dataset.left;
            document.getElementById('modal_payment_id').value = '';
            // Load payment history
            let historyList = document.getElementById('payment-history-list');
            historyList.innerHTML = '<div class="text-muted small">Loading...</div>';
            fetch('/admin/booking-payment-history/' + btn.dataset.id)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        historyList.innerHTML = '<div class="text-muted small">No payment history.</div>';
                    } else {
                        historyList.innerHTML = data.map(function(item) {
                            return `<div class="border-bottom py-1">
                                <b>Paid:</b> ${item.paid_amount} 
                                <b>ID:</b> ${item.payment_id} 
                                <span class="text-muted small">(${item.created_at})</span>
                            </div>`;
                        }).join('');
                    }
                });
        });
    });
    // Short copy button
    document.querySelectorAll('.btn-copy-short').forEach(function(btn) {
        btn.addEventListener('click', function() {
            navigator.clipboard.writeText(btn.dataset.short);
            btn.innerHTML = '<i class="bi bi-clipboard-check"></i> Copied!';
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-clipboard"></i> Short';
            }, 1200);
        });
    });
    // Update left amount live in modal
    document.getElementById('modal_paid_amount').addEventListener('input', function() {
        let total = parseFloat(document.getElementById('modal_amount').value) || 0;
        let paid = parseFloat(this.value) || 0;
        let left = total - paid;
        document.getElementById('modal_left').value = left > 0 ? left : 0;
    });
    document.getElementById('excelDownloadBtn').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('excelDownloadModal'));
        modal.show();
    });
});
</script>
@endsection
