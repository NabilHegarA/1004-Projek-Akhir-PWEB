<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LapakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;


// ================= LANDING =================
Route::get('/', [LandingController::class, 'index']);

Route::get('/lapak', [LapakController::class, 'landing']);

Route::get('/lapak/live-search', [LapakController::class, 'liveSearch']);

Route::get('/transaksi/live-search', [BookingController::class, 'liveSearch'])->name('transaksi.liveSearch');


// ================= ADMIN =================
Route::middleware(['auth', 'admin']) ->prefix('admin') ->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'adminProfile']);
    Route::get('/editprofil', [ProfileController::class, 'editAdmin']);
    Route::post('/editprofil', [ProfileController::class, 'update'])->name('admin.profile.update');

    // Lapak
    Route::get('/pengelolaan', [LapakController::class, 'admin']);
    Route::get('/tambahlapak', [LapakController::class, 'create']);
    Route::post('/tambahlapak', [LapakController::class, 'store']);
    Route::get('/editlapak/{id}', [LapakController::class, 'edit']);
    Route::post('/editlapak/{id}', [LapakController::class, 'update']);

    // Transaksi
    Route::get('/transaksiAdmin', [BookingController::class, 'transaksiAdmin']);
    Route::post('/booking/{id}/confirm', [BookingController::class, 'confirmBooking'])->name('booking.confirm');
    Route::post('/booking/{id}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::post('/booking/{id}/complete', [BookingController::class, 'completeBooking'])->name('booking.complete');
});


// ================= USER =================
Route::middleware(['auth', 'user']) ->prefix('user') ->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard']);

    // Profile
    Route::get('/profileUser', [ProfileController::class, 'userProfile']);
    Route::get('/edit-profileUser', [ProfileController::class, 'editUser']);
    Route::post('/edit-profileUser', [ProfileController::class, 'update'])->name('user.profile.update');

    // Lapak
    Route::get('/lapakUser', [LapakController::class, 'user'])->name('lapak.user');
    Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}/jam-terpakai', [BookingController::class, 'getAvailableJam']);

    // Transaksi
    Route::get('/transaksiUser', [BookingController::class, 'transaksiUser'])->name('user.transaksi');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
});


// ================= AUTH =================
require __DIR__ . '/auth.php';
