<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderLocation extends Model
{
    use HasFactory;

    protected $fillable = ['rider_id', 'lat', 'long'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rider_id' => 'integer',
        'lat' => 'decimal:6',
        'long' => 'decimal:6',
    ];

    public static $rules = [
        'rider_id' => 'required|integer',
        'lat' => 'required|numeric',
        'long' => 'required|numeric',
    ];

}
