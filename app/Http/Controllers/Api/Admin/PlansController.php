<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlansController extends Controller
{


    public function getPlans(Request $request)
    {
        $plans = Plan::with('jobCategories')->get();
        $data = [
            "plans"=> $plans
        ];
        return response()->json($data,200);
    }

    public function createPlan(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:plans,name',
            'description'=> 'nullable|string',
            'price' => 'required|numeric|gt:0',
            'price_after_discount'=> 'required|numeric|gt:0',
            'type'=> 'required|in:monthly,yearly',
            'status'=> 'required|in:active,inactive',
            'top_picked'=> 'nullable|boolean',
            'features'=> 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'features.cv_number' => 'required|numeric|min:1',
            'job_category_ids' => 'required|array|min:1',
            'job_category_ids.*' => 'exists:job_categories,id',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $plan = Plan::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'price'=> $request->price,
            'type'=> $request->type,
            'status'=> $request->status,
            'price_after_discount'=> $request->price_after_discount,
            'features'=> $request->features,
            'top_picked'=> $request->top_picked ?? 0,
        ]);

        foreach($request->job_category_ids as $jobCategoryId)
        {
            $plan->jobCategories()->attach($jobCategoryId,['status' => 'active']);
        }

        return response()->json(['message'=> 'Plan added successfully'],200);
    }

    public function updatePlan(Request $request, $id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'nullable|string|unique:plans,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|gt:0',
            'price_after_discount' => 'nullable|numeric|gt:0',
            'type' => 'nullable|in:monthly,yearly',
            'status' => 'nullable|in:active,inactive',
            'top_picked'=> 'nullable|boolean',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'features.cv_number' => 'nullable|numeric|min:1',
            'job_category_ids' => 'nullable|array',
            'job_category_ids.*' => 'exists:job_categories,id',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $existingFeatures = $plan->features ?? [];
        $newFeatures = $request->features ?? [];
        $featuresToRemove = $request->features_to_remove ?? [];

        // Merge new features (add/update)
        $mergedFeatures = array_merge($existingFeatures, $newFeatures);

        // Remove specific features if requested
        foreach ($featuresToRemove as $key) {
            unset($mergedFeatures[$key]);
        }

        $plan->update([
            'name' => $request->name ?? $plan->name,
            'description' => $request->description ?? $plan->description,
            'price' => $request->price ?? $plan->price,
            'type' => $request->type ?? $plan->type,
            'status' => $request->status ?? $plan->status,
            'price_after_discount' => $request->price_after_discount ?? $plan->price_after_discount,
            'features' => $mergedFeatures,
            'top_picked' => $request->top_picked ?? $plan->top_picked
        ]);

        if ($request->has('job_category_ids')) {
            $plan->jobCategories()->sync(
                collect($request->job_category_ids)->mapWithKeys(function ($id) {
                    return [$id => ['status' => 'active']]; // default status
                })->toArray()
            );
        }

        return response()->json(['message' => 'Plan updated successfully'], 200);
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully'], 200);
    }

}
