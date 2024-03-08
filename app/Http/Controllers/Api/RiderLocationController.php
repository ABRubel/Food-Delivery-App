<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRiderLocationRequest;
use App\Models\RiderLocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RiderLocationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRiderLocationRequest $request)
    {
        try {
            // Depends on the business logic, could have use checking to make sure that the same rider location cannot be stored multiple times
            $riderLocation = RiderLocation::updateOrCreate(['rider_id' => $request->rider_id], $request->validated());
            // use caching as the number of requests for this query will be many
            $locations = Cache::remember('locations', 60 * 60, function () {
                return RiderLocation::all();
            }); 

            return response()->json(['message' => 'Rider location was successfully stored.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Sorry, an unexpected error occured.'], 401);
        }
    }
}
