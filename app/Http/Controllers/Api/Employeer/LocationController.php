<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Zone;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function getActiveCities()
    {
        $cities = City::where('status', 'active')->get();

        $data =[
            'cities'=> $cities
        ];
        return response()->json($data);
    }

    public function getActiveZones()
    {
        $zones = Zone::where('status', 'active')->get();

        $data =[
            'zones'=> $zones
        ];
        return response()->json($data);
    }
}
