<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrugCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugCategoryController extends Controller
{


    public function getDrugCtegory(Request $request)
    {
        $drugCategory = DrugCategory::all();

        $activeDrugCategory = DrugCategory::where('status', 'active')->get();

        $data = [
            'drug_categories'=> $drugCategory,
            'active_drug_categories' => $activeDrugCategory,
        ];

        return response()->json($data);
    }

    public function addDrugCategory(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:drug_categories,name',
            'description'=> 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $drugCategory = DrugCategory::create([
            'name'=> $request->name,
            'description'=> $request->description ?? null,
            'status'=> $request->status
        ]);

        return response()->json(['message'=> 'Drug category added successfully'],200);
    }

    public function deleteDrugCategory($id)
    {
        $drugCategory = DrugCategory::find($id);
        $drugCategory->delete();
        return response()->json(['message'=> 'Drug category deleted successfully'],200);
    }

    public function editDrugCategory(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:drug_categories,name,'.$id,
            'description'=> 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $drugCategory = DrugCategory::find($id);
        $drugCategory->update([
            'name'=> $request->name ?? $drugCategory->name,
            'description'=> $request->description ?? $drugCategory->description,
            'status'=> $request->status ?? $drugCategory->status
        ]);

        return response()->json(['message'=> 'Drug category updated successfully'],200);
    }
}
