<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'name',
        'status'
    ];

    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


}
