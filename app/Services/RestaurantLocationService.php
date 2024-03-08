<?php

namespace App\Services;
use App\Exceptions\RestaurantLocationException;
use App\Models\RestaurantLocation;
use App\Models\RiderLocation;
use Illuminate\Support\Facades\DB;

class RestaurantLocationService
{
    public function getLocation($restaurantId)
    {
        $restaurantLocation = RestaurantLocation::find($restaurantId);
        
        if (!$restaurantLocation) {
            throw new RestaurantLocationException("The specified restaurant does not have location information");
        }

        $base_location = [
            'lat' => $restaurantLocation?->lat,
            'long' => $restaurantLocation?->long,
        ];

        $distances = [];


        $locations = RiderLocation::all();

        foreach ($locations as $key => $location)
        {
            $a = $base_location['lat'] - $location['lat'];
            $b = $base_location['long'] - $location['long'];
            $distance = sqrt(($a**2) + ($b**2));
            $distances[$key] = $distance;
        }
        asort($distances);

        $closest = $locations[key($distances)];
        dd($closest);

        return $closest;

        
    }
    
}