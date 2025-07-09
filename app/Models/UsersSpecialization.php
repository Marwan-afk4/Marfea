<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersSpecialization extends Model
{
    use HasFactory;

    protected $table = 'users_specializations';

    protected $fillable = [
        'user_id',
        'specialization_id'
    ];
    
    public $timestamps = true;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

}
