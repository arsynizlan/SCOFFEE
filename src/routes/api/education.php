<?php

use App\Http\Controllers\API\EducationController;
use Illuminate\Support\Facades\Route;

Route::post('/education', [EducationController::class, 'store']);
Route::post('/education/{id}', [EducationController::class, 'update']);
Route::delete('/education/{id}', [EducationController::class, 'destroy']);