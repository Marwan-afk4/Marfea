<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\User;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ImageUpload;

    public function getProfileData(Request $request)
    {
        $user = $request->user()->load([
            'specializations',
            'usercvs',
        ]);

        return response()->json([
            'user' => $user,
        ]);

    }


    public function updateProfileData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name'=> 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string',
            'age' =>'required|integer',
            'password' => 'nullable|min:6|confirmed',
            'cv_file' => 'nullable|string',
            'user_address' => 'nullable|string',
            'specialization' => 'nullable|array|min:1',
            'specialization.*' => 'exists:specializations,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = $request->user();

        DB::beginTransaction();

        try {
            // Update user fields
            $user->first_name = $request->first_name ?? $user->first_name;
            $user->last_name = $request->last_name ?? $user->last_name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->age = $request->age ?? $user->age;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Upload and store CV
            $cvPath = $this->storeBase64File($request->cv_file, 'users/cvs');

            if ($cvPath) {
                $user->usercvs()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'cv_file' => $cvPath,
                        'user_address' => $request->user_address,
                    ]
                );
            }

            // Sync specializations (many-to-many)
            if ($request->filled('specialization')) {
                $user->specializations()->sync($request->specialization);
            }

            DB::commit();

            return response()->json([
                'message' => 'Profile updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Something went wrong.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSpecializations()
    {
        $specializations = Specialization::where('status', 'active')->get();

        $data =[
            'specializations'=> $specializations
        ];

        return response()->json($data);
    }


    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        $request->user()->tokens()->delete();

        $user->delete();


        return response()->json([
            'message' => 'Account deleted successfully.'
        ]);
    }

}
