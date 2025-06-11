<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{


    public function getzones()
    {
        $zones = Zone::with(['city', 'city.country'])->get();
        return response()->json([
            'zones' => $zones,
        ]);
    }

    public function addZone(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:zones,name',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
            ]);
        }
        $zone = Zone::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Zone added successfully',
        ]);
    }

    public function updateZone(Request $request, $id)
    {
        $zone = Zone::find($id);
        $validation = Validator::make($request->all(), [
            'name' => 'nullable',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'nullable|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
            ]);
        }
        $zone->update($request->all());
        return response()->json([
            'message' => 'Zone updated successfully',
        ]);
    }

    public function deleteZone($id)
    {
        $zone = Zone::find($id);
        $zone->delete();
        return response()->json([
            'message' => 'Zone deleted successfully',
        ]);
    }
}
