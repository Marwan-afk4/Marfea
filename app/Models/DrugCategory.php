<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugCategory extends Model
{
    use HasFactory;

    protected $table = 'drug_categories';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    
    public $timestamps = true;

    
}
