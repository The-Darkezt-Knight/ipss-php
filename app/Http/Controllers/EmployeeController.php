<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

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
            'city_municipality' => 'required',
            'province' => 'required',
            'region' => 'required',
            'sex' => 'required',
            'role'=>'required'
        ]);

        $password = strtolower($request->last_name . '.' . $request->govt_id);
        $is_active = true;
        $hashed_password = Hash::make($password);


        $employee = Employee::create([
            'govt_id' =>                $request->govt_id,
            'govt_email' =>             $request->govt_email,
            'first_name' =>             $request->first_name,
            'middle_name' =>            $request->middle_name,
            'last_name' =>              $request->last_name,
            'birth_date' =>             $request->birth_date,
            'city_municipality' =>      $request->city_municipality,
            'province' =>               $request->province,
            'region' =>                 $request->region,
            'sex' =>                    $request->sex,
            'role'=>                    $request->role,
            'password' =>               $hashed_password,
            'is_active' =>              $is_active
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }
}
