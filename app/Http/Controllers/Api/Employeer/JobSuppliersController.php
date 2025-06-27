<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\JobTitel;
use Illuminate\Http\Request;

class JobSuppliersController extends Controller
{


    public function getActiveJobTittles()
    {
        $jobTitel = JobTitel::where('status', 'active')->get();
        $data = [
            'job_tittles' => $jobTitel
        ];
        return response()->json($data);
    }

    public function getJobCategories(){
        $jobCategories = JobCategory::all();
        return response()->json([
            'jobCategories' => $jobCategories,
        ]);
    }
}
