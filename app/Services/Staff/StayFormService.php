<?php

namespace App\Services\Staff;

use App\Repositories\Admin\LocationRepository;
use App\Repositories\Admin\ServiceRepository;
use App\Repositories\Admin\CategoryRepository;

class StayFormService
{
    public function __construct(
        protected LocationRepository $locationRepo,
        protected ServiceRepository  $serviceRepo,
        protected CategoryRepository $categoryRepo,
    ) {}

    public function getFormData(): array
    {
        return [
            'locations'  => $this->locationRepo->getForStayForm(),
            'services'   => $this->serviceRepo->getForStayForm(),
            'categories' => $this->categoryRepo->getForStayForm(),
        ];
    }
}
