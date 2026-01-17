<?php

use App\Http\Controllers\Goal\GoalController;
use Illuminate\Support\Facades\Route;

Route::prefix('/goal')->group(function() {
    Route::controller(GoalController::class)->group(function() {
        Route::put('/update/goal/{goal}', 'updateGoal');
    });
});
