<?php

namespace App\Services;
use App\Repositories\ReviewRepository;
class ReviewService
{
    public function __construct(
        protected ReviewRepository $repo
    ) {}

    public function createReview(array $data)
    {
        return $this->repo->create($data);
    }
    public function deleteReview(string $reviewID, string $userID) {
        return $this->repo->delete($reviewID, $userID);
    }
}
