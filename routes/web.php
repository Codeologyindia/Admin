<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MadisonQuaryController;
use App\Http\Controllers\Admin\AyasmarCardController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\AjaxLocationController;

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

// Admin Dashboard & Madison Quary
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/madison-quary', [MadisonQuaryController::class, 'index'])->name('admin.madison-quary');
Route::get('/admin/madison-quary/add', [MadisonQuaryController::class, 'add'])->name('admin.madison-quary.add');
Route::post('/admin/madison-quary/store', [MadisonQuaryController::class, 'store'])->name('admin.madison-quary.store');

// Edit Madison Quary (loads a separate page, not a modal)
Route::get('/admin/madison-quary/edit/{id}', [MadisonQuaryController::class, 'edit'])->name('admin.madison-quary.edit');
Route::post('/admin/madison-quary/update/{id}', [MadisonQuaryController::class, 'update'])->name('admin.madison-quary.update');

// Ayushman Card Query
Route::get('/admin/ayushman-card-query', [AyasmarCardController::class, 'index'])->name('admin.ayushman-card-query');
Route::get('/admin/ayushman-card-query/add', [AyasmarCardController::class, 'add'])->name('admin.ayushman-card-query.add');
Route::post('/admin/ayushman-card-query/store', [AyasmarCardController::class, 'store'])->name('admin.ayushman-card-query.store');
Route::get('/admin/ayushman-card-query/edit/{id}', [AyasmarCardController::class, 'edit'])->name('admin.ayushman-card-query.edit');
Route::post('/admin/ayushman-card-query/update/{id}', [AyasmarCardController::class, 'update'])->name('admin.ayushman-card-query.update');

// Hospital Management routes
Route::get('/admin/hospital', [HospitalController::class, 'index'])->name('admin.hospital');
Route::get('/admin/hospital/add', [HospitalController::class, 'create'])->name('admin.hospital.add');
Route::post('/admin/hospital/add', [HospitalController::class, 'store'])->name('admin.hospital.store');
Route::get('/admin/hospital/edit/{id}', [HospitalController::class, 'edit'])->name('admin.hospital.edit');
Route::post('/admin/hospital/edit/{id}', [HospitalController::class, 'update'])->name('admin.hospital.update');

// AJAX routes for dynamic State, City, District, Doctor, Hospital, Department
Route::get('/admin/ajax/states', [AjaxLocationController::class, 'states']);
Route::get('/admin/ajax/cities', [AjaxLocationController::class, 'cities']);
Route::get('/admin/ajax/districts', [AjaxLocationController::class, 'districts']);
Route::get('/admin/ajax/doctors', [AjaxLocationController::class, 'doctors']);
Route::get('/admin/ajax/hospitals', [AjaxLocationController::class, 'hospitals']);
Route::get('/admin/ajax/departments', [AjaxLocationController::class, 'departments']);
