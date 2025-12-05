<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationKeywordsController extends Controller
{
    public function getKeywords(Request $request)
    {
        try {
            $q = $request->query('q');

            // Debug: ghi ra log
            Log::info('keyword query:', ['q' => $q]);
            if (!$q) {
                return response()->json([]);
            }

            $keywords = DB::table('locations')
                ->whereRaw("locationName LIKE BINARY ?", ["%$q%"])
                ->pluck('locationName');
            Log::info('SQL executed', ['keywords' => $keywords]);
            Log::info("Received q:", [$request->q]);

            return response()->json([
                'q' => $q,
                'keywords' => $keywords,
                'table' => (new Location)->getTable(),
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
}
