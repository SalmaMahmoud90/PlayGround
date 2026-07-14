<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PlayGroundController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (No authentication required)
Route::get('/playgrounds', [PlayGroundController::class, 'index']);
Route::get('/playgrounds/{playGround}', [PlayGroundController::class, 'show']);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Coupon public routes
Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);
Route::get('/coupons/active', [CouponController::class, 'getActiveCoupons']);

// Protected routes (Requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // PlayGrounds
    Route::get('/playgrounds', [PlayGroundController::class, 'index']);
    Route::get('/playgrounds/{playGround}', [PlayGroundController::class, 'show']);
    Route::post('/playgrounds', [PlayGroundController::class, 'store']);
    Route::put('/playgrounds/{playGround}', [PlayGroundController::class, 'update']);
    Route::delete('/playgrounds/{playGround}', [PlayGroundController::class, 'destroy']);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::put('/bookings/{booking}', [BookingController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/reviews/{review}', [ReviewController::class, 'show']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy']);
    Route::delete('/favorites/playground/{playGround}', [FavoriteController::class, 'destroyByPlayground']);

    // Coupons (Admin only)
    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->middleware('admin');
        Route::post('/', [CouponController::class, 'store'])->middleware('admin');
        Route::put('/{coupon}', [CouponController::class, 'update'])->middleware('admin');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->middleware('admin');
        Route::post('/bulk-delete', [CouponController::class, 'bulkDelete'])->middleware('admin');
        Route::patch('/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->middleware('admin');
        Route::get('/statistics', [CouponController::class, 'getStatistics'])->middleware('admin');
        Route::get('/{coupon}', [CouponController::class, 'show']);
    });
});