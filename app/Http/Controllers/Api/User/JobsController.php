<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobsController extends Controller
{


    public function getAllJobs()
    {
        $jobs = JobOffer::with([
            'city:id,name,country_id',
            'city.country:id,name',
            'zone:id,name,city_id',
            'company:id,name,email,phone',
            'jobCategory:id,name',
            'jobTitel:id,name',
        ])
        ->get();


        $data =[
            'jobs'=> $jobs
        ];

        return response()->json($data);
    }
}
