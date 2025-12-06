<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Service;
use App\Models\Stay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $stays = require database_path('data/stays.php');

    $daNang = Location::where('locationName','like','%Đà Nẵng%')->first();
    $hotelCategory = Category::where('categoryName','like','%hotel%')->first();
    $stayService   = Service::where('serviceType','like','%stay%')->first();

    foreach ($stays as $item) {
        Stay::create([
            'locationID' => $daNang->locationID,
            'categoryID' => $hotelCategory->categoryID,
            'serviceID'  => $stayService->serviceID,
            ...$item
        ]);
    }
}

}
