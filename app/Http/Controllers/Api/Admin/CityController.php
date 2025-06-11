<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{


    public function getCities()
    {
        $cities = City::with('country')->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    public function addCity(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:cities,name',
            'country_id' => 'required|exists:countries,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ]);
        }

        $city = City::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'City added successfully',
            'city' => $city
        ]);
    }

    public function updateCity(Request $request, $id)
    {
        $city = City::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'country_id' => 'nullable|exists:countries,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ]);
        }

        $city->update($request->all());
        return response()->json([
            'message' => 'City updated successfully',
            'city' => $city
        ]);
    }

    public function deleteCity($id)
    {
        $city = City::find($id);
        $city->delete();
        return response()->json([
            'message' => 'City deleted successfully',
        ]);
    }
}
