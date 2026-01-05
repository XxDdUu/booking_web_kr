<?php

namespace App\Providers;

use App\Repositories\Stay\StayRepository;
use App\Repositories\Stay\StayRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Models\Review;
use App\Observers\ReviewObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {   
        $this->app->bind(
            StayRepositoryInterface::class,
            StayRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Review::observe(ReviewObserver::class);
    }
}
