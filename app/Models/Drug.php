<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $table = 'drugs';

    protected $fillable = [
        'company_id',
        'user_id',
        'name',
        'description',
        'image'
    ];

    public $timestamps = true;

    protected $appends =[
        'image_link',
    ];

    public function getImageLinkAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
