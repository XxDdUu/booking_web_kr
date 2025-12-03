<?php

namespace App\Http\Controllers;

use App\Models\Stay;
use App\Models\Stays;
use Illuminate\Http\Request;

class StaysController extends Controller
{
    protected $staysSearch;
    public function search(Request $request){
        $location = $request->query('location');
        $checkIn = $request->query('checkIn');
        $checkOut = $request->query('checkOut');

        if(!$location || !$checkIn || $checkOut){
            return response()->json(
                ['error'=>'Missing required query params'], 
                400
            );
        }

        $stays = Stay::with('rooms')
            ->when($location, function ($query) use ($location) {
                $query->where('City', 'LIKE', "%$location%");
            })
            ->when($checkIn, function ($query) use ($checkIn) {
                $query->where('checkIn', '<=', $checkIn);
            })
            ->when($checkOut, function ($query) use ($checkOut) {
                $query->where('checkOut', '>=', $checkOut);
            })
            ->paginate(10);

        return response()->json([
            'stays' => $stays
        ]);
    }
}
