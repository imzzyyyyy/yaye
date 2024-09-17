<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login.form');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('projectt.dashboard.page');
    
    // User management routes
    Route::get('/users', [UserController::class, 'index'])->name('management.users');
    Route::post('/users', [UserController::class, 'store'])->name('management.users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('management.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('management.users.destroy');

    // Technicians routes (resource controller)
    Route::resource('technicians', TechnicianController::class);

    // Department routes (resource controller)
    Route::resource('departments', DepartmentController::class);

    // Building routes (resource controller)
    Route::resource('buildings', BuildingController::class);

    // Facility routes (resource controller)
    Route::resource('facilities', FacilityController::class);

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
});
