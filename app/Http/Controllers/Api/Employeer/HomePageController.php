<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class HomePageController extends Controller
{


    public function homePage(Request $request)
    {
        $user = $request->user();
        $companyDetails = $user->companies()->first();

        $totalJobs = JobOffer::where('company_id', $companyDetails->id)
        ->count();

        $activeJobs = JobOffer::where('company_id', $companyDetails->id)
        ->where('status', 'active')
        ->count();

        $inactiveJobsCount = JobOffer::where('company_id', $companyDetails->id)
        ->where('status', 'inactive')
        ->count();

        //total application ;later
        $totalApplications = 0; // Placeholder, implement logic to count applications if needed

        return response()->json([
            'company_details' => $companyDetails,
            'total_jobs' => $totalJobs,
            'active_jobs' => $activeJobs,
            'inactive_jobs' => $inactiveJobsCount,
            'total_applications' => $totalApplications,
        ]);
    }
}
