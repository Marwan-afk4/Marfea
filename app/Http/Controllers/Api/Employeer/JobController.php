<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    use ImageUpload;


    public function getJobs(Request $request)
    {
        $user = $request->user();
        $company = $user->company()->first();

        $jobs = JobOffer::with([
            'company:id,name,email,phone',
            'jobCategory',
            'city:id,name,country_id',
            'zone:id,name,city_id'
        ])
        ->where('company_id', $company->id)
        ->get();
        return response()->json(['jobs' => $jobs]);
    }


    public function addNewJob(Request $request)
    {
        $user = $request->user();
        $company = $user->company()->first();

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        if ($company->status !== 'active') {
            return response()->json(['error' => 'Company is not active'], 403);
        }

        $validation = Validator::make($request->all(), [
            'job_category_id' => 'required|exists:job_categories,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'title' => 'required',
            'description' => 'required',
            'qualifications' => 'nullable',
            'image' => 'nullable',
            'type' => 'required|in:full_time,part_time,freelance,hybrid,internship',
            'experience' => 'required|in:fresh,junior,mid,+1 year,+2 years,+3 years,senior',
            'status' => 'required|in:active,inactive',
            'expected_salary' => 'required|numeric',
            'expire_date' => 'required|date',
            'location_link' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $job = JobOffer::create([
            'company_id' => $company->id,
            'job_category_id' => $request->job_category_id ?? null,
            'city_id' => $request->city_id ?? null,
            'zone_id' => $request->zone_id ?? null,
            'title' => $request->title ?? null,
            'description' => $request->description ?? null,
            'qualifications' => $request->qualifications ?? null,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'jobs/images') : null,
            'type' => $request->type ?? null,
            'experience' => $request->experience ?? null,
            'status' => $request->status ?? null,
            'expected_salary' => $request->expected_salary ?? null,
            'expire_date' => $request->expire_date ?? null,
            'location_link' => $request->location_link ?? null
        ]);

        return response()->json(
            [
                'message' => 'Job added successfully',
                'job' => $job
            ]
        );
    }

    public function deleteJob(Request $request, $id)
    {
        $job = JobOffer::find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully']);
    }


    public function editJob(Request $request,$id)
    {
        $job = JobOffer::find($id);
        $validation = Validator::make($request->all(), [
            'job_category_id' => 'nullable|exists:job_categories,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'qualifications' => 'nullable',
            'image'=>'nullable',
            'type' => 'nullable|in:full_time,part_time,freelance,hybrid,internship',
            'experience'=> 'nullable|in:fresh,junior,mid,+1 year,+2 years,+3 years,senior',
            'status' => 'nullable|in:active,inactive',
            'expected_salary' => 'nullable|numeric',
            'expire_date' => 'nullable|date',
            'location_link' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $job->update([
            'job_category_id' => $request->job_category_id ?? $job->job_category_id,
            'city_id' => $request->city_id ?? $job->city_id,
            'zone_id' => $request->zone_id ?? $job->zone_id,
            'title' => $request->title ?? $job->title,
            'description' => $request->description ?? $job->description,
            'qualifications' => $request->qualifications ?? $job->qualifications,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'jobs/images') : $job->image,
            'type' => $request->type ?? $job->type,
            'experience' => $request->experience ?? $job->experience,
            'status' => $request->status ?? $job->status,
            'expected_salary' => $request->expected_salary ?? $job->expected_salary,
            'expire_date' => $request->expire_date ?? $job->expire_date,
            'location_link' => $request->location_link ?? $job->location_link
        ]);

        return response()->json(
            [
                'message' => 'Job updated successfully',
                'job'=> $job,
            ]);
    }
}
