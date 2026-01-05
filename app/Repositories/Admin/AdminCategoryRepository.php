<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use Illuminate\Support\Collection;

class AdminCategoryRepository
{
    public function getForStayForm(): Collection
    {
        return Category::query()
            ->select('categoryID', 'categoryName')
            ->orderBy('categoryName')
            ->get();
    }
}
