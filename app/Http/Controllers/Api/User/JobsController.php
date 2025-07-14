<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobOffer;
use App\Models\JobTitel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{


    public function getAllJobs(Request $request)
    {
        $user = $request->user();

        $savedJobIds = $user
            ? $user->savedJobs()->pluck('job_offer_id')->toArray()
            : [];

        $jobs = JobOffer::with([
            'city:id,name,country_id',
            'city.country:id,name',
            'zone:id,name,city_id',
            'company:id,name,email,phone',
            'jobCategory:id,name',
            'jobTitel:id,name',
        ])
        ->get()
        ->map(function ($job) use ($savedJobIds) {
            $job->is_saved = in_array($job->id, $savedJobIds) ? 1 : 0;
            return $job;
        });

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function jobSearch(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'city_id' => 'nullable|exists:cities,id',
            'company_id' => 'nullable|exists:companies,id',
            'job_category_id' => 'nullable|exists:job_categories,id',
            'job_titel_id' => 'nullable|exists:job_titels,id',
            'type' => 'nullable|in:full_time,part_time,freelance,hybrid,internship',
            'experience'=> 'nullable|in:fresh,junior,mid,+1 year,+2 years,+3 years,senior',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }

        $paginate = 10;

        $jobs = JobOffer::with([
            'city:id,name,country_id',
            'city.country:id,name',
            'zone:id,name,city_id',
            'company:id,name,email,phone,location_link,facebook_link,linkedin_link',
            'jobCategory:id,name',
            'jobTitel:id,name',
        ])
        ->when($request->city_id, fn($q) => $q->where('city_id', $request->city_id))
        ->when($request->company_id, fn($q) => $q->where('company_id', $request->company_id))
        ->when($request->job_category_id, fn($q) => $q->where('job_category_id', $request->job_category_id))
        ->when($request->job_titel_id, fn($q) => $q->where('job_titel_id', $request->job_titel_id))
        ->when($request->type, fn($q) => $q->where('type', $request->type))
        ->when($request->experience, fn($q) => $q->where('experience', $request->experience))
        ->orderByDesc('id')
        ->paginate($paginate);
        return response()->json($jobs);
    }

    public function getIdsForJobSearch()
    {
        return response()->json([
            'cities' => City::select('id', 'name')->get(),
            'companies' => Company::select('id', 'name')->get(),
            'job_categories' => JobCategory::select('id', 'name')->get(),
            'job_titels' => JobTitel::select('id', 'name')->get(),
            'types' => ['full_time', 'part_time', 'freelance', 'internship', 'hybrid'],
            'experiences' => ['fresh', 'junior', 'mid', '+1 year', '+2 years', '+3 years', 'senior'],
        ]);
    }
}
