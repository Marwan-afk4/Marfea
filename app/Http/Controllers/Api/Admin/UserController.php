<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function getUsers()
    {
        $users = User::where('role','user')
        ->where('status','!=','deleted')
        ->get();
        $data =[
            'users' => $users
        ];
        return response()->json($data);
    }

    public function editUser(UpdateUserRequest $request,$id)
    {
        $user = User::find($id);
        $user->update($request->all());
        $data =[
            'user' => $user
        ];
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $data
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
