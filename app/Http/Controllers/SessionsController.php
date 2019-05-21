<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    public function create() {
        $var = ['title' => 'Login', 'loggedin' => false];
        return view('login', ['title' => 'Login', 'loggedin' => false]);
    }

    public function store() {
        if(!auth()->attempt(request(['username','password']))) {
            return redirect()->back()->withErrors('Username or password is incorrect.');
        }

        if(auth()->user()->isSuspended == true) {
            auth()->logout();
            return redirect('/login')->with('message', ['Suspended', 'This account is currently suspended and may not be used to log in.']);
        }

        return redirect("/" . auth()->user()->role . "/home")->with('message', ['Login Success', 'You have been logged in successfully!']);
    }

    public function destroy() {
        auth()->logout();
        return redirect('/login')->with('message', ['Logout Success', 'You have been logged out successfully!']);
    }
}
