<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Category;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttractionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attractions = require database_path('data/attractions.php');

        $daNang = Location::where('locationName', 'like', '%Đà Nẵng%')->first();
        $attService   = Service::where('serviceType', 'like', '%attraction%')->first();

        $tour = Category::where('categoryName', 'like', '%tour%')->first();
        $museum = Category::where('categoryName', 'like', '%bảo tàng%')->first();
        $outdoor = Category::where('categoryName', 'like', '%hoạt động ngoài trời%')->first();
        $show_ent = Category::where('categoryName', 'like', '%thưởng thức & giải trí%')->first();
        $workshop = Category::where('categoryName', 'like', '%lớp học & workshop%')->first();

        $categoryMap = [
            'tour' => $tour->categoryID,
            'bảo tàng' => $museum->categoryID,
            'hoạt động ngoài trời' => $outdoor->categoryID,
            'show' => $show_ent->categoryID,
            'giải trí' => $show_ent->categoryID,
            'workshop' => $workshop->categoryID,
            'lớp học' => $workshop->categoryID,
        ];

        foreach ($attractions as $item) {
            Attraction::create([
                'locationID' => $daNang->locationID,
                'categoryID' => $categoryMap[$item['category']],
                'serviceID'  => $attService->serviceID,
                ...$item
            ]);
        }
    }
}
