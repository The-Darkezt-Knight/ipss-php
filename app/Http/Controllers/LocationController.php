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

    /**
     * Returns all location data (regions, provinces, cities, barangays) in a single
     * response so it can be pre-cached in IndexedDB for offline dropdown support.
     */
    public function getAllLocations()
    {
        return response()->json([
            'regions'    => DB::table('region')->orderBy('name')->get(['code', 'name']),
            'provinces'  => DB::table('province')->orderBy('name')->get(['code', 'name', 'region_code']),
            'cities'     => DB::table('city_municipality')->orderBy('name')->get(['code', 'name', 'province_code']),
            'barangays'  => DB::table('barangay')->orderBy('name')->get(['code', 'name', 'city_municipality_code']),
        ]);
    }
}
