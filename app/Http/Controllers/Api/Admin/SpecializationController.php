<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends Controller
{


    public function getSpecializations()
    {
        $specializations = Specialization::all();
        return response()->json([
            'specializations' => $specializations,
        ]);
    }

    public function addSpecialization(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $specialization = Specialization::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Specialization added successfully',
        ]);
    }

    public function updateSpecialization(Request $request, $id)
    {
        $specialization = Specialization::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $specialization->update([
            'name' => $request->name ?? $specialization->name,
            'status' => $request->status ?? $specialization->status,
        ]);

        return response()->json([
            'message' => 'Specialization updated successfully',
        ]);
    }

    public function deleteSpecialization($id)
    {
        $specialization = Specialization::find($id);
        $specialization->delete();
        return response()->json([
            'message' => 'Specialization deleted successfully',
        ]);
    }
}
