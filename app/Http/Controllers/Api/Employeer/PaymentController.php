<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Plan;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    use ImageUpload;


    public function getPlans(Request $request)
    {
        $plans = Plan::where('status', 'active')
        ->with('jobCategories')->get();
        $data = [
            'plans'=> $plans
        ];
        return response()->json($data,200);
    }

    public function makePlanPyament(Request $request)
    {
        $employeer_id = $request->user()->id;

        $company_id = $request->user()->company_id;
        $validation = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'receipt_image' => 'nullable|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $paymentRequest = PaymentRequest::create([
            'plan_id' => $request->plan_id,
            'payment_method_id' => $request->payment_method_id,
            'empeloyee_id' => $employeer_id,
            'company_id'=> $company_id,
            'receipt_image' => $this->storeBase64Image($request->receipt_image, 'payment_requests/receipts'),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'You have make a payment request successfully , please wait for approval',
        ]);
    }


}
