<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class TrackCvApplicationsController extends Controller
{


    public function getApplicationsForCompany(Request $request)
    {
        $employeer = $request->user();
        $companyId = $employeer->company_id;
        $applications = JobApplication::with([
            'user:id,first_name,last_name,email,phone',
            'jobOffer',
            'jobOffer.jobTitel:id,name',
            'jobOffer.jobCategory:id,name',

        ])
        ->whereHas('jobOffer', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })
        ->get();

        return response()->json(['applications' => $applications]);
    }

}
