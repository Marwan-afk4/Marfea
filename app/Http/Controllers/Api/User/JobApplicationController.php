<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\UserCv;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    use ImageUpload;
    public function applyToJob(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'job_offer_id' => 'required|exists:job_offers,id',
            'cv_file' => 'required|string',
            'has_experience' => 'required|in:yes,no',
            'message' => 'nullable|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = $request->user();


        $application = JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $request->job_offer_id,
            'cv_file' => $request->cv_file,
            'has_experience' => $request->has_experience,
            'message' => $request->message ?? null,
        ]);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'application' => $application
        ]);
    }

    public function getUserCv(Request $request)
    {
        $user = $request->user();
        $userCv = UserCv::where('user_id', $user->id)->get();

        $data =[
            'userCv'=> $userCv
        ];

        return response()->json($data);
    }

    public function myApplications(Request $request)
    {
        $user = $request->user();

        $applications = JobApplication::with([
            'jobOffer:id,job_titel_id,job_category_id,company_id',
            'jobOffer.company:id,name,email,phone',
            'jobOffer.jobTitel:id,name',
            'jobOffer.jobCategory:id,name',
        ])
        ->where('user_id', $user->id)
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'applications' => $applications
        ]);
    }
}
