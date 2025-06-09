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
        'status'
    ];

    public $timestamps = true;

    protected $appends =[
        'image_link',
    ];

    public function getImageLinkAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companySpecializations()
    {
        return $this->hasMany(CompanySpecialization::class);
    }

}
