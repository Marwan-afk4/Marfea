<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationCode;
use App\Models\Company;
use App\Models\User;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ImageUpload;

    //register

    public function registerUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'nullable',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $code = rand(100000, 999999);
        $fullName = $request->first_name.' '.$request->last_name;

        Mail::to($request->email)->send(new EmailVerificationCode( $code,$fullName));

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone??null,
            'email_code' => $code,
            'email_verified' => 'unverified',
            'role'=>'user',
            'status'=>'active'
        ]);

        return response()->json(['message'=>'Go and verify your email'],200);
    }

    public function verifyOtp(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if($user->email_code == $request->code){
            $user->email_verified = 'verified';
            $user->email_code = null;
            $user->save();

            if($user->role === 'user'){
                $user->status = 'active';
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message'=>'Email verified successfully hello '.$user->first_name.'',
                    'token' => $token,
                    'user'=>$user
                ]);
            }

            if($user->role === 'employeer'){
                $user->status = 'pending';
                return response()->json([
                    'message'=>'Email verified successfully wait for admin approval',
                ]);
            }
        }
        return response()->json(['message'=>'Invalid code'],400);
    }

    //get companies
    public function getCompanies(Request $request)
    {
        $companies = Company::all();
        $data = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
            ];
        });

        return response()->json(['companies' => $data],200);
    }

    public function registerEmployeer(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'nullable',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $code = rand(100000, 999999);
        $fullName = $request->first_name.' '.$request->last_name;

        Mail::to($request->email)->send(new EmailVerificationCode( $code,$fullName));

        $user = User::create([
            'company_id' => $request->company_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone??null,
            'email_code' => $code,
            'email_verified' => 'unverified',
            'role'=>'employeer',
        ]);

        return response()->json(['message'=>'Go and verify your email'],200);
    }

    public function addCompanyNewData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'nullable|exists:cities,id',
            'country_id' => 'nullable|exists:countries,id',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'nullable|unique:companies,phone',
            'image' => 'nullable',
            'location_link' => 'nullable',
            'description' => 'nullable',
            'facebook_link' => 'nullable',
            'twitter_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'site_link' => 'nullable',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $company = Company::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'email' => $request->email,
            'phone' => $request->phone??null,
            'image' => $this->storeBase64Image($request->image??null,'companies/images'),
            'location_link' => $request->location_link??null,
            'description' => $request->description??null,
            'facebook_link' => $request->facebook_link??null,
            'twitter_link' => $request->twitter_link??null,
            'linkedin_link' => $request->linkedin_link??null,
            'site_link' => $request->site_link??null,
            'status'=>'pending',
        ]);

        return response()->json(['message'=>'Company added successfully'],200);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()->first()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if($user->role === 'employeer' && $user->status === 'pending'){
            return response()->json(['message' => 'Employeer account is not active yet'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $activeSubscription = $user->activeSubscription()
        ->where('status', 'active')
        ->latest()
        ->first();

        return response()->json([
            'message'=>'Login successfully',
            'token' => $token,
            'user'=>$user,
            'subscription_status' => $activeSubscription ? 'active' : 'inactive',
            'subscription' => $activeSubscription, // include full record or just id, dates, etc.
        ], 200);
    }
}
