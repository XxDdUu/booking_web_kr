<?php

namespace App\Services;

use App\Repositories\StayRepository;
use Illuminate\Support\Collection;

class StayService
{
    public function __construct(
        protected StayRepository $repo
    ) {}

    public function getCardStays(): Collection
    {
        return $this->repo->getStaysForCard(8);
    }
}
