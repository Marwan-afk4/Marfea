<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PendingEmployeerController extends Controller
{


    public function getPendingEmployeerRequest()
    {
        $pendingEmployeer = User::where('role', 'employeer')
        ->where('status', 'pending')
        ->with('companies')
        ->get();

        $data = [
            'pendingEmployeer'=> $pendingEmployeer
        ];

        return response()->json($data);
    }

    public function approvePendingEmployeerRequest($id)
    {
        $user = User::find($id);
        $user->status = 'approved';
        $user->save();
        return response()->json(['message' => 'Employeer request accepted successfully'], 200);
    }

    public function rejectPendingEmployeerRequest($id)
    {
        $user = User::find($id);
        $user->status = 'rejected';
        $user->save();
        return response()->json(['message' => 'Employeer request rejected successfully'], 200);
    }
}
