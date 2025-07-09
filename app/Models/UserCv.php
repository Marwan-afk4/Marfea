<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCv extends Model
{
    use HasFactory;

    protected $table = 'user_cvs';

    protected $fillable = [
        'user_id',
        'cv_file',
        'user_address'
    ];

    public $timestamps = true;

    protected $appends = ['cv_file_url'];

    public function getCvFileUrlAttribute()
    {
        return $this->cv_file ? asset('storage/' . $this->cv_file) : null;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
