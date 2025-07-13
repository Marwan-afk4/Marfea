<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ContactU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{


    public function contactUs(Request $request)
    {
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email'=> 'required|email',
            'subject'=> 'required|string',
            'message'=> 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        ContactU::create([
            'user_id'=> $user->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return response()->json([
            'message'=> 'Your message has been sent successfully',
        ]);
    }
}
