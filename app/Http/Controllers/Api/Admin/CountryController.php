<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{


    public function getCountries()
    {
        $countries = Country::all();
        return response()->json([
            'countries' => $countries,
        ]);
    }

    public function addCountry(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:countries,name',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ]);
        }

        $country = Country::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Country Added Successfully',
        ]);
    }

    public function editCountry(Request $request, $id)
    {
        $country = Country::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'status' => 'nullable|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ]);
        }
        $country->update($request->all());
        return response()->json([
            'message' => 'Country Updated Successfully',
        ]);
    }

    public function deleteCountry($id)
    {
        $country = Country::find($id);
        $country->delete();
        return response()->json([
            'message' => 'Country Deleted Successfully',
        ]);
    }
}
