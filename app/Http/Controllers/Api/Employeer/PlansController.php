<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{


    public function getPlans()
    {
        $monthlyPlans = Plan::where('type', 'monthly')
        ->where('status', 'active')
        ->with('jobCategories')
        ->get();

        $yearlyPlans = Plan::where('type', 'yearly')
        ->where('status', 'active')
        ->with('jobCategories')
        ->get();

        $data = [
            'monthly_plans'=> $monthlyPlans,
            'yearly_plans'=> $yearlyPlans
        ];

        return response()->json($data);
    }
}
