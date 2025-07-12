<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugsController extends Controller
{


    public function getAllDrugs()
    {
        $drugs = Drug::all();

        $data =[
            'drugs'=> $drugs
        ];

        return response()->json($data);
    }
}
