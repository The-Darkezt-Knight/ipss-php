<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::Class, 'index'])->name('index');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'handleLogin']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
    Route::get('/private/superadmin', [AuthController::class, 'superadmin'])->name('private.superadmin');
    Route::post('/private/superadmin/create', [AuthController::class, 'createEmployee'])->name('private.superadmin.create');
});