@extends('layouts.admin')

@section('title', 'Ayushman Card Query')
@section('topbar-title', 'Ayushman Card Query')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0" style="border-radius:0;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end mb-4">
                <div class="col-md-2">
                    <label class="form-label mb-1">Number</label>
                    <input type="text" name="number" value="{{ request('number') }}" class="form-control" placeholder="Enter number">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control form-select">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">All</option>
                        <option value="done" {{ request('payment_status')=='done' ? 'selected' : '' }}>Done</option>
                        <option value="pending" {{ request('payment_status')=='pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Doctor</label>
                    <select name="doctor" class="form-select">
                        <option value="">All</option>
                        {{-- @foreach($doctors as $doctor) --}}
                        {{-- <option value="{{ $doctor->id }}" {{ request('doctor')==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Hospital/Clinic</label>
                    <select name="hospital" class="form-select">
                        <option value="">All</option>
                        {{-- @foreach($hospitals as $hospital) --}}
                        {{-- <option value="{{ $hospital->id }}" {{ request('hospital')==$hospital->id ? 'selected' : '' }}>{{ $hospital->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    <a href="{{ route('admin.ayushman-card-query.add') }}" class="btn btn-success px-4 ms-2">
                        <i class="bi bi-plus-lg"></i> Add
                    </a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Number</th>
                            <th>Patient Name</th>
                            <th>Doctor</th>
                            <th>Hospital/Clinic</th>
                            <th>Problam</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Left</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-06-01</td>
                            <td>1</td>
                            <td>Jane Doe</td>
                            <td>Dr. Patel</td>
                            <td>Sunrise Clinic</td>
                            <td>Card Issue</td>
                            <td>300</td>
                            <td>200</td>
                            <td>100</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('admin.ayushman-card-query.edit', 1) }}" class="btn btn-sm btn-warning px-3" style="min-width:40px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success px-3" style="min-width:40px;" title="Payment" data-bs-toggle="modal" data-bs-target="#paymentModal1">
                                        <i class="bi bi-cash-coin"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info text-white px-3" style="min-width:40px;" title="Prescription" data-bs-toggle="modal" data-bs-target="#prescriptionModal1">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary px-3" style="min-width:40px;" title="View More" data-bs-toggle="modal" data-bs-target="#viewMoreModal1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" class="text-center text-muted">No records found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <nav>
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled"><span class="page-link">Prev</span></li>
                        <li class="page-item active"><span class="page-link">1</span></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Payment --}}
<div class="modal fade" id="paymentModal1" tabindex="-1" aria-labelledby="paymentModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel1">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-6">Paid</dt>
          <dd class="col-sm-6">200</dd>
          <dt class="col-sm-6">Payment Left</dt>
          <dd class="col-sm-6">100</dd>
        </dl>
        <form class="mt-4">
          <div class="mb-3 row align-items-center">
            <label for="payAmount1" class="col-sm-5 col-form-label">Add Payment Amount</label>
            <div class="col-sm-7">
              <input type="number" min="1" max="100" class="form-control" id="payAmount1" placeholder="Enter amount">
            </div>
          </div>
          <div class="mb-3 row align-items-center">
            <label for="transactionId1" class="col-sm-5 col-form-label">Transaction ID</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="transactionId1" placeholder="Enter transaction id">
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Add Payment</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal for View Prescription --}}
<div class="modal fade" id="prescriptionModal1" tabindex="-1" aria-labelledby="prescriptionModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="prescriptionModalLabel1">Prescription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="https://via.placeholder.com/400x500?text=Prescription+Image" alt="Prescription" class="img-fluid rounded mb-3" style="max-height:500px;">
        <div class="text-muted small">If you uploaded a prescription image or PDF, it will appear here.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal for View More --}}
<div class="modal fade" id="viewMoreModal1" tabindex="-1" aria-labelledby="viewMoreModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewMoreModalLabel1">Ayushman Card Query Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <dl class="row">
          <dt class="col-sm-4">Patient Name</dt>
          <dd class="col-sm-8">Jane Doe</dd>
          <dt class="col-sm-4">Date</dt>
          <dd class="col-sm-8">2024-06-01</dd>
          <dt class="col-sm-4">Doctor</dt>
          <dd class="col-sm-8">Dr. Patel</dd>
          <dt class="col-sm-4">Hospital/Clinic</dt>
          <dd class="col-sm-8">Sunrise Clinic</dd>
          <dt class="col-sm-4">Problam</dt>
          <dd class="col-sm-8">Card Issue</dd>
          <dt class="col-sm-4">Amount</dt>
          <dd class="col-sm-8">300</dd>
          <dt class="col-sm-4">Paid</dt>
          <dd class="col-sm-8">200</dd>
          <dt class="col-sm-4">Left</dt>
          <dd class="col-sm-8">100</dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
