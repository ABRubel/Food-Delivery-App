<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRiderLocationRequest;
use App\Models\RiderLocation;
use Exception;
use Illuminate\Http\Request;

class RiderLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRiderLocationRequest $request)
    {
        try {
            $riderLocation = RiderLocation::updateOrCreate(['rider_id' => $request->rider_id], $request->validated());

            return response()->json(['message' => 'Rider location was successfully stored.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Sorry, an unexpected error occured.'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RiderLocation $riderLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiderLocation $riderLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiderLocation $riderLocation)
    {
        //
    }
}
