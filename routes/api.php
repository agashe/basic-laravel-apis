<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('projects', ProjectController::class)->except([
        'create', 'edit'
    ]);

    Route::resource('timesheets', TimesheetController::class)->except([
        'create', 'edit'
    ]);
});
