<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CommentController;

// Route::get('/category', [CommentController::class, 'index']);
Route::get('/comment/{id}', [CommentController::class, 'show']);
// Route::get('/categories', [CommentController::class, 'counts']);
Route::post('/comment', [CommentController::class, 'store']);
Route::post('/comment/{id}', [CommentController::class, 'update']);
Route::delete('/comment/{id}', [CommentController::class, 'destroy']);
