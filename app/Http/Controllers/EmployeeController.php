<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Routing\Controller;

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
            'password' => 'required',
            'is_active' => 'required',
            'role'=>'required'
        ]);

        $employee = Employee::create($validated);

        //return redirect()->route('');
    }
}
