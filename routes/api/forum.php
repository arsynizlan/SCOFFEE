<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ForumController;

Route::get('/posting', [ForumController::class, 'index']);
Route::get('/posting/{id}', [ForumController::class, 'show']);
Route::post('/posting', [ForumController::class, 'store']);
Route::post('/posting/{id}', [ForumController::class, 'update']);
Route::delete('/posting/{id}', [ForumController::class, 'destroy']);
Route::get('/posting/{id}/comment', [ForumController::class, 'forumComment']);
// Route::get('/category/{category}/relationships/posting', [ForumController::class, 'groupCategory']);
// Route::get('/postings', [ForumController::class, 'groupCategory']);
