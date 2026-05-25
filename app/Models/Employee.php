<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $table = 'employee';

    protected $fillable = [
        'govt_id',
        'govt_email',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'birth_date',
        'barangay',
        'city_municipality',
        'province',
        'region',
        'district',
        'district_code',
        'sex',
        'password',
        'is_active',
        'role'
    ];

    protected $hidden = [
        'password'
    ];
}
