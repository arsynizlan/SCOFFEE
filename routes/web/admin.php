<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\EducationController;

Route::prefix('p')->group(function () {
    Route::get('/education', [EducationController::class, 'index']);
    Route::post('/education', [EducationController::class, 'store']);
    Route::get('/education/{id}', [EducationController::class, 'show']);
    Route::post('/education/{id}', [EducationController::class, 'update']);
    Route::delete('/education/{id}', [EducationController::class, 'destroy']);
});