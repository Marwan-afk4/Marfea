<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'name',
        'status'
    ];

    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
