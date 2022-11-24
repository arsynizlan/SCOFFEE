<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\PersonalEventController;

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

    Route::get('/login', [AuthController::class, 'index'])
        ->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth', 'role:SuperAdmin|Admin']], function () {
        require __DIR__ . '/web/dashboard.php';
        Route::prefix('p')->group(function () {
            Route::get('/events', [PersonalEventController::class, 'index']);
            Route::get('/events/{id}', [PersonalEventController::class, 'show']);
            Route::post('/events', [PersonalEventController::class, 'store']);
            Route::post('/events/{id}', [PersonalEventController::class, 'update']);
            Route::delete('/events/{id}', [PersonalEventController::class, 'destroy']);
        });
        Route::group(['middleware' => ['role:SuperAdmin']], function () {
            require __DIR__ . '/web/superAdmin.php';
        });
        Route::group(['middleware' => ['role:Admin']], function () {
            require __DIR__ . '/web/admin.php';
        });


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});