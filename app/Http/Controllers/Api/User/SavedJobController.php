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
            'job_offer_id' => 'required|exists:job_offers,id',
            'key' => 'required|in:0,1' 
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = $request->user();
        $jobOfferId = $request->job_offer_id;

        if ($request->key == 1) {
            $saved = SavedJob::firstOrCreate([
                'user_id' => $user->id,
                'job_offer_id' => $jobOfferId,
            ]);

            return response()->json([
                'message' => 'Job saved successfully.',
                'status' => 1,
                'saved_job' => $saved
            ]);
        } else {
            $deleted = SavedJob::where('user_id', $user->id)
                ->where('job_offer_id', $jobOfferId)
                ->delete();

            return response()->json([
                'message' => $deleted ? 'Job unsaved successfully.' : 'Job was not saved.',
                'status' => 0
            ]);
        }
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
