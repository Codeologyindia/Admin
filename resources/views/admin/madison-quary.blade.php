@extends('layouts.admin')

@section('title', 'Madison Quary')
@section('topbar-title', 'Madison Quary')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4" style="border-radius:1rem;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
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
                <div class="col-md-2">
                    <label class="form-label mb-1">Doctor</label>
                    <select name="doctor" class="form-select">
                        <option value="">All</option>
                        {{-- @foreach($doctors as $doctor) --}}
                        {{-- <option value="{{ $doctor->id }}" {{ request('doctor')==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>
                <div class="col-md-2">
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
                        @forelse($madisonQuaries as $quary)
                        <tr>
                            <td>{{ $quary->created_at ? $quary->created_at->format('Y-m-d') : '' }}</td>
                            <td>{{ $quary->id }}</td>
                            <td>{{ $quary->patient_name }}</td>
                            <td>{{ $quary->doctor_name }}</td>
                            <td>{{ $quary->hospital_name }}</td>
                            <td>{{ $quary->problam }}</td>
                            <td>{{ $quary->amount }}</td>
                            <td>{{ $quary->paid_amount }}</td>
                            <td>{{ $quary->amount - $quary->paid_amount }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('admin.madison-quary.edit', $quary->id) }}" class="btn btn-sm btn-warning px-3" style="min-width:40px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success px-3" style="min-width:40px;" title="Payment" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $quary->id }}">
                                        <i class="bi bi-cash-coin"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info text-white px-3" style="min-width:40px;" title="Prescription" data-bs-toggle="modal" data-bs-target="#prescriptionModal{{ $quary->id }}">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary px-3" style="min-width:40px;" title="View More" data-bs-toggle="modal" data-bs-target="#viewMoreModal{{ $quary->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {{-- Payment Modal --}}
                        <div class="modal fade" id="paymentModal{{ $quary->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $quary->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel{{ $quary->id }}">Payment Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <dl class="row mb-0">
                                  <dt class="col-sm-6">Paid</dt>
                                  <dd class="col-sm-6">{{ $quary->paid_amount }}</dd>
                                  <dt class="col-sm-6">Payment Left</dt>
                                  <dd class="col-sm-6">{{ $quary->amount - $quary->paid_amount }}</dd>
                                </dl>
                                <form class="mt-4">
                                  <div class="mb-3 row align-items-center">
                                    <label for="payAmount{{ $quary->id }}" class="col-sm-5 col-form-label">Add Payment Amount</label>
                                    <div class="col-sm-7">
                                      <input type="number" min="1" max="{{ $quary->amount - $quary->paid_amount }}" class="form-control" id="payAmount{{ $quary->id }}" placeholder="Enter amount">
                                    </div>
                                  </div>
                                  <div class="mb-3 row align-items-center">
                                    <label for="transactionId{{ $quary->id }}" class="col-sm-5 col-form-label">Transaction ID</label>
                                    <div class="col-sm-7">
                                      <input type="text" class="form-control" id="transactionId{{ $quary->id }}" placeholder="Enter transaction id">
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
                        {{-- Prescription Modal --}}
                        <div class="modal fade" id="prescriptionModal{{ $quary->id }}" tabindex="-1" aria-labelledby="prescriptionModalLabel{{ $quary->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="prescriptionModalLabel{{ $quary->id }}">Prescription</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-center">
                                @if($quary->madison_upload)
                                    <img src="{{ asset('storage/' . $quary->madison_upload) }}" alt="Prescription" class="img-fluid rounded mb-3" style="max-height:500px;">
                                @else
                                    <img src="https://via.placeholder.com/400x500?text=Prescription+Image" alt="Prescription" class="img-fluid rounded mb-3" style="max-height:500px;">
                                    <div class="text-muted small">If you uploaded a prescription image or PDF, it will appear here.</div>
                                @endif
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- View More Modal --}}
                        <div class="modal fade" id="viewMoreModal{{ $quary->id }}" tabindex="-1" aria-labelledby="viewMoreModalLabel{{ $quary->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="viewMoreModalLabel{{ $quary->id }}">Madison Quary Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-7">
                                    <div class="border rounded p-3 mb-3" style="background:#fffbe7;">
                                      <h6 class="fw-bold mb-3 text-primary" style="font-size:1.1rem;">
                                        <i class="bi bi-person-vcard"></i> Madison Quary Details
                                      </h6>
                                      <table class="table table-sm table-borderless mb-0">
                                        <tbody>
                                          <tr>
                                            <th class="text-end" style="width:40%;">Patient Name:</th>
                                            <td>{{ $quary->patient_name }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Date:</th>
                                            <td>{{ $quary->created_at ? $quary->created_at->format('Y-m-d') : '' }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Doctor:</th>
                                            <td>{{ $quary->doctor_name }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Hospital/Clinic:</th>
                                            <td>{{ $quary->hospital_name }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Problam:</th>
                                            <td>{{ $quary->problam }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Amount:</th>
                                            <td>{{ $quary->amount }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Paid:</th>
                                            <td>{{ $quary->paid_amount }}</td>
                                          </tr>
                                          <tr>
                                            <th class="text-end">Left:</th>
                                            <td>{{ $quary->amount - $quary->paid_amount }}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="border rounded p-3 mb-2" style="background:#f0f4ff;">
                                      <div class="fw-bold mb-2 text-primary" style="font-size:1.05rem;">
                                        <i class="bi bi-share-fill"></i> Select to Share
                                      </div>
                                      <form id="shareForm{{ $quary->id }}" onsubmit="return false;">
                                        <div class="mb-2" style="columns:2; -webkit-columns:2;">
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_patient{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_patient{{ $quary->id }}">Patient Name: {{ $quary->patient_name }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_date{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_date{{ $quary->id }}">Date: {{ $quary->created_at ? $quary->created_at->format('Y-m-d') : '' }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_doctor{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_doctor{{ $quary->id }}">Doctor: {{ $quary->doctor_name }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_hospital{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_hospital{{ $quary->id }}">Hospital/Clinic: {{ $quary->hospital_name }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_problam{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_problam{{ $quary->id }}">Problam: {{ $quary->problam }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_amount{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_amount{{ $quary->id }}">Amount: {{ $quary->amount }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_paid{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_paid{{ $quary->id }}">Paid: {{ $quary->paid_amount }}</label>
                                          </div>
                                          <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="share_left{{ $quary->id }}" checked>
                                            <label class="form-check-label" for="share_left{{ $quary->id }}">Left: {{ $quary->amount - $quary->paid_amount }}</label>
                                          </div>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap mt-3">
                                          <a href="#" id="whatsappShare{{ $quary->id }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="bi bi-whatsapp"></i> WhatsApp
                                          </a>
                                          <a href="#" id="emailShare{{ $quary->id }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-envelope"></i> Email
                                          </a>
                                          <button type="button" class="btn btn-secondary btn-sm" onclick="copyQuaryLink{{ $quary->id }}()">
                                            <i class="bi bi-clipboard"></i> Copy Link
                                          </button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <script>
                                function getShareText{{ $quary->id }}() {
                                  let text = [];
                                  if(document.getElementById('share_patient{{ $quary->id }}').checked) text.push('Patient Name: {{ $quary->patient_name }}');
                                  if(document.getElementById('share_date{{ $quary->id }}').checked) text.push('Date: {{ $quary->created_at ? $quary->created_at->format('Y-m-d') : '' }}');
                                  if(document.getElementById('share_doctor{{ $quary->id }}').checked) text.push('Doctor: {{ $quary->doctor_name }}');
                                  if(document.getElementById('share_hospital{{ $quary->id }}').checked) text.push('Hospital/Clinic: {{ $quary->hospital_name }}');
                                  if(document.getElementById('share_problam{{ $quary->id }}').checked) text.push('Problam: {{ $quary->problam }}');
                                  if(document.getElementById('share_amount{{ $quary->id }}').checked) text.push('Amount: {{ $quary->amount }}');
                                  if(document.getElementById('share_paid{{ $quary->id }}').checked) text.push('Paid: {{ $quary->paid_amount }}');
                                  if(document.getElementById('share_left{{ $quary->id }}').checked) text.push('Left: {{ $quary->amount - $quary->paid_amount }}');
                                  text.push('Link: ' + window.location.href);
                                  return text.join('\n');
                                }
                                function updateShareLinks{{ $quary->id }}() {
                                  let shareText = encodeURIComponent(getShareText{{ $quary->id }}());
                                  document.getElementById('whatsappShare{{ $quary->id }}').href = 'https://wa.me/?text=' + shareText;
                                  document.getElementById('emailShare{{ $quary->id }}').href = 'mailto:?subject=Madison%20Quary%20Details&body=' + shareText;
                                }
                                function copyQuaryLink{{ $quary->id }}() {
                                  navigator.clipboard.writeText(getShareText{{ $quary->id }}()).then(function() {
                                    alert('Details copied to clipboard!');
                                  });
                                }
                                document.querySelectorAll('#shareForm{{ $quary->id }} .form-check-input').forEach(function(cb) {
                                  cb.addEventListener('change', updateShareLinks{{ $quary->id }});
                  </div>
                  <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" id="share_left" checked>
                    <label class="form-check-label" for="share_left">Left: 100</label>
                  </div>
                </div>
                <div class="d-flex gap-2 flex-wrap mt-3">
                  <a href="#" id="whatsappShare" target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                  </a>
                  <a href="#" id="emailShare" class="btn btn-primary btn-sm">
                    <i class="bi bi-envelope"></i> Email
                  </a>
                  <button type="button" class="btn btn-secondary btn-sm" onclick="copyQuaryLink()">
                    <i class="bi bi-clipboard"></i> Copy Link
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script>
        function getShareText() {
          let text = [];
          if(document.getElementById('share_patient').checked) text.push('Patient Name: John Doe');
          if(document.getElementById('share_date').checked) text.push('Date: 2024-06-01');
          if(document.getElementById('share_doctor').checked) text.push('Doctor: Dr. Smith');
          if(document.getElementById('share_hospital').checked) text.push('Hospital/Clinic: City Hospital');
          if(document.getElementById('share_problam').checked) text.push('Problam: Fever & Cough');
          if(document.getElementById('share_amount').checked) text.push('Amount: 500');
          if(document.getElementById('share_paid').checked) text.push('Paid: 400');
          if(document.getElementById('share_left').checked) text.push('Left: 100');
          text.push('Link: ' + window.location.href);
          return text.join('\n');
        }
        function updateShareLinks() {
          let shareText = encodeURIComponent(getShareText());
          document.getElementById('whatsappShare').href = 'https://wa.me/?text=' + shareText;
          document.getElementById('emailShare').href = 'mailto:?subject=Madison%20Quary%20Details&body=' + shareText;
        }
        function copyQuaryLink() {
          navigator.clipboard.writeText(getShareText()).then(function() {
            alert('Details copied to clipboard!');
          });
        }
        document.querySelectorAll('#shareForm .form-check-input').forEach(function(cb) {
          cb.addEventListener('change', updateShareLinks);
        });
        updateShareLinks();
        </script>
        {{-- End Sharing Section --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Removed: Edit is now a separate page --}}
@endsection

{{-- Add jQuery CDN --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
