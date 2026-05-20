<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;

class AuthController
{
    //returns the index page
    public function index() {
        return view('index');
    }

    //validates the input, handles login request, and redirects the employee based on their role
    public function handleLogin(Request $request) {

        $credentials = $request->validate([
            'govt_email'=>'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['govt_email' => $credentials['govt_email'], 'password' => $credentials['password']])) {
            $request -> session() -> regenerate();

            $employee = Auth::user();

            if($employee->role === 'ADMIN') {
                return redirect()->route('admin');
            }
            if($employee->role === 'SUPERADMIN') {
                return redirect()->route('private.superadmin');
            }
            /*
            if($employee->role === 'DIRECTOR') {
                return redirect()->route('');
            }

            if($employee->role === 'SURVEYOR') {
                return redirect()->route('');
            }
            */
        }

        return back()->withErrors([
            'govt_email' => 'Government email doesn\'t match with our system'
        ])->onlyInput('govt_email');
    }
}
