<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\UserController;





Route::group([], function () {
    /** Login and Register */
    require __DIR__ . '/api/auth.php';

    /** Get All Event */
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    /** User Detail */
    Route::get('/user/{id}', [UserController::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        /** Logout */
        Route::get('/logout', [AuthController::class, 'logout']);

        /** Admin dan Praktisi */
        Route::group(['middleware' => ['role:Admin|Praktisi']], function () {
            /**  Events */
            Route::post('/events', [EventController::class, 'store']);
            Route::put('/events/{id}', [EventController::class, 'update']);
            Route::delete('/events/{id}', [EventController::class, 'destroy']);
        });
    });
});