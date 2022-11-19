<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CommentController;

// Route::get('/category', [CommentController::class, 'index']);
Route::get('/comment/{id}', [CommentController::class, 'show']);
// Route::get('/forum/{id}/', [CommentController::class, 'show']);
Route::post('/comment', [CommentController::class, 'store']);
Route::post('/comment', [CommentController::class, 'update']);
Route::delete('/comment/{comment}', [CommentController::class, 'destroy']);
