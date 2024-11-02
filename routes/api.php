<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('projects', ProjectController::class)->except([
        'create', 'edit'
    ]);

    Route::get('projects/{id}/users', [ProjectController::class, 'users']);
    Route::get('projects/{id}/time-sheets', [ProjectController::class, 'timesheets']);

    Route::resource('users', UserController::class)->except([
        'create', 'edit'
    ]);

    Route::get('users/{id}/projects', [UserController::class, 'projects']);
    Route::get('users/{id}/time-sheets', [UserController::class, 'timesheets']);

    Route::resource('timesheets', TimesheetController::class)->except([
        'create', 'edit'
    ]);
});
