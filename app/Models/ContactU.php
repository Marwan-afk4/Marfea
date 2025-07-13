<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactU extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'subject',
        'message',
        'status',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
