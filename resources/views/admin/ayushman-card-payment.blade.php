@extends('layouts.admin')

@section('title', 'Ayushman Card Payment')
@section('topbar-title', 'Ayushman Card Payment')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="fw-bold mb-3">Payment for: {{ $card->patient_name }}</h4>
            <form id="paymentFormAyushman" method="POST" action="{{ route('admin.ayushman-card-query.update', $card->id) }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" value="{{ $card->amount }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Paid Amount</label>
                        <input type="text" class="form-control" value="{{ $card->paid_amount }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Left Amount</label>
                        <input type="text" class="form-control" value="{{ $card->amount - $card->paid_amount }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Add Payment Amount</label>
                        <input type="number" min="1" name="paid_amount" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" name="payment_id" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Payment</button>
                <a href="{{ route('admin.ayushman-card-query') }}" class="btn btn-secondary ms-2">Back</a>
            </form>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Ayasman Logs</h5>
            @if($logs->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at ? $log->created_at->format('Y-m-d H:i') : '' }}</td>
                                    <td>{{ $log->amount }}</td>
                                    <td>{{ $log->payment_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-muted">No payment logs found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
