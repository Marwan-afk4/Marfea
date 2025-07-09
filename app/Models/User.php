<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;


    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'email_code',
        'email_verified',
        'image',
        'status',
        'role',
        'id_token',
        'company_id',
        'age'
    ];

    public $timestamps = false;


    protected $hidden = [
        'password',
        'remember_token',
        'updated_at'
    ];

    protected $appends = [
        'full_name',
        'image_link'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name??''.' '.$this->last_name??'';
    }

    public function getImageLinkAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function usercvs()
    {
        return $this->hasMany(UserCv::class);
    }



    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'users_specializations');
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'employee_id')->where('status', 'active');
    }

}
