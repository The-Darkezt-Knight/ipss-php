<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
    Route::get('/private/superadmin', [AuthController::class, 'superadmin'])->name('private.superadmin');
    Route::post('/employee/create', [EmployeeController::class, 'store'])->name('employee/create');
}); 