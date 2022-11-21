<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});



Route::group([], function () {

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth', 'role:SuperAdmin|Admin']], function () {
        route::get('/dashboard', function () {
            return view('dashboard');
        });

        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{id}', [EventController::class, 'show']);
        Route::post('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});