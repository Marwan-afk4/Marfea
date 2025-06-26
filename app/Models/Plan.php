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
        'status',
        'top_picked'
    ];

    public $timestamps = true;

    protected $casts = [
        'features' => 'array',
    ];

    public function jobCategories()
    {
        return $this->belongsToMany(JobCategory::class, 'plan_job_categories')
        ->withPivot('status')
        ->withTimestamps();
    }


}
