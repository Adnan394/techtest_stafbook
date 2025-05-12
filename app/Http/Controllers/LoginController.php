<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index() {
        return view('welcome');
    }
    public function login(Request $request) {
        $validation = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validation)) {
            // dd($validation);
            return back()->withErrors([
                'email' => 'Email atau password salah'
            ])->onlyInput('email');
        }
        
        return redirect()->route('dashboard');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}