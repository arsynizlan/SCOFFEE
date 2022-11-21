<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;

Route::post('/category', [CategoryController::class, 'store']);
Route::post('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);