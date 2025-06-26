<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatmentRequestsController extends Controller
{


    public function getPendingPaymentRequests()
    {
        $pendingPaymentRequests = PaymentRequest::with([
            'company:id,name',
            'plan:id,name,price_after_discount',
            'empeloyee:id,first_name,last_name,email,phone',
            'paymentMethod:id,name'
            ])
        ->where('status','pending')
        ->get();

        $data =[
            'pending_payments_count' => $pendingPaymentRequests->count(),
            'pending_payment_requests' => $pendingPaymentRequests
        ];

        return response()->json($data);
    }

    public function getApprovedPaymentRequests()
    {
        $ApprovedPaymentRequests = PaymentRequest::with([
            'company:id,name',
            'plan:id,name,price_after_discount',
            'empeloyee:id,first_name,last_name,email,phone',
            'paymentMethod:id,name'
            ])
        ->where('status','approved')
        ->get();

        $data =[
            'Approved_payments_count' => $ApprovedPaymentRequests->count(),
            'Approved_payment_requests' => $ApprovedPaymentRequests
        ];

        return response()->json($data);
    }

    public function getRejectedPaymentRequests()
    {
        $rejectedPaymentRequests = PaymentRequest::with([
            'company:id,name',
            'plan:id,name,price_after_discount',
            'empeloyee:id,first_name,last_name,email,phone',
            'paymentMethod:id,name'
            ])
        ->where('status','rejected')
        ->get();

        $data =[
            'rejected_payments_count' => $rejectedPaymentRequests->count(),
            'rejected_payment_requests' => $rejectedPaymentRequests
        ];

        return response()->json($data);
    }

    public function acceptPaymentRequests($id)
    {
        $pendingPaymentRequests = PaymentRequest::findOrfail($id);
        $pendingPaymentRequests->status = 'approved';
        $pendingPaymentRequests->save();

        Subscription::create([
            'payment_request_id' => $id,
            'employee_id' => $pendingPaymentRequests->empeloyee_id,
            'plan_id' => $pendingPaymentRequests->plan_id,
            'company_id' => $pendingPaymentRequests->company_id,
            'payment_method_id' => $pendingPaymentRequests->payment_method_id,
            'price' => $pendingPaymentRequests->plan->price_after_discount,
            'start_date' => now(),
            'expire_date' => now()->addDays(($pendingPaymentRequests->plan->type == 'monthly') ? 30 : 365),
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'Payment request accepted successfully',
        ]);
    }

    public function rejectPaymentRequests(Request $request,$id)
    {
        $validation = Validator::make($request->all(), [
            'reason' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $pendingPaymentRequests = PaymentRequest::findOrfail($id);
        $pendingPaymentRequests->status = 'rejected';
        $pendingPaymentRequests->reject_reason = $request->reason;
        $pendingPaymentRequests->save();

        return response()->json([
            'message' => 'Payment request rejected successfully',
        ]);

    }
}
