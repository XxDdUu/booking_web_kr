<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\LocationService;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $service
    ) {}
    public function getKeywords(Request $request)
    {
        try {
            $q = $request->query('q');

            if (!$q) {
                return response()->json([]);
            }

            return response()->json([
                'keywords' => $this->service->searchLocationKeywords($q) 
            ]);
        } catch (\Exception $e) {
            // debug
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
    public function homepage(LocationService $service)
    {
        return response()->json([
            'locations' => $service->getHomepageLocations()
        ]);
    }
}
