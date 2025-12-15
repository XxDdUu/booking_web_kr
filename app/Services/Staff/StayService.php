<?php
namespace App\Services\Staff;
use App\Repositories\Staff\StayRepository;
use Illuminate\Support\Facades\DB;
class StayService
{
    public function __construct(
        protected StayRepository $repo
    ) {}

    public function createStay(array $data)
    {
         return DB::transaction(function () use ($data) {
            return $this->repo->create($data);
        });
    }
}
