<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SavedJobController extends Controller
{
    public function saveJob(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'job_offer_id' => 'required|exists:job_offers,id'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = $request->user();

        $saved = SavedJob::firstOrCreate([
            'user_id' => $user->id,
            'job_offer_id' => $request->job_offer_id,
        ]);

        return response()->json([
            'message' => 'Job saved successfully',
            'saved_job' => $saved
        ]);
    }

    public function removeJob(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'job_offer_id' => 'required|exists:job_offers,id'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = $request->user();

        $deleted = SavedJob::where('user_id', $user->id)
            ->where('job_offer_id', $request->job_offer_id)
            ->delete();

        return response()->json([
            'message' => $deleted ? 'Job removed from saved list' : 'Job not found in saved list'
        ]);
    }

    public function listSavedJobs(Request $request)
    {
        $user = $request->user();

        $savedJobs = SavedJob::with('jobOffer')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'saved_jobs' => $savedJobs
        ]);
    }
}
