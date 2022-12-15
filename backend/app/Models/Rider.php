<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'email_verified_at',
        'photo'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
