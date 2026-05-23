<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController
{
    public function getRegions()
    {
        return response()->json(DB::table('region')->orderBy('name')->get(['code', 'name']));
    }

    public function getProvinces(Request $request)
    {
        $regionCode = $request->query('region_code');
        if (!$regionCode) {
            return response()->json([]);
        }
        return response()->json(DB::table('province')->where('region_code', $regionCode)->orderBy('name')->get(['code', 'name']));
    }

    public function getCities(Request $request)
    {
        $provinceCode = $request->query('province_code');
        if (!$provinceCode) {
            return response()->json([]);
        }
        return response()->json(DB::table('city_municipality')->where('province_code', $provinceCode)->orderBy('name')->get(['code', 'name']));
    }

    public function getBarangays(Request $request)
    {
        $cityCode = $request->query('city_municipality_code') ?? $request->query('barangay_code');
        if (!$cityCode) {
            return response()->json([]);
        }

        return response()->json(
            DB::table('barangay')
                ->where(function ($query) use ($cityCode) {
                    $query->where('city_municipality_code', $cityCode)
                        ->orWhereNull('city_municipality_code')
                        ->whereRaw("LEFT(code, 6) = LEFT(?, 6)", [$cityCode]);
                })
                ->orderBy('name')
                ->get(['code', 'name'])
        );
    }
}
