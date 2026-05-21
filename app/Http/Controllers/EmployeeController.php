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

        $password = $request->last_name . $request->govt_id;
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

    public function toggleStatus(Employee $employee) {
        $employee->update(['is_active' => !$employee->is_active]);
        $statusText = $employee->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User successfully {$statusText}.");
    }
}
