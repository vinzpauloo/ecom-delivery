<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'permit',
        'building_number',
        'street',
        'city',
        'branch',
        'landline',
        'mobile',
        'photo',
        'social_link',
        'long',
        'lat'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    protected $dates = ['deleted_at'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
