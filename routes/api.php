<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EducationController;

Route::group([], function () {
    /** Login and Register */
    require __DIR__ . '/api/auth.php';

    /** Get All Event */
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    /** Get All Education */
    Route::get('/education', [EducationController::class, 'index']);
    Route::get('/education/{id}', [EducationController::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        /** Logout */
        Route::get('/logout', [AuthController::class, 'logout']);

        /** User Detail */
        Route::get('/user/{id}', [UserController::class, 'show']);

        /** Edit User */
        Route::put('/user/{id}', [UserController::class, 'update']);

        require __DIR__ . '/api/forum.php';
        require __DIR__ . '/api/comment.php';

        Route::group(['middleware' => ['role:Admin']], function () {
            require __DIR__ . '/api/education.php';
        });

        /** Super Admin ONLY*/
        Route::group(['middleware' => ['role:SuperAdmin']], function () {
            require __DIR__ . '/api/category.php';

            Route::get('/listevents', [EventController::class, 'Events']);
            Route::get('/users', [UserController::class, 'getUser']);
            Route::get('/admin', [UserController::class, 'getAdmin']);
            Route::post('/admin', [UserController::class, 'store']);
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