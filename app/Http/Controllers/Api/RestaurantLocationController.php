<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\RestaurantLocationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatNearestRiderRequest;
use App\Services\RestaurantLocationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestaurantLocationController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new RestaurantLocationService();
    }
    /**
     * Get nearest rider.
    */
    public function getNearestRider(CalculatNearestRiderRequest $request)
    {
        try {
            $location = $this->service->getLocation($request->restaurant_id);

            return response()->json(['message' => 'Nearest rider is found.', 'location' => $location], 200);
        } catch (RestaurantLocationException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        } catch (Exception $e) {
            Log::error('Error on calulating rider location'. $e->getMessage());
            return response()->json(['message' => "Sorry, an unexpected error occured."], 401);
        }

    }
}
