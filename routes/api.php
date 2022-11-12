<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;




Route::group([], function () {
    /** Login and Register */
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    /** Get All Event */
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        /** Logout */
        Route::get('/logout', [AuthController::class, 'logout']);

        Route::group(['middleware' => ['role:Admin|Praktisi']], function () {
            /** Create Events */
            Route::post('/events', [EventController::class, 'store']);
            /** Delete Events */
            Route::delete('/events/{id}', [EventController::class, 'destroy']);
        });
    });
});