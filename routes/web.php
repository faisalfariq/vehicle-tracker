<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingLogController;
use App\Http\Controllers\BookingApprovalController;
use App\Http\Controllers\FuelLogController;
use App\Http\Controllers\ServiceLogController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AppLogController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;

// Guest routes (no authentication required)
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes (guest middleware)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Protected routes (authentication required)
Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout routes (both GET and POST)
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('logout', [LoginController::class, 'logout']);

    // Routes available for all authenticated users
Route::post('bookings/{id}', [BookingController::class, 'update']);
Route::post('bookings/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::post('bookings/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
Route::post('bookings/{id}/submit', [BookingController::class, 'submit'])->name('bookings.submit');
Route::post('bookings/{id}/used', [BookingController::class, 'used'])->name('bookings.used');
Route::post('bookings/{id}/finish', [BookingController::class, 'finish'])->name('bookings.finish');

    // Bookings - Available for all authenticated users
    Route::resources([
        'bookings' => BookingController::class,
    ]);

    // Booking Approvals - Available for admin and approver only
    Route::middleware('approver')->group(function () {
        Route::post('booking-approvals/{id}', [BookingApprovalController::class, 'update']); 
        Route::resources([
            'booking-approvals' => BookingApprovalController::class,
        ]);
    });

    // Admin only routes
    Route::middleware('admin')->group(function () {
Route::post('users/{id}', [UserController::class, 'update']);
Route::post('roles/{id}', [RoleController::class, 'update']);
Route::post('regions/{id}', [RegionController::class, 'update']);
Route::post('vehicle-types/{id}', [VehicleTypeController::class, 'update']);
Route::post('vehicles/{id}', [VehicleController::class, 'update']);
Route::post('drivers/{id}', [DriverController::class, 'update']);
Route::post('booking-logs/{id}', [BookingLogController::class, 'update']);
Route::post('fuel-logs/{id}', [FuelLogController::class, 'update']);
Route::post('service-logs/{id}', [ServiceLogController::class, 'update']);
Route::post('documents/{id}', [DocumentController::class, 'update']);
Route::post('app-logs/{id}', [AppLogController::class, 'update']);
Route::post('settings/{id}', [SettingController::class, 'update']);

Route::resources([
    'users' => UserController::class,
    'roles' => RoleController::class,
    'regions' => RegionController::class,
    'vehicle-types' => VehicleTypeController::class,
    'vehicles' => VehicleController::class,
    'drivers' => DriverController::class,
    'booking-logs' => BookingLogController::class,
    'fuel-logs' => FuelLogController::class,
    'service-logs' => ServiceLogController::class,
    'documents' => DocumentController::class,
    'app-logs' => AppLogController::class,
    'settings' => SettingController::class,
]);
    });

    // Report Bookings
    Route::get('reports/bookings', [ReportController::class, 'bookings'])->name('reports.bookings');
    Route::get('reports/bookings/export', [ReportController::class, 'exportBookings'])->name('reports.bookings.export');
});