<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
    Route::get('/private/superadmin', [AuthController::class, 'superadmin'])->name('private.superadmin');
    Route::post('/employee/create', [EmployeeController::class, 'store'])->name('employee/create');
    Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::patch('/employee/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employee.toggle-status');

    Route::get('private/surveyor', [AuthController::class, 'surveyor'])->name('private.surveyor');
    Route::get('private/form', [AuthController::class, 'form'])->name('private.form');
    Route::post('surveyor/merge', [ClientController::class, 'mergeToCentralDatabase'])->name('surveyor.merge');
    Route::get('surveyor/dashboard', [AuthController::class, 'surveyorDashboard'])->name('private.surveyor-dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// API Routes for cascading dropdowns
Route::get('/api/regions', [LocationController::class, 'getRegions']);
Route::get('/api/provinces', [LocationController::class, 'getProvinces']);
Route::get('/api/districts', [LocationController::class, 'getDistricts']);
Route::get('/api/cities-municipalities', [LocationController::class, 'getCitiesMunicipalities']);
Route::get('/api/barangays', [LocationController::class, 'getBarangays']);
Route::get('/api/locations/all', [LocationController::class, 'getAllLocations']);
Route::get('/api/locations/by-district', [LocationController::class, 'getLocationsByDistrict']);
Route::get('/api/clients', [ClientController::class, 'getByBarangay']);