@extends('layouts.admin')

@section('title', 'Hospital List')
@section('topbar-title', 'Hospital List')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4" style="border-radius:1rem;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Hospital/Clinic List</h4>
                <a href="{{ route('admin.hospital.add') }}" class="btn btn-success px-4">
                    <i class="bi bi-plus-lg"></i> Add Hospital
                </a>
            </div>
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.hospital') }}" class="row g-2 align-items-end mb-4 bg-light p-3 rounded shadow-sm">
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-semibold">Name</label>
                    <input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm" placeholder="Name">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-semibold">Type</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="Hospital" {{ request('type')=='Hospital' ? 'selected' : '' }}>Hospital</option>
                        <option value="Clinic" {{ request('type')=='Clinic' ? 'selected' : '' }}>Clinic</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-semibold">City</label>
                    <input type="text" name="city" value="{{ request('city') }}" class="form-control form-control-sm" placeholder="City">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-semibold">State</label>
                    <input type="text" name="state" value="{{ request('state') }}" class="form-control form-control-sm" placeholder="State">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-semibold">Contact</label>
                    <input type="text" name="contact" value="{{ request('contact') }}" class="form-control form-control-sm" placeholder="Contact">
                </div>
                <div class="col-md-1 text-end d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Filter</button>
                    <a href="{{ route('admin.hospital') }}" class="btn btn-secondary btn-sm px-3">Reset</a>
                </div>
            </form>
            {{-- End Filter Form --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" style="background:#fff;">
                    <thead class="table-light">
                        <tr class="align-middle text-center">
                            <th style="width:40px;">#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th style="width:80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startIndex = ($hospitals->currentPage() - 1) * $hospitals->perPage() + 1;
                        @endphp
                        @forelse($hospitals as $hospital)
                        <tr>
                            <td class="text-center text-muted">{{ $startIndex++ }}</td>
                            <td class="fw-semibold">{{ $hospital->hospital_name }}</td>
                            <td>{{ $hospital->type }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->state }}</td>
                            <td>{{ $hospital->contact }}</td>
                            <td>{{ $hospital->address }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.hospital.edit', $hospital->id) }}" class="btn btn-sm btn-warning px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="mt-3">
                <style>
                    .pagination .page-link { font-size: 0.85rem; }
                    .pagination .page-item.active .page-link { background: #232946; border-color: #232946; color: #fff; }
                </style>
                <nav>
                    <ul class="pagination justify-content-end mb-0">
                        {{-- Previous --}}
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $hospitals->url($currentPage - 1) }}{{ request()->getQueryString() ? '&'.request()->getQueryString() : '' }}">Prev</a>
                        </li>
                        {{-- Page Numbers --}}
                        @foreach($pages as $page)
                            <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $hospitals->url($page) }}{{ request()->getQueryString() ? '&'.request()->getQueryString() : '' }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        {{-- Next --}}
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $hospitals->url($currentPage + 1) }}{{ request()->getQueryString() ? '&'.request()->getQueryString() : '' }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            {{-- End Pagination --}}
        </div>
    </div>
</div>
@endsection
