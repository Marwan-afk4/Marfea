<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $table = 'specializations';

    protected $fillable = [
        'name',
        'status'
    ];

    public $timestamps = true;

    protected $hidden =[
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_specializations');
    }


}
