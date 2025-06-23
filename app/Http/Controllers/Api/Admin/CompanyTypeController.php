<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyTypeController extends Controller
{


    public function getCompanyTypes()
    {
        $companyTypes = CompanyType::all();

        $data =[
            'company_types' => $companyTypes,
        ];
        return response()->json($data);
    }

    public function getActiveCompanyTypes()
    {
        $companyTypes = CompanyType::where('status', 'active')->get();
        $data =[
            'company_types' => $companyTypes,
        ];
        return response()->json($data);
    }

    public function addCompanyType(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:company_types,name',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $create = CompanyType::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Company Type Added Successfully',
            'company_type' => $create,
        ]);
    }

    public function editCompanyType(Request $request,$id)
    {
        $companyTypes = CompanyType::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255|unique:company_types,name,' . $id,
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $companyTypes->name = $request->name;
        $companyTypes->status = $request->status;
        $companyTypes->save();
        return response()->json([
            'message' => 'Company Type Updated Successfully',
            'company_type' => $companyTypes,
        ]);
    }

    public function deleteCompanyType($id)
    {
        $companyTypes = CompanyType::find($id);
        if (!$companyTypes) {
            return response()->json(['message' => 'Company Type Not Found'], 404);
        }
        $companyTypes->delete();
        return response()->json(['message' => 'Company Type Deleted Successfully']);
    }
}
