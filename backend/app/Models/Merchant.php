<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
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
    

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    

}
