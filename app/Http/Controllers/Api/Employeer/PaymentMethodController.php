<?php

namespace App\Http\Controllers\Api\Employeer;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{


    public function getActivePaymentMethod()
    {
        $payment_method = PaymentMethod::where('status','active')->get();

        $data =[
            'active_payment_method' => $payment_method
        ];

        return response()->json($data);
    }
}
