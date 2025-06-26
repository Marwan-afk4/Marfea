<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\trait\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    use ImageUpload;

    public function getPyamentMethod()
    {
        $paymentMethods = PaymentMethod::all();
        $data =[
            'paymentMethods'=> $paymentMethods
        ];
        return response()->json($data);
    }

    public function addPaymentMethod(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:payment_methods,name',
            'phone'=> 'nullable|string',
            'account'=> 'nullable|string',
            'status'=> 'required|in:active,inactive',
            'image'=> 'nullable|string',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $paymentMethod = PaymentMethod::create([
            'name'=> $request->name,
            'phone'=> $request->phone ?? null,
            'account'=> $request->account ?? null,
            'status'=> $request->status,
            'image'=> $this->storeBase64Image($request->image ,'Paymentmethod/images') ?? null,
        ]);

        return response()->json([
            'message' => 'Payment method created successfully',
            'paymentMethod' => $paymentMethod
        ]);
    }

    public function editPaymentMethod(Request $request,$id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:payment_methods,name,'.$request->id,
            'phone'=> 'nullable|string',
            'account'=> 'nullable|string',
            'status'=> 'required|in:active,inactive',
            'image'=> 'nullable|string',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $paymentMethod = PaymentMethod::find($id);

        $paymentMethod->update([
            'name'=> $request->name ?? $paymentMethod->name,
            'phone'=> $request->phone ?? $paymentMethod->phone,
            'account'=> $request->account ?? $paymentMethod->account,
            'status'=> $request->status ?? $paymentMethod->status,
            'image'=> $this->storeBase64Image($request->image ,'Paymentmethod/images') ?? $paymentMethod->image,
        ]);

        return response()->json([
            'message' => 'Payment method updated successfully',
            'paymentMethod' => $paymentMethod
        ]);
    }

    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();
        return response()->json([
            'message' => 'Payment method deleted successfully',
        ]);
    }
}
