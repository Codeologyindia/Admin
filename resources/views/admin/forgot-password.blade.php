@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg border-0 animate__animated animate__fadeInDown login-card bg-white" style="max-width:370px; border-radius:2rem;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966484.png" alt="Hospital Logo" style="width:56px; height:56px; object-fit:contain;">
                <div class="fw-bold mt-2" style="font-size:1.5rem; letter-spacing:1px; color:#222;">HOSPITAL</div>
            </div>
            <h4 class="fw-bold mb-1" style="color:#222;">Forgot Password?</h4>
            <div class="mb-3" style="color:#888; font-size:1rem;">Enter your email and we'll send you a reset link.</div>
            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius:0.75rem 0 0 0.75rem;">
                            <i class="bi bi-envelope" style="color:#3b82f6;"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="form-control @error('email') is-invalid @enderror border-start-0"
                            placeholder="Email" style="height:48px; font-size:1rem; border-radius:0 0.75rem 0.75rem 0;">
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn w-100 fw-bold py-2 mb-3"
                        style="font-size:1.1rem; background: #6366f1; color: #fff; border-radius:0.75rem;">
                    Send Reset Link
                </button>
            </form>
            <div class="mt-4 text-center" style="font-size:0.97rem;">
                <a href="{{ route('admin.login') }}" style="color:#3b82f6; text-decoration: none; font-weight: 500;">
                    <i class="bi bi-arrow-left"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
@endsection
