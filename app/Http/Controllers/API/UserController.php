<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return successResponse(200, 'success', 'User Detail', $user);
        }
        return errorResponse(404, 'error', 'User Tidak Ditemukan');
    }
}