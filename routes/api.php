<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EventController;

Route::group([], function () {
    /** Login and Register */
    require __DIR__ . '/api/auth.php';

    /** Get All Event */
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        /** Logout */
        Route::get('/logout', [AuthController::class, 'logout']);

        /** User Detail */
        Route::get('/user/{id}', [UserController::class, 'show']);

        /** Edit User */
        Route::put('/user/{id}', [UserController::class, 'update']);

        /** Super Admin ONLY*/
        Route::group(['middleware' => ['role:SuperAdmin']], function () {
            Route::get('/users', [UserController::class, 'getUser']);
            Route::get('/admin', [UserController::class, 'getAdmin']);
            Route::post('/admin', [UserController::class, 'store']);
            Route::get('/category', [CategoryController::class, 'index']);
            Route::post('/category', [CategoryController::class, 'store']);
            Route::get('/category/{id}', [CategoryController::class, 'show']);
            Route::post('/category/{id}', [CategoryController::class, 'update']);
            Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
            Route::delete('/user/{id}', [UserController::class, 'destroy']);
            Route::delete('/user/permanent/{id}', [UserController::class, 'destroyPermanent']);
        });
        /** SuperAdmin dan Admin */
        Route::group(['middleware' => ['role:Admin|SuperAdmin']], function () {
            /**  Events */
            Route::post('/events', [EventController::class, 'store']);
            Route::put('/events/{id}', [EventController::class, 'update']);
            Route::delete('/events/{id}', [EventController::class, 'destroy']);
        });
    });
});
