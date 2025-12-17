<?php
namespace App\Services\Staff;
use App\Repositories\Staff\StaffStayRepository;
use Illuminate\Support\Facades\DB;
class StaffStayService
{
    public function __construct(
        protected StaffStayRepository $repo
    ) {}

    public function createStay(array $data)
    {
         return DB::transaction(function () use ($data) {
            return $this->repo->create($data);
        });
    }
}
