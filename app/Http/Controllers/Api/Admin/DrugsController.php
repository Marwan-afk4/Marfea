<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugsController extends Controller
{
    use ImageUpload;

    public function getDrugs()
    {
        $drugs = Drug::with(['company:id,name,email,phone','user:id,name'])->get();
        $data = [
            'drugs'=> $drugs
        ];
        return response()->json($data);
    }

    public function createDrug(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image'=> 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors()],422);
        }

        $createDrug = Drug::create([
            'company_id' => $request->company_id,
            'name'=> $request->name,
            'description'=> $request->description ?? null,
            'image'=> $this->storeBase64Image($request->image ,'drugs/images') ?? null,
        ]);

        return response()->json([
            'message' => 'Drug created successfully',
            'drug' => $createDrug
        ]);
    }

    public function updateDrug(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'company_id' => 'nullable|exists:companies,id',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $drug->company_id = $request->company_id ?? $drug->company_id;
        $drug->name = $request->name ?? $drug->name;
        $drug->description = $request->description ?? $drug->description;
        $drug->image = $this->storeBase64Image($request->image, 'drugs/images') ?? $drug->image;

        $drug->save();

        return response()->json([
            'message' => 'Drug updated successfully',
            'drug' => $drug
        ]);
    }

    public function destroyDrug(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete();
        return response()->json([
            'message' => 'Drug deleted successfully',
        ]);
    }
}
