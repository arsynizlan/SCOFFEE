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

        require __DIR__ . '/web/superAdmin.php';
        require __DIR__ . '/web/admin.php';


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
