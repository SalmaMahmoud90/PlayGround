<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\PlaygroundController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Cities
    Route::resource('cities', CityController::class);
    
    // Zones
    Route::resource('zones', ZoneController::class);
    
    // Owners
    Route::resource('owners', OwnerController::class);
    
    // Playgrounds
    Route::resource('playgrounds', PlaygroundController::class);
    
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    
    // Coupons
    Route::resource('coupons', CouponController::class);
    
    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
});


// Owner Routes (برا الـ Admin Group)
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {    
    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';