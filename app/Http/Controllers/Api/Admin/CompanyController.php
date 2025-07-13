<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use ImageUpload;

    public function getCompanies()
    {
        $companies = Company::with([
            'companyType:id,name',
            'companySpecializations',
            'companySpecializations.specialization:id,name',
            'user:id,first_name,last_name,email,phone'
        ])->get();

        return response()->json([
            'companies' => $companies,
        ]);
    }

    public function addCompany(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'nullable|unique:companies,phone',
            'image' => 'nullable',
            'location_link' => 'nullable',
            'description' => 'nullable',
            'facebook_link' => 'nullable',
            'twitter_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'site_link' => 'nullable',
            'company_type_id'=>'required|exists:company_types,id',
            'specializations' => 'nullable|array',
            'specializations.*' => 'nullable|exists:specializations,id',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $company = Company::create([
            'name' => $request->name,
            'city_id' =>$request->city_id,
            'country_id'=> $request->country_id,
            'email' => $request->email,
            'phone' => $request->phone??null,
            'image' => $this->storeBase64Image($request->image??null,'companies/images'),
            'location_link' => $request->location_link??null,
            'description' => $request->description??null,
            'facebook_link' => $request->facebook_link??null,
            'twitter_link' => $request->twitter_link??null,
            'linkedin_link' => $request->linkedin_link??null,
            'site_link' => $request->site_link??null,
            'company_type_id'=>$request->company_type_id,
            'status'=>'active',
        ]);

        if ($request->filled('specializations')) {
            foreach ($request->specializations as $specId) {
                $company->companySpecializations()->create([
                    'specialization_id' => $specId,
                    'status' => 'active',
                ]);
            }
        }


        return response()->json(['message'=>'Company added successfully'],200);
    }


    public function updateCompany(Request $request, $id)
    {
        $company = Company::find($id);

        $validation = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'country_id'=> 'nullable|exists:countries,id',
            'email' => 'nullable|email|unique:companies,email,' . $company->id,
            'phone' => 'nullable|nullable|unique:companies,phone,' . $company->id,
            'image' => 'nullable',
            'location_link' => 'nullable|string',
            'description' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'site_link' => 'nullable|url',
            'company_type_id' => 'nullable|exists:company_types,id',
            'specializations' => 'nullable|array',
            'specializations.*' => 'nullable|exists:specializations,id',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        // Update company fields
        $company->update([
            'name' => $request->name ?? $company->name,
            'city_id' => $request->city_id ?? $company->city_id,
            'country_id'=> $request->country_id ?? $company->country_id,
            'email' => $request->email ?? $company->email,
            'phone' => $request->phone ?? $company->phone,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'companies/images') : $company->image,
            'location_link' => $request->location_link ?? $company->location_link,
            'description' => $request->description ?? $company->description,
            'facebook_link' => $request->facebook_link ?? $company->facebook_link,
            'twitter_link' => $request->twitter_link ?? $company->twitter_link,
            'linkedin_link' => $request->linkedin_link ?? $company->linkedin_link,
            'site_link' => $request->site_link ?? $company->site_link,
            'company_type_id' => $request->type ?? $company->company_type_id
        ]);

        // Optional: update specializations (replace all)
        if ($request->filled('specializations')) {
            $company->companySpecializations()->delete(); // remove old
            foreach ($request->specializations as $specId) {
                $company->companySpecializations()->create([
                    'specialization_id' => $specId,
                    'status' => 'active',
                ]);
            }
        }

        return response()->json(['message' => 'Company updated successfully'], 200);
    }


    public function deleteCompany($id){
        $company = Company::find($id);
        $company->delete();
        return response()->json([
            'message' => 'Company deleted successfully',
        ]);
    }
}
