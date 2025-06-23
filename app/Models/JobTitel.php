<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitel extends Model
{
    use HasFactory;

    protected $table = 'job_titels';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public $timestamps = true;


    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class, 'job_titel_id');
    }
}
