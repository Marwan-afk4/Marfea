<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';

    protected $fillable = [
        'city_id',
        'name',
        'status'
    ];

    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
