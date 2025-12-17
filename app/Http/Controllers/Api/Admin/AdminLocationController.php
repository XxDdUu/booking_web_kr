<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\Admin\AdminLocationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
class AdminLocationController extends Controller
{
    protected AdminLocationService $service;

    public function __construct(AdminLocationService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $locations = $this->service->getLocations();

        return response()->json([
            'ok' => true,
            'data' => $locations
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'locationName' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string',
            'pinCode' => 'required|string',
            'image' => 'nullable|file|image|max:2048',
        ]);

        $location = $this->service->createLocation($validated);

        return response()->json([
            'message' => 'Location created successfully',
            'data' => $location,
            'image_url' => \Storage::url($location->location_image_path),
        ], 201);
    }
    public function put(Request $request)
    {
        $validated = $request->validate([
            'locationName' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'pinCode' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'existing_image_path' => 'nullable|string',
        ]);
        $locationID = $request->route('id');    
    
        $location = $this->service->updateLocation($locationID, $validated);

        return response()->json([
            'message' => 'Location updated successfully',
            'data' => $location
        ], 201);

    }
}
