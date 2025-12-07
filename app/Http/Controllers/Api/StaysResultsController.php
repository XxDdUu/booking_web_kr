<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stay;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaysResultsController extends Controller
{
    public function searchingResult(Request $request)
    {
        try {
            $loc      = $request->query('location');
            $checkIn  = $request->query('checkin');
            $checkOut = $request->query('checkout');

            Log::info('Search query:', [
                'location' => $loc,
                'checkin' => $checkIn,
                'checkout' => $checkOut
            ]);

            // Nếu không có location → trả rỗng
            if (!$loc) {
                return response()->json([]);
            }

            // 1. Query stays theo location
            $stays = DB::table('stays')
                ->select('stayID', 'stayName', 'location', 'address', 'rating', 'price', 'image')
                ->whereRaw('location LIKE BINARY ?', ["%$loc%"])
                ->get();
                // ->map(function ($stay) {
                //     // Ép kiểu về dạng number đúng chuẩn
                //     $stay->rating = (float) $stay->rating;
                //     $stay->price = (float) $stay->price;
                //     return $stay;
                // });

            // Nếu có check-in và check-out thì tính days + totalPrice
            if ($checkIn && $checkOut) {
                $days = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));

                // Thêm field mới cho từng stay
                $stays = $stays->map(function ($stay) use ($days) {
                    $stay->days = $days;
                    $stay->totalPrice = $stay->price * $days;
                    return $stay;
                });
            }

            return response()->json([
                'location' => $loc,
                'days' => $checkIn && $checkOut ? Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)) : null,
                'results' => $stays
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
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
