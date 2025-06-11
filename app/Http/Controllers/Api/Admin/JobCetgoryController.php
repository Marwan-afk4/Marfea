<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobCetgoryController extends Controller
{

    public function getJobCategories(){
        $jobCategories = JobCategory::all();
        return response()->json([
            'jobCategories' => $jobCategories,
        ]);
    }

    public function addJobCategory(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:job_categories,name',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
            ]);
        }
        $jobCategory = JobCategory::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Job Category added successfully',
        ]);
    }

    public function updateJobCategory(Request $request, $id){
        $jobCategory = JobCategory::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'status' => 'nullable|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
            ]);
        }
        $jobCategory->update($request->all());
        return response()->json([
            'message' => 'Job Category updated successfully',
        ]);
    }

    public function deleteJobCategory($id){
        $jobCategory = JobCategory::find($id);
        $jobCategory->delete();
        return response()->json([
            'message' => 'Job Category deleted successfully',
        ]);
    }
}
