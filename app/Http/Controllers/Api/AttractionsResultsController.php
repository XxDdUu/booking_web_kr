<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Attraction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttractionsResultsController extends Controller
{
    public function searchingResults(Request $request)
    {
        try {
            $loc = $request->query('location');
            $checkDate  = $request->query('checkdate');

            Log::info('Search query:', [
                'location' => $loc,
                'checkdate' => $checkDate,
            ]);

            // Nếu không có location → trả rỗng
            if (!$loc) {
                return response()->json([]);
            }
            // 1. Query stays theo location
            $attractions = DB::table('attractions')
                ->join('locations', 'attractions.locationID', '=', 'locations.locationID')
                ->select(
                    'attractions.attractionID',
                    'attractions.attractionName',
                    'attractions.duration',
                    'attractions.rate',
                    'attractions.price',
                    'attractions.image',
                    'locations.locationName'
                )
                ->whereRaw('locations.locationName LIKE BINARY ?', ["%$loc%"])
                ->get()
                ->map(function ($attractions) {
                    $attractions->rate = (float)$attractions->rate;
                    $attractions->price = (float)$attractions->price;
                    return $attractions;
                });

            return response()->json([
                'location' => $loc,
                'results' => $attractions
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
