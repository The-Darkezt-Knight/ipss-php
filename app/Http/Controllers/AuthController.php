<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController
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

            if($employee->role === 'ADMIN') {
                return redirect()->route('admin');
            }
            if($employee->role === 'SUPERADMIN') {
                return redirect()->route('private.superadmin');
            }
        }

        return back()->withErrors([
            'govt_email' => 'Government email doesn\'t match with our system'
        ])->onlyInput('govt_email');
    }

    public function index() {
        return view('index');
    }

    public function superadmin(Request $request) {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('govt_email', 'like', "%{$search}%")
                  ->orWhere('govt_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $employees = $query->get();

        return view('private.superadmin', compact('employees'));
    }

    public function createEmployee(Request $request) {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'sex' => 'required|string|in:Male,Female',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'govEmail' => 'required|email|unique:employee,govt_email',
            'govId' => 'required|string|unique:employee,govt_id',
            'role' => 'required|string'
        ]);

        try {
            $birthDate = Carbon::parse($validated['birthdate']);
            $age = $birthDate->age;

            $role = str_replace('ROLE_', '', $validated['role']);

            Employee::create([
                'first_name' => $validated['firstName'],
                'middle_name' => $validated['middleName'],
                'last_name' => $validated['lastName'],
                'birth_date' => $validated['birthdate'],
                'age' => $age,
                'sex' => $validated['sex'],
                'baranggay' => $validated['barangay'],
                'city_municipality' => $validated['city'],
                'province' => $validated['province'],
                'region' => 'N/A', // Update as needed or add to form
                'govt_email' => $validated['govEmail'],
                'govt_id' => $validated['govId'],
                'password' => Hash::make($validated['govId']), // Default password is the ID
                'role' => $role,
                'is_active' => true
            ]);

            return redirect()->route('private.superadmin')->with('success', 'User successfully created!');
        } catch (\Exception $e) {
            return redirect()->route('private.superadmin')->with('error', 'Failed to create user. Please try again.');
        }
    }
}
