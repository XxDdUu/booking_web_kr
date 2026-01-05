<?php

namespace App\Services\Staff;

use App\Repositories\Admin\AdminLocationRepository;
use App\Repositories\Admin\AdminCategoryRepository;

class StaffStayFormService
{
    public function __construct(
        protected AdminLocationRepository $locationRepo,
        protected AdminCategoryRepository $categoryRepo,
    ) {}

    public function getFormData(): array
    {
        return [
            'locations'  => $this->locationRepo->getForStayForm(),
            'categories' => $this->categoryRepo->getForStayForm(),
        ];
    }
}
