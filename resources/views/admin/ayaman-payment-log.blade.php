@extends('layouts.admin')

@section('title', 'Ayaman Payment Log')
@section('topbar-title', 'Ayaman Payment Log')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="fw-bold mb-3">Payment Log for: {{ $card->patient_name }}</h4>
            <a href="{{ route('admin.ayushman-card-query') }}" class="btn btn-secondary mb-3">Back</a>
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
