<?php

use App\Http\Controllers\API\CoffeeController;
use Illuminate\Support\Facades\Route;

Route::post('/coffee', [CoffeeController::class, 'store']);
Route::post('/coffee/{id}', [CoffeeController::class, 'update']);
Route::delete('/coffee/{id}', [CoffeeController::class, 'destroy']);