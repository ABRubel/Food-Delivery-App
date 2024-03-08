<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantLocation extends Model
{
    use HasFactory;

    protected $fillable = ['rider_id', 'lat', 'long'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'restaurant_id' => 'integer',
        'lat' => 'decimal:6',
        'long' => 'decimal:6',
    ];
}
