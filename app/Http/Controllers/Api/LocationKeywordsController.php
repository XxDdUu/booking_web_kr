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

            // $keywords = DB::table('locations')
            //     ->whereRaw("locationName LIKE BINARY ?", ["%$q%"])
            //     ->pluck('locationName');
            $mock = [
                'Đà Nẵng',
                'Nha Trang',
                'Hà Nội',
                'Sapa',
                'Cần Thơ',
                ' Huế',
                'TP. Hồ Chí Minh',
                'Ninh Bình',
                'Quy Nhơn',
                'Vũng Tàu',
                'Hội An',
                'Hạ Long Bay',
                'Phú Quốc',
                'Đà Lạt',
                'Hà Giang'
            ];
            // Lọc keyword theo q
            $keywords = array_values(array_filter($mock, function ($mock) use ($q) {
                return mb_stripos($mock, $q) !== false; // Không phân biệt hoa/thường
            }));
            Log::info('SQL executed', ['keywords' => $mock]);
            Log::info("Received q:", [$request->q]);

            return response()->json([
                'q' => $q,
                'keywords' => $keywords
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
