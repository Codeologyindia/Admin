<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MadisonQuaryController;
use App\Http\Controllers\Admin\AyasmarCardController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\AjaxLocationController;
use App\Http\Controllers\Admin\OnlineBookingController;

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

// Prescription Files
Route::get('/admin/madison-quary/prescription-files/{id}', [MadisonQuaryController::class, 'prescriptionFiles']);
Route::get('/admin/madison-quary/payment-logs/{id}', [MadisonQuaryController::class, 'paymentLogs']);

// Ayushman Card Query
Route::get('/admin/ayushman-card-query', [AyasmarCardController::class, 'index'])->name('admin.ayushman-card-query');
Route::get('/admin/ayushman-card-query/add', [AyasmarCardController::class, 'add'])->name('admin.ayushman-card-query.add');
Route::post('/admin/ayushman-card-query/store', [AyasmarCardController::class, 'store'])->name('admin.ayushman-card-query.store');
Route::get('/admin/ayushman-card-query/view/{id}', [AyasmarCardController::class, 'view'])->name('admin.ayushman-card-query.view');
Route::get('/admin/ayushman-card-query/edit/{id}', [AyasmarCardController::class, 'edit'])->name('admin.ayushman-card-query.edit');
Route::post('/admin/ayushman-card-query/update/{id}', [AyasmarCardController::class, 'update'])->name('admin.ayushman-card-query.update');

// Payment page for Ayushman Card
Route::get('/admin/ayushman-card-query/payment/{id}', [AyasmarCardController::class, 'payment'])->name('admin.ayushman-card-query.payment');

// Ayaman Payment Log page (AJAX for modal)
Route::get('/admin/ayushman-card-query/payment-log/{id}', [AyasmarCardController::class, 'paymentLog'])->name('admin.ayushman-card-query.payment-log');

// AJAX: Show all uploaded documents for Ayushman Card
Route::get('/admin/ayushman-card-query/documents/{id}', [AyasmarCardController::class, 'documents'])->name('admin.ayushman-card-query.documents');

// Hospital Management routes
Route::get('/admin/hospital', [HospitalController::class, 'index'])->name('admin.hospital');
Route::get('/admin/hospital/add', [HospitalController::class, 'create'])->name('admin.hospital.add');
Route::post('/admin/hospital/add', [HospitalController::class, 'store'])->name('admin.hospital.store');
Route::get('/admin/hospital/edit/{id}', [HospitalController::class, 'edit'])->name('admin.hospital.edit');
Route::post('/admin/hospital/edit/{id}', [HospitalController::class, 'update'])->name('admin.hospital.update');

// AJAX routes for dynamic State, City, District, Doctor, Hospital, Department
Route::get('/admin/ajax/states', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'states']);
Route::get('/admin/ajax/cities', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'cities']);
Route::get('/admin/ajax/districts', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'districts']);
Route::get('/admin/ajax/doctors', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'doctors']);
Route::get('/admin/ajax/hospitals', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'hospitals']);
Route::get('/admin/ajax/departments', [\App\Http\Controllers\Admin\AjaxLocationController::class, 'departments']);

// AJAX route to get Ref Person number by ID (or name)
Route::get('/admin/ajax/ref-person-number', [\App\Http\Controllers\Admin\MadisonQuaryController::class, 'getRefPersonNumber']);

// View More route for Madison Quary
Route::get('/admin/madison-quary/view-more/{id}', [MadisonQuaryController::class, 'viewMore']);

// Online Booking view route (admin and user access via /admin/online-booking)
Route::get('/admin/online-booking', [OnlineBookingController::class, 'showForm'])->name('admin.online-booking');
Route::post('/admin/online-booking', [OnlineBookingController::class, 'store'])->name('admin.online-booking.store');
Route::get('/admin/booking-list', [OnlineBookingController::class, 'index'])->name('admin.booking-list');
Route::get('/admin/booking-view/{id}', [OnlineBookingController::class, 'view'])->name('admin.booking-view');
Route::post('/admin/booking-payment-update', [OnlineBookingController::class, 'paymentUpdate'])->name('admin.booking-payment-update');
Route::get('/admin/booking-payment-history/{id}', [OnlineBookingController::class, 'paymentHistory'])->name('admin.booking-payment-history');
Route::get('/admin/booking-list-excel', [OnlineBookingController::class, 'bookingListExcel'])->name('admin.booking-list-excel');

// Edit Booking
Route::get('/admin/booking-edit/{id}', [OnlineBookingController::class, 'edit'])->name('admin.booking-edit');
Route::post('/admin/booking-update/{id}', [OnlineBookingController::class, 'update'])->name('admin.booking-update');

// AJAX search routes (if not already present)
Route::get('/admin/ajax/hospital-search', [OnlineBookingController::class, 'searchHospitals'])->name('admin.ajax.hospital-search');
Route::get('/admin/ajax/department-search', [OnlineBookingController::class, 'searchDepartments'])->name('admin.ajax.department-search');
Route::get('/admin/ajax/states', [OnlineBookingController::class, 'searchStates']);
Route::get('/admin/ajax/cities', [OnlineBookingController::class, 'searchCities']);
Route::get('/admin/ajax/districts', [OnlineBookingController::class, 'searchDistricts']);