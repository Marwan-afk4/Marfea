<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'image',
        'location_link',
        'description',
        'start_date',
        'end_date',
        'site_link',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'status',
        'company_type_id',
    ];

    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends =[
        'image_link',
    ];

    public function getImageLinkAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function companySpecializations()
    {
        return $this->hasMany(CompanySpecialization::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class);
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

}
