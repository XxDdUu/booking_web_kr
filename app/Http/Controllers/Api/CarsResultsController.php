<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarsResultsController extends Controller
{
    public function searchingResults(Request $request)
    {
        try {
            $loc      = $request->query('location');
            $checkIn  = $request->query('checkin');
            $checkOut = $request->query('checkout');

            Log::info('Search query - cars:', [
                'location' => $loc,
                'checkin' => $checkIn,
                'checkout' => $checkOut
            ]);

            // Nếu không có location → trả rỗng
            if (!$loc) {
                return response()->json([]);
            }

            // 1. Query stays theo location
            $carRental = DB::table('carRentals')
                ->join('cars', 'carRentals.carID', '=', 'cars.carID')
                ->select(
                    'carRentalID',
                    'cars.seatQuantity',
                    'cars.luggageQuantity',
                    'cars.mileageLimit',
                    'cars.image',
                    'carRentals.carName',
                    'carRentals.checkInDestination',
                    'carRentals.price',
                    'carRentals.rate',
                )
                ->whereRaw('carRentals.checkInDestination LIKE BINARY ?', "%$loc%")
                ->get()
                ->map(function ($carRental) {
                    // Ép kiểu về dạng number đúng chuẩn
                    $carRental->rate = (float) $carRental->rate;
                    $carRental->price = (float) $carRental->price;
                    return $carRental;
                });

            // Nếu có check-in và check-out thì tính days + totalPrice
            if ($checkIn && $checkOut) {
                $days = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));

                // Thêm field mới cho từng stay
                $carRental = $carRental->map(function ($carRental) use ($days) {
                    $carRental->days = $days;
                    $carRental->totalPrice = $carRental->price * $days;
                    return $carRental;
                });
            }

            return response()->json([
                'location' => $loc,
                'days' => $checkIn && $checkOut ? Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)) : null,
                'results' => $carRental
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
