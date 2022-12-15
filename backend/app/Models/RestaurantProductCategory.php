<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantProductCategory extends Model
{
    use HasFactory;

    protected $table = 'restaurant_product_category';
    
    protected $fillable = [
        'photo'
    ];
}
