<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───────────────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'));

// ─── Auth Routes ─────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Owners / Land Holders
    Route::resource('owners', OwnerController::class);
    Route::get('owners/{owner}/properties', [OwnerController::class, 'properties'])->name('owners.properties');

    // Properties / Land Parcels
    Route::resource('properties', PropertyController::class);
    Route::get('properties/{property}/history', [PropertyController::class, 'history'])->name('properties.history');
    Route::get('properties/{property}/certificate', [PropertyController::class, 'certificate'])->name('properties.certificate');

    // Registrations
    Route::resource('registrations', RegistrationController::class);
    Route::patch('registrations/{registration}/approve',  [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::patch('registrations/{registration}/reject',   [RegistrationController::class, 'reject'])->name('registrations.reject');
    Route::get('registrations/{registration}/receipt',    [RegistrationController::class, 'receipt'])->name('registrations.receipt');

    // Transfers
    Route::resource('transfers', TransferController::class);
    Route::patch('transfers/{transfer}/approve',  [TransferController::class, 'approve'])->name('transfers.approve');
    Route::patch('transfers/{transfer}/reject',   [TransferController::class, 'reject'])->name('transfers.reject');

    // Reports (Admin only)
    Route::middleware('role:admin')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/',               [ReportController::class, 'index'])->name('index');
        Route::get('/registrations',  [ReportController::class, 'registrations'])->name('registrations');
        Route::get('/properties',     [ReportController::class, 'properties'])->name('properties');
        Route::get('/owners',         [ReportController::class, 'owners'])->name('owners');
        Route::get('/pdf/{type}',     [ReportController::class, 'pdf'])->name('pdf');
    });

    // User Management (Admin only)
    Route::middleware('role:admin')->resource('users', UserController::class);
});
