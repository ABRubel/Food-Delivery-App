<?php

namespace App\Services;
use App\Exceptions\RestaurantLocationException;
use App\Models\RestaurantLocation;
use App\Models\RiderLocation;
use Illuminate\Support\Facades\Cache;

class RestaurantLocationService
{
    /**
     * Get nearest rider location
     *
     * @param int $restaurantId
     * @return object
     */
    public function getLocation($restaurantId)
    {
        $restaurantLocation = RestaurantLocation::find($restaurantId);
        
        if (!$restaurantLocation) {
            throw new RestaurantLocationException("The specified restaurant does not have location information");
        }

        $locations = Cache::get('locations');

        if (!Cache::has('locations')) {
            $locations = RiderLocation::all();
        }         

        if ($locations->count() == 0) {
            throw new RestaurantLocationException("No rider location information is found.");
        }

        $base_location = [
            'lat' => $restaurantLocation?->lat,
            'long' => $restaurantLocation?->long,
        ];

        $distances = [];

        foreach ($locations as $key => $location)
        {
            $a = $base_location['lat'] - $location['lat'];
            $b = $base_location['long'] - $location['long'];
            $distance = sqrt(($a**2) + ($b**2));
            $distances[$key] = $distance;
        }
        asort($distances);

        $closest = $locations[key($distances)];

        return $closest;
    }
    
}