<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\Admin\EducationController;
use App\Http\Controllers\WEB\Admin\EventController;

Route::prefix('p')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    Route::get('/education', [EducationController::class, 'index']);
    Route::post('/education', [EducationController::class, 'store']);
    Route::get('/education/{id}', [EducationController::class, 'show']);
    Route::post('/education/{id}', [EducationController::class, 'update']);
    Route::delete('/education/{id}', [EducationController::class, 'destroy']);
});
