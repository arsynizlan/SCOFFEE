<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login/index');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $Validator = Validator::make($request->all(), $rules);

        if ($Validator->fails()) {
            return redirect()->back()->withErrors($Validator)->withInput($request->all);
        }
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        Auth::attempt($data);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('User')) {
                Auth::logout();
                return redirect('/login')->with('loginError', 'Anda tidak memiliki akses!');
            }
            return redirect()->to('/dashboard');
        }

        return back()->with('loginError', 'Email atau Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->to('/login');
    }
}