<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugsController extends Controller
{


    public function getAllDrugs()
    {
        $drugs = Drug::with([
            'drugCategory:id,name',
            'company:id,name',
        ])->get();

        $data =[
            'drugs'=> $drugs
        ];

        return response()->json($data);
    }
}
