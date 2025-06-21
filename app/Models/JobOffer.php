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
        'experience',
        'expected_salary',
        'expire_date',
        'status',
        'location_link'
    ];

    public $timestamps = false;

    protected $appends =[
        'image_link',
    ];

    public function getImageLinkAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


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
