<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('bookings', BookingController::class);

    Route::apiResource('reviews', ReviewController::class);
    Route::post('/bookings/{booking}/pay', [BookingController::class, 'pay']);

    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{play_ground_id}', [FavoriteController::class, 'destroy']);
});