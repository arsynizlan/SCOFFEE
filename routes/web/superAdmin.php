<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\EventController;
use App\Http\Controllers\WEB\CoffeeController;
use App\Http\Controllers\WEB\CategoryController;
use App\Http\Controllers\WEB\PersonalEventController;

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events/{id}', [EventController::class, 'update']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::post('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/coffee', [CoffeeController::class, 'index']);
Route::get('/coffee/{id}', [CoffeeController::class, 'show']);
Route::post('/coffee', [CoffeeController::class, 'store']);
Route::post('/coffee/{id}', [CoffeeController::class, 'update']);
Route::delete('/coffee/{id}', [CoffeeController::class, 'destroy']);