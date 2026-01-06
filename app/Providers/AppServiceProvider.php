<?php

namespace App\Providers;

use App\Repositories\Stay\StayRepository;
use App\Repositories\Stay\StayRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Models\Review;
use App\Observers\ReviewObserver;
use App\Repositories\Car\CarRentalRepository;
use App\Repositories\Car\CarRentalRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Stay
        $this->app->bind(
            StayRepositoryInterface::class,
            StayRepository::class
        );

        // Car
        $this->app->bind(
            CarRentalRepositoryInterface::class,
            CarRentalRepository::class
        );

        //Attraction
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Review::observe(ReviewObserver::class);
    }
}
