<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PatmentRequestsController extends Controller
{


    public function getPendingPaymentRequests()
    {
        $pendingPaymentRequests = PaymentRequest::with([
            'company:id,name',
            'plan:id,name,price_after_discount',
            'empeloyee',
            'paymentMethod'
            ])
        ->where('status','pending')
        ->get();

        $data =[
            'pending_payments_count' => $pendingPaymentRequests->count(),
            'pending_payment_requests' => $pendingPaymentRequests
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
}
