<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'keyword_id',
        'menu',
        'description',
        'price',
        'cover_photo',
        'is_available'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
