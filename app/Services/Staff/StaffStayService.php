<?php
namespace App\Services\Staff;
use App\Repositories\Staff\StaffStayRepository;
use Illuminate\Support\Facades\DB;
use App\Factories\ServiceFactory;
class StaffStayService
{
    public function __construct(
        protected StaffStayRepository $repo
    ) {}

    public function createStay(array $data)
    {
        $serviceID = ServiceFactory::create('stay');

        $data['serviceID'] = $serviceID;

        return DB::transaction(function () use ($data) {
            return $this->repo->create($data);
        });
    }
}
