<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'payment_request_id',
        'employee_id',
        'plan_id',
        'company_id',
        'payment_method_id',
        'start_date',
        'expire_date',
        'price',
        'status'
    ];

    public $timestamps = true;


    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
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
