<?php

namespace App\Observers;

use App\Models\Review;
use App\Services\StayService;

class ReviewObserver
{
    protected StayService $stayService;

    public function __construct(StayService $stayService)
    {
        $this->stayService = $stayService;
    }
    public function created(Review $review): void
    {
        $this->stayService->updateRating($review->serviceID);
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        $this->stayService->updateRating($review->serviceID);
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        $this->stayService->updateRating($review->serviceID);
    }

    /**
     * Handle the Review "restored" event.
     */
    public function restored(Review $review): void
    {
        //
    }

    /**
     * Handle the Review "force deleted" event.
     */
    public function forceDeleted(Review $review): void
    {
        //
    }
}
