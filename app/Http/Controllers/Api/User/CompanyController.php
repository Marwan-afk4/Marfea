<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

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
}
