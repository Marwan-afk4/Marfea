<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobTitel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobTittleController extends Controller
{


    public function getJobTittles()
    {
        $jobTittles = JobTitel::all();
        $data = [
            'job_tittles' => $jobTittles
        ];
        return response()->json($data);
    }

    public function getActiveJobTittles()
    {
        $jobTitel = JobTitel::where('status', 'active')->get();
        $data = [
            'job_tittles' => $jobTitel
        ];
        return response()->json($data);
    }

    public function addJobTitel(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:job_titels,name',
            'description'=> 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $create = JobTitel::create([
            'name' => $request->name,
            'description'=> $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Job Titel Added Successfully',
            'job_titel'=> $create
        ]);
    }

    public function updateJobTitel(Request $request,$id)
    {
        $jobTitel = JobTitel::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable|string|unique:job_titels,name,' . $request->id,
            'description'=> 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $jobTitel->name = $request->name ?? $jobTitel->name;
        $jobTitel->description = $request->description ?? $jobTitel->description;
        $jobTitel->status = $request->status ?? $jobTitel->status;
        $jobTitel->save();
        return response()->json([
            'message' => 'Job Titel Updated Successfully',
            'job_titel'=> $jobTitel
        ]);
    }

    public function deleteJobTitel($id)
    {
        $jobTitel = JobTitel::find($id);
        if ($jobTitel) {
            return response()->json(['message' => 'Job Titel Not Found'], 404);
        }
        $jobTitel->delete();
        return response()->json([
            'message' => 'Job Titel deleted successfully',
        ]);
    }
}
