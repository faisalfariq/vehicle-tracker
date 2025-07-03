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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('bookings/{id}', [BookingController::class, 'update']);
Route::post('users/{id}', [UserController::class, 'update']);
Route::post('roles/{id}', [RoleController::class, 'update']);
Route::post('regions/{id}', [RegionController::class, 'update']);
Route::post('vehicle-types/{id}', [VehicleTypeController::class, 'update']);
Route::post('vehicles/{id}', [VehicleController::class, 'update']);
Route::post('drivers/{id}', [DriverController::class, 'update']);
Route::post('booking-logs/{id}', [BookingLogController::class, 'update']);
Route::post('booking-approvals/{id}', [BookingApprovalController::class, 'update']); 
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
    'bookings' => BookingController::class,
    'booking-logs' => BookingLogController::class,
    'booking-approvals' => BookingApprovalController::class,
    'fuel-logs' => FuelLogController::class,
    'service-logs' => ServiceLogController::class,
    'documents' => DocumentController::class,
    'app-logs' => AppLogController::class,
    'settings' => SettingController::class,
]);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');