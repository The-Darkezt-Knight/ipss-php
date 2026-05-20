<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employee')->insert([
            'govt_id' => '123456',
            'govt_email' => 'pido@deped.gov.ph',
            'first_name' => 'Jose Raphael',
            'middle_name' => 'Jacob',
            'last_name' => 'Pido',
            'age' => 21,
            'birth_date' => '2004-11-04',
            'baranggay'=> 'Bata',
            'city_municipality' => 'City of Bacolod',
            'province' => 'Negros Occidental',
            'region' => 'Western Visayas',
            'sex' => 'Male',
            'password' => Hash::make('pido.231654289'),
            'is_active' => true,
            'role' => 'SUPERADMIN'
        ]);
    }
}
