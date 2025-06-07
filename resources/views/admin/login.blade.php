@extends('layouts.app')

@section('content')
<style>
    .login-card {
        border-radius: 1.5rem;
        margin: 0 auto;
        max-width: 370px;
        width: 100%;
    }
    @media (min-width: 768px) {
        .login-card {
            max-width: 420px;
            border-radius: 2rem;
        }
    }
</style>
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg border-0 animate__animated animate__fadeInDown login-card bg-white">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966484.png" alt="Hospital Logo" style="width:56px; height:56px; object-fit:contain;">
                <div class="fw-bold mt-2" style="font-size:1.5rem; letter-spacing:1px; color:#222;">HOSPITAL</div>
            </div>
            <h4 class="fw-bold mb-1" style="color:#222;">Log In</h4>
            <div class="mb-3" style="color:#888; font-size:1rem;">Let's get to work</div>
            <form method="POST" action="{{ route('admin.login.submit') }}">
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
                <div class="mb-2">
                    <div class="input-group" id="show_hide_password">
                        <span class="input-group-text bg-white border-end-0" style="border-radius:0.75rem 0 0 0.75rem;">
                            <i class="bi bi-lock" style="color:#3b82f6;"></i>
                        </span>
                        <input type="password" name="password" required
                            class="form-control @error('password') is-invalid @enderror border-start-0"
                            placeholder="Password" style="height:48px; font-size:1rem; border-radius:0 0.75rem 0.75rem 0;" id="password-input">
                        <span class="input-group-text bg-white border-start-0" style="border-radius:0 0.75rem 0.75rem 0; cursor:pointer;" id="toggle-password">
                            <i class="bi bi-eye-slash" id="toggle-password-icon" style="color:#bbb;"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 text-end">
                    <a href="{{ route('admin.password.request') }}" style="color:#3b82f6; font-size:0.97rem; text-decoration:none;">Forgot Password?</a>
                </div>
                <button type="submit" class="btn w-100 fw-bold py-2 mb-3"
                        style="font-size:1.1rem; background: #6366f1; color: #fff; border-radius:0.75rem;">
                    Login
                </button>
                <div class="text-center mb-2" style="color:#aaa;">OR</div>
                <a href="{{ route('admin.login.google') }}" class="btn btn-outline-light w-100 py-2 border"
                   style="border-radius:0.75rem; font-weight:500; color:#222; background:#f8f9fa;">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                         alt="Google" style="width:20px; margin-right:8px; vertical-align:middle;">
                    Login with Google
                </a>
            </form>
            <div class="mt-4 text-center" style="font-size:0.97rem;">
                <span style="color:#888;">Don't have account?</span>
                <a href="{{ route('admin.signup') }}" style="color:#3b82f6; text-decoration: none; font-weight: 500;">Sign Up</a>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password-input');
        const togglePassword = document.getElementById('toggle-password');
        const toggleIcon = document.getElementById('toggle-password-icon');
        togglePassword.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
@endsection
