@extends('layouts.admin')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')
<!-- Madison Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius:1rem;">
            <div class="card-body">
                <h4 class="fw-bold mb-4" style="color:#232946;">
                    <i class="bi bi-capsule-pill"></i> Madison
                </h4>
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#3b82f6;">Madison Quary</div>
                            <div class="fs-5 fw-bold">{{ $madisonQuaryCount }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#6366f1;">Today Quary</div>
                            <div class="fs-5 fw-bold">{{ $todayQuaryCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#ef4444;">Today Quary Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($todayQuaryCount ?? 0) - ($todayQuaryDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#16a34a;">Today Quary Done</div>
                            <div class="fs-5 fw-bold">{{ $todayQuaryDone ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#22c55e;">Today Payment Done</div>
                            <div class="fs-5 fw-bold">{{ $todayPaymentDone ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#f59e42;">Today Payment Pending</div>
                            <div class="fs-5 fw-bold">{{ $todayPaymentPending ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#0ea5e9;">Month Quary</div>
                            <div class="fs-5 fw-bold">{{ $monthQuaryCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#f43f5e;">Monthly Quary Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($monthQuaryCount ?? 0) - ($monthQuaryDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#6366f1;">Last Month Payment Done</div>
                            <div class="fs-5 fw-bold">{{ $lastMonthPaymentDone ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#ef4444;">Last Month Payment Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($lastMonthPaymentTotal ?? 0) - ($lastMonthPaymentDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ayasmar Card Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius:1rem;">
            <div class="card-body">
                <h4 class="fw-bold mb-4" style="color:#232946;">
                    <i class="bi bi-credit-card-2-front"></i> Ayasmar Card
                </h4>
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#3b82f6;">Ayasmar Card Quary</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarQuaryCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#6366f1;">Today Quary</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarTodayQuaryCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#ef4444;">Today Quary Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($ayasmarTodayQuaryCount ?? 0) - ($ayasmarTodayQuaryDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#16a34a;">Today Quary Done</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarTodayQuaryDone ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#22c55e;">Today Payment Done</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarTodayPaymentDone ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#f59e42;">Today Payment Pending</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarTodayPaymentPending ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#0ea5e9;">Month Quary</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarMonthQuaryCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#f43f5e;">Monthly Quary Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($ayasmarMonthQuaryCount ?? 0) - ($ayasmarMonthQuaryDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#6366f1;">Last Month Payment Done</div>
                            <div class="fs-5 fw-bold">{{ $ayasmarLastMonthPaymentDone ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded text-center">
                            <div class="fw-semibold mb-1" style="color:#ef4444;">Last Month Payment Left</div>
                            <div class="fs-5 fw-bold">
                                {{ ($ayasmarLastMonthPaymentTotal ?? 0) - ($ayasmarLastMonthPaymentDone ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
