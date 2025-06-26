<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
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

        

        return response()->json([
            'message' => 'Payment request accepted successfully',
        ]);
    }
}
