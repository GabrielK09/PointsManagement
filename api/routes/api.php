<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return apiSuccess('On');

});

Route::prefix('/v1')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::prefix('/auth')->group(function() {
            Route::post('/login', 'login');
            Route::post('/register', 'register');
            Route::post('/logout', 'logout');

        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        require_once __DIR__."/user/userApi.php";
        require_once __DIR__."/goal/goalApi.php";
    });
});
