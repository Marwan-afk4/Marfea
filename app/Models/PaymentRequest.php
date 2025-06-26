<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $table = 'payment_requests';

    protected $fillable = [
        'plan_id',
        'empeloyee_id',
        'company_id',
        'payment_method_id',
        'receipt_image',
        'status',
        'reject_reason'
    ];

    public $timestamps = true;


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function empeloyee()
    {
        return $this->belongsTo(User::class,'empeloyee_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
