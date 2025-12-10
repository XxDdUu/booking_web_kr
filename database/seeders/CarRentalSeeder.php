<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarRental;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carRentals = require database_path('data/carRentals.php');

        $haNoi = Location::where('locationName', 'like', '%Hà Nội%')->first();
        $carService   = Service::where('serviceType', 'like', '%car%')->first();
        $carNameMap = [
            'Mercedes Coupe' => Car::where('carName', 'LIKE', '%Mercedes Coupe%')->first()->carID,
            'Vinfast VF6' => Car::where('carName', 'LIKE', '%Vinfast VF6%')->first()->carID,
            'Ford F-150' => Car::where('carName', 'LIKE', '%Ford F-150%')->first()->carID,
            'Ferrari Purosangue' => Car::where('carName', 'LIKE', '%Ferrari Purosangue%')->first()->carID,
            'Porsche 911' => Car::where('carName', 'LIKE', '%Porsche 911%')->first()->carID,

        ];

        foreach ($carRentals as $item) {
            CarRental::create([
                'locationID' => $haNoi->locationID,
                'serviceID' => $carService->serviceID,
                'carID' => $carNameMap[$item['carName']],
                ...$item
            ]);
        }
    }
}
