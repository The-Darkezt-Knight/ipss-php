<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function store(Request $request) {

        $validated = $request->validate([
            'govt_id' => 'required|unique:employee',
            'govt_email' => 'required|unique:employee',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'birth_date' => 'required',
            'barangay' => 'required',
            'city_municipality' => 'required',
            'province' => 'required',
            'region' => 'required',
            'sex' => 'required',
            'role'=>'required'
        ]);
        
        
        $password = strtolower($validated['last_name'] .'.'. $validated['govt_id']);
        $is_active = true;
        $hashed_password = Hash::make($password);
        $age = Carbon::parse($validated['birth_date'])->age;


        $employee = Employee::create([
            'govt_id' =>                $validated['govt_id'],
            'govt_email' =>             $validated['govt_email'],
            'first_name' =>             $validated['first_name'],
            'middle_name' =>            $validated['middle_name'],
            'last_name' =>              $validated['last_name'],
            'birth_date' =>             $validated['birth_date'],
            'barangay' =>               $validated['barangay'],
            'city_municipality' =>      $validated['city_municipality'],
            'province' =>               $validated['province'],
            'region' =>                 $validated['region'],
            'sex' =>                    $validated['sex'],
            'age' =>                    $age,
            'role'=>                    $validated['role'],
            'password' =>               $hashed_password,
            'is_active' =>              $is_active
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }
}
