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
        'specialization'
    ];

    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token',
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


    public function companies()
    {
        return $this->hasMany(Company::class);
    }

}
