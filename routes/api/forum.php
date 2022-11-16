<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ForumController;

Route::get('/posting', [ForumController::class, 'index']);
Route::get('/posting/{id}', [ForumController::class, 'show']);
// Route::get('/categories', [ForumController::class, 'counts']);
Route::post('/posting', [ForumController::class, 'store']);
Route::post('/posting/{id}', [ForumController::class, 'update']);
Route::delete('/posting/{id}', [ForumController::class, 'destroy']);
