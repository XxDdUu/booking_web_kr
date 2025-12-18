<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\DB;

class BookingService 
{
    protected BookingRepository $bookingRepo;
    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }
    public function createBookingAfterClick($user, $request){
        DB::beginTransaction();

        try {
            // Tạo booking tổng
            $booking = $this->bookingRepo->createBooking($user);

            $bookingItems = [];

            foreach ($request->items as $item) {
                $subtotal = $item['meta']['price'] * $item['quantity'];

                $bookingItem = $this->bookingRepo->createBookingItem($booking, $item, $subtotal);
                if ($bookingItem instanceof \App\Models\BookingItem) {
                    $bookingItems[] = $bookingItem;
                }
            }

            DB::commit();

            return [
                'booking'=> $booking,
                'bookingItem'=> $bookingItems];
        } catch (\Throwable $e) {
            DB::rollBack();
            return ([
                'error' => 'Booking failed',
                'content'=> $e->getMessage()
            ]);
        }
    }

}
