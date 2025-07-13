<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{


    public function getCompanies()
    {
        $companies = Company::whereIn('status', ['approved', 'active'])
            ->with(['companySpecializations.specialization','drugs'])
            ->get();

        return response()->json([
            'companies' => $companies
        ]);
    }

    public function searchCompanies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'specialization_id' => 'nullable|exists:specializations,id',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $companies = Company::whereIn('status', ['approved', 'active'])
            ->when($request->country_id, function ($query) use ($request) {
                $query->where('country_id', $request->country_id);
            })
            ->when($request->specialization_id, function ($query) use ($request) {
                $query->whereHas('companySpecializations', function ($q) use ($request) {
                    $q->where('specialization_id', $request->specialization_id)
                    ->where('status', 'active'); // optional filter
                });
            })
            ->with(['companySpecializations.specialization', 'country:id,name', 'city:id,name'])
            ->get();

        return response()->json([
            'companies' => $companies
        ]);
    }
}
