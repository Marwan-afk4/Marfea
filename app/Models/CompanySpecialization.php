<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySpecialization extends Model
{
    use HasFactory;

    protected $table = 'company_specializations';

    protected $fillable = [
        'company_id',
        'specialization_id',
        'status'
    ];

    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
