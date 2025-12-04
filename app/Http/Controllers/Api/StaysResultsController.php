<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stay;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaysResultsController extends Controller
{
    public function searchingResult(Request $request)
    {
        try {
            $loc = request()->query('loc');
            Log::info('query:', ['loc' => $loc]);
            if (!$loc) {
                return response()->json([]);
            }

            $searchResults = DB::table('stays')
                ->select('stayName', 'location', 'address', 'rating', 'price', 'image')
                ->whereRaw('location LIKE BINARY?', ["%$loc%"])
                ->get();
            Log::info('SQL executed', ['searchResults' => $searchResults]);
            Log::info("Received q:", [$request->loc]);

            return response()->json([
                'q' => $loc,
                'searchResults' => $searchResults,
                'table' => (new Stay)->getTable(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error:' => true,
                'message:' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function getAllResults()
    {
        try {
            $stays = DB::table('stays')
                ->select('stayName', 'location', 'address', 'rating', 'price', 'image')
                ->get();
            return response()->json($stays);
        } catch (Exception $e) {
            return response()->json([
                'error:' => true,
                'message:' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
