<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $request->validated();

        $rules = [
            'name'     => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])->assignRole('User')->user_detail()->create();


            $data = User::where('id', $user->id)->first();

            return successResponse(201, 'success', 'Berhasil register', $data);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
        }
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
            return errorResponse(400, 'error', 'Email atau Password Salah!');
        }

        $user = User::select('id', 'name', 'email')->where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth-sanctum')->plainTextToken;

        $role = Auth::user()->getRoleNames()[0];
        $data = [
            'token' => $token,
            'user' => $user,
            'role' => $role
        ];

        return successResponse(200, 'success', 'Berhasil login', $data);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return successResponse(200, 'success', 'Berhasil logout', null);
    }
}