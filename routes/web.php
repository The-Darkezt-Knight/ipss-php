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
    Route::get('/admin/surveyor-locations', [AuthController::class, 'surveyorLocationsApi'])->name('admin.surveyor-locations');
    Route::get('/admin/client-locations', [AuthController::class, 'clientLocationsApi'])->name('admin.client-locations');
    Route::get('/admin/verified-client-locations', [AuthController::class, 'verifiedClientLocationsApi'])->name('admin.verified-client-locations');
    Route::get('/private/superadmin', [AuthController::class, 'superadmin'])->name('private.superadmin');
    Route::post('/employee/create', [EmployeeController::class, 'store'])->name('employee/create');
    Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::patch('/employee/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employee.toggle-status');

    Route::get('private/surveyor', [AuthController::class, 'surveyor'])->name('private.surveyor');
    Route::get('private/form', [AuthController::class, 'form'])->name('private.form');
    Route::post('surveyor/merge', [ClientController::class, 'mergeToCentralDatabase'])->name('surveyor.merge');
    Route::patch('surveyor/clients/{client}/returned', [ClientController::class, 'updateReturnedForSurveyor'])->name('surveyor.clients.update-returned');
    Route::post('surveyor/clients/{client}/send-back', [ClientController::class, 'sendBackReturnedSurvey'])->name('surveyor.clients.send-back');
    Route::patch('admin/clients/{client}/survey-status', [ClientController::class, 'updateSurveyStatus'])->name('admin.clients.survey-status');
    Route::delete('admin/clients/{client}/rejected', [ClientController::class, 'destroyRejected'])->name('admin.clients.destroy-rejected');
    Route::get('surveyor/dashboard', [ClientController::class, 'surveyorDashboard'])->name('private.surveyor-dashboard');
    Route::get('surveyor/clients/{client}', [ClientController::class, 'showForSurveyor'])->name('surveyor.clients.show');
    Route::get('/api/clients/identity-list', [ClientController::class, 'identityListByBarangay']);
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
