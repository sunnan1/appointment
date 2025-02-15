<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index() {
        return view('login');
    }

    public function submitLogin(Request $request) {
        if (! ($request->filled('email') && $request->filled('password'))) {
            return redirect()->back()->withErrors('All Fields must be entered');
        }
        $user = User::whereEmail($request->email)->first();
        if (! $user) {
            return redirect()->back()->withErrors('Email doesn\'t exist');
        }
        if (Hash::check($request->password , $user->password)) {
            Auth::login($user);
            return redirect()->intended('/');
        }
        return redirect()->back()->withErrors('Invalid Credentials');
    }
}
