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
        'specialization_name',
        'status'
    ];
    
    public $timestamps = true;

    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
