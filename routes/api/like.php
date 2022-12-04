<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LikeController;

Route::post('/posting/{id}/likes', [LikeController::class, 'likeOrUnlike']);