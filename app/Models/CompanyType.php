<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    use HasFactory;

    protected $table = 'company_types';

    protected $fillable = [
        'name',
        'status'
    ];

    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function companies()
    {
        return $this->hasMany(Company::class, 'company_type_id');
    }
}
