<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayGroundController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/play-grounds/{id}/available-hours', [PlayGroundController::class, 'availableHours']);use App\Http\Controllers\Api\PlayGroundController;

