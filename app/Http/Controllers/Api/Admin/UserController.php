<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ImageUpload;

    public function getUsers()
    {
        $users = User::with('specializations')
        ->where('role','user')
        ->where('status','!=','deleted')
        ->get();
        $data =[
            'users' => $users
        ];
        return response()->json($data);
    }

    public function addUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'=> 'required|string',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:6',
            'phone' => 'required|unique:users',
            'specialization' => 'required|array|min:1',
            'specialization.*' => 'exists:specializations,id',
            'image' => 'nullable|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $user = User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
            'status' => 'active',
            'image' => $this->storeBase64Image($request->image,'users/images') ?? null,
        ]);

        $user->specializations()->attach($request->specialization);

        return response()->json([
            'message' => 'User created successfully',
            'user'=> $user
        ]);
    }


    public function editUser(Request $request,$id)
    {
        $user = User::find($id);

        $validation = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name'=> 'nullable|string',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'password'=> 'nullable|min:6',
            'phone' => 'nullable|unique:users,phone,'.$user->id,
            'specialization' => 'nullable|array|min:1',
            'specialization.*' => 'exists:specializations,id',
            'image' => 'nullable|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $user->update([
            'first_name'=> $request->first_name ?? $user->first_name,
            'last_name'=> $request->last_name ?? $user->last_name,
            'email' => $request->email ?? $user->email,
            'password' => Hash::make($request->password) ?? $user->password,
            'phone' => $request->phone,
            'image' => $this->storeBase64Image($request->image,'users/images') ?? $user->image,
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->update([
            'status' => 'deleted'
        ]);
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
