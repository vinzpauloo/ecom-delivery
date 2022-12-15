<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OTP extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'otp';

    protected $fillable = [
        'mobile',
        'code',
        'status',
        'created_at',
        'expire_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'expire_at' => 'datetime',
    ];

    public $timestamps = false;

}
