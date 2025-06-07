<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;

Route::get('/', function () {
    return view('welcome');
});

// Admin Login Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [Login::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [Login::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [Login::class, 'logout'])->name('admin.logout');

    // Google Login
    Route::get('login/google', [Login::class, 'redirectToGoogle'])->name('admin.login.google');
    Route::get('login/google/callback', [Login::class, 'handleGoogleCallback'])->name('admin.login.google.callback');
});

// Forgot Password
Route::get('admin/forgot-password', function () {
    return view('admin.forgot-password');
})->name('admin.password.request');
Route::post('admin/forgot-password', function () {
    // Handle sending reset link logic here
})->name('admin.password.email');

// Signup
Route::get('admin/signup', function () {
    return view('admin.signup');
})->name('admin.signup');
Route::post('admin/signup', function () {
    // Handle signup logic here
})->name('admin.signup.submit');

// Optional: If you want /login to show the admin login form as well
Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
