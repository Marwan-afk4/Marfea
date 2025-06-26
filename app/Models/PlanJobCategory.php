<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanJobCategory extends Model
{
    use HasFactory;

    protected $table = 'plan_job_categories';

    protected $fillable = [
        'plan_id',
        'job_category_id',
        'status'
    ];
    
    public $timestamps = true;

    
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

}
