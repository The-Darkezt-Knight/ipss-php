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

    public function update(Request $request, Employee $employee) {
        $validated = $request->validate([
            'govt_id' => 'required|unique:employee,govt_id,' . $employee->id,
            'govt_email' => 'required|email|unique:employee,govt_email,' . $employee->id,
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

        $employee->update([
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
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
