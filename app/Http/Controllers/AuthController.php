<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
class AuthController extends Controller
{
    //returns the index page

    //validates the input, handles login request, and redirects the employee based on their role
    public function handleLogin(Request $request) {
        $credentials = $request->validate([
            'govt_email'=>'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['govt_email' => $credentials['govt_email'], 'password' => $credentials['password']])) {
            $request -> session() -> regenerate();

            $employee = Auth::user();

            if($employee->role === 'ROLE_ADMIN') {
                return redirect()->route('admin');
            }
            if($employee->role === 'ROLE_SUPERADMIN') {
                return redirect()->route('private.superadmin');
            }
            if($employee->role === 'ROLE_SURVEYOR') {
                return redirect()->route('private.surveyor');
            }

            return response()->json([
                'user' => [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'role' => $employee->role,
                ]
            ]);
        }

        return back()->withErrors([
            'govt_email' => 'Invalid email or password'
        ])->onlyInput('govt_email');
    }

    public function index() {
        return view('index');
    }

    public function superadmin() {
        $employees = \App\Models\Employee::all();
        return view('private.superadmin', compact('employees'));
    }

    public function surveyor() {
        $employee = Auth::user();
        return view('private.surveyor', compact('employee'));
    }

    public function form() {
        $employee = Auth::user();
        return view('private.form', compact('employee'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
