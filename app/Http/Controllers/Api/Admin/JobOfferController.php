<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobOfferController extends Controller
{

    use ImageUpload;

    public function getJobs()
    {
        $jobs = JobOffer::with([
            'jobTitele:id,name',
            'company:id,name,email,phone',
            'jobCategory', 'city:id,name,country_id',
            'zone:id,name,city_id'
            ])
            ->get();

        return response()->json(['jobs'=>$jobs]);
    }

    public function addJob(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'job_titel_id' => 'required|exists:job_titels,id',
            'description' => 'required',
            'qualifications' => 'nullable',
            'image'=>'nullable',
            'type' => 'required|in:full_time,part_time,freelance,hybrid,internship',
            'experience'=> 'required|in:fresh,junior,mid,+1 year,+2 years,+3 years,senior',
            'status' => 'required|in:active,inactive',
            'expected_salary' => 'required|numeric',
            'expire_date' => 'required|date',
            'location_link' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $job = JobOffer::create([
            'company_id' => $request->company_id ?? null,
            'job_category_id' => $request->job_category_id ?? null,
            'city_id' => $request->city_id ?? null,
            'zone_id' => $request->zone_id ?? null,
            'job_titel_id' => $request->job_titel_id,
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


    public function editJob(Request $request,$id)
    {
        $job = JobOffer::find($id);
        $validation = Validator::make($request->all(), [
            'company_id' => 'nullable|exists:companies,id',
            'job_category_id' => 'nullable|exists:job_categories,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'job_titel_id' => 'nullable|exists:job_titels,id',
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
            'company_id' => $request->company_id ?? $job->company_id,
            'job_category_id' => $request->job_category_id ?? $job->job_category_id,
            'city_id' => $request->city_id ?? $job->city_id,
            'zone_id' => $request->zone_id ?? $job->zone_id,
            'job_titel_id' => $request->job_titel_id ?? $job->job_titel_id,
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
            ]);
    }


    public function deleteJob($id){
        $job = JobOffer::find($id);
        $job->delete();
        return response()->json([
            'message' => 'Job deleted successfully',
        ]);
    }
}
