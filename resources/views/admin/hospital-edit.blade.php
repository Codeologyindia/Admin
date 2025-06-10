@extends('layouts.admin')

@section('title', 'Edit Hospital')
@section('topbar-title', 'Edit Hospital')

@section('content')
<div class="container-fluid p-0 m-0">
    <div class="row justify-content-center g-0 m-0">
        <div class="col-12 col-md-12 p-0 m-0">
            <div class="card shadow-sm border-0" style="border-radius:0;">
                <div class="card-body p-4" style="font-size:0.75rem;">
                    <h3 class="fw-bold mb-4 text-center" style="color:#232946;">Edit Hospital</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.hospital.update', $hospital->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Hospital/Clinic Name</label>
                                <input type="text" name="hospital_name" class="form-control" value="{{ old('hospital_name', $hospital->hospital_name) }}" placeholder="Enter hospital or clinic name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="">Select type</option>
                                    <option value="Hospital" {{ old('type', $hospital->type)=='Hospital' ? 'selected' : '' }}>Hospital</option>
                                    <option value="Clinic" {{ old('type', $hospital->type)=='Clinic' ? 'selected' : '' }}>Clinic</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $hospital->city) }}" placeholder="Enter city">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $hospital->state) }}" placeholder="Enter state">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact" class="form-control" value="{{ old('contact', $hospital->contact) }}" placeholder="Enter contact number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $hospital->address) }}" placeholder="Enter address">
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                Update Hospital
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
