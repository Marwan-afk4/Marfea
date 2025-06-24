<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'description',
        'price',
        'price_after_discount',
        'type',
        'features',
        'status'
    ];

    public $timestamps = true;

    protected $casts = [
        'features' => 'array',
    ];


}
