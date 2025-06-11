<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $table = 'job_offers';

    protected $fillable = [
        'company_id',
        'job_category_id',
        'city_id',
        'zone_id',
        'title',
        'description',
        'qualifications',
        'image',
        'type',
        'level',
        'min_expected_salary',
        'max_expected_salary',
        'expire_date',
        'status',
        'location_link'
    ];

    public $timestamps = false;


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

}
