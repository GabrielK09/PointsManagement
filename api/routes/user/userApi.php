<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->group(function() {
    Route::post('/create', [AuthController::class, 'register']);

    Route::controller(UserController::class)->group(function() {
        Route::put('/update', 'update');
        Route::put('/update/goal', 'updateGoal');
    });
}); 