<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {

            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function actionlogin(Request $request)
    {
        $credentials  = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect()->route('login');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
