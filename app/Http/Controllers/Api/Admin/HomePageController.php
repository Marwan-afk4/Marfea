<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\Request;

class HomePageController extends Controller
{


    public function homePage()
    {
        $totalActiveJobs = JobOffer::where('status', 'active')->count();

        $totalUsers = User::where('role', 'user')
        ->where('status','!=','deleted')
        ->count();

        $totalCompanies = Company::all()->count();

        $totalPendingEmployeerRequests = User::where('role', 'employeer')
        ->where('status', 'pending')
        ->with('companies')
        ->count();

        $data =[
            'totalActiveJobs'=> $totalActiveJobs,
            'totalUsers'=> $totalUsers,
            'totalCompanies'=> $totalCompanies,
            'totalPendingEmployeerRequests'=> $totalPendingEmployeerRequests
        ];

        return response()->json($data);
    }
}
