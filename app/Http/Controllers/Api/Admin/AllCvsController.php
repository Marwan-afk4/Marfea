<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserCv;
use Illuminate\Http\Request;

class AllCvsController extends Controller
{


    public function getAllCv()
    {
        $allCvs = UserCv::with('user:id,first_name,last_name,email,phone,age,image')->get();

        $data =[
            'cvs'=> $allCvs
        ];
        return response()->json($data);
    }
}
