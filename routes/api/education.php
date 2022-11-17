<?php

use App\Http\Controllers\API\EducationController;
use Illuminate\Support\Facades\Route;

Route::post('/education', [EducationController::class, 'store']);