<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $request->validated();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new ApiResource(true, 'Berhasil Register', 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt(
            $request->only('email', 'password')
        )) {
            return new ApiResource(false, 'Password atau Email Salah!', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth-sanctum')->plainTextToken;

        $data = [
            'token' => $token,
        ];

        return new ApiResource(true, 'Berhasil Login', $data);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return new ApiResource(true, 'Berhasil Logout', null);
    }
}