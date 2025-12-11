<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarRental;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carRentals = require database_path('data/carRentals.php');

        foreach ($carRentals as $item) {
            CarRental::create([
                'locationID' => self::getCarLocationID($item['checkInDestination']),
                'serviceID' => self::getCarServiceID(),
                'carID' => self::getCarID($item['carName']),
                ...$item
            ]);
        }
    }
    public function getCarLocationID(string $val)
    {
        // preload locations
        return DB::table('locations')
            ->whereRaw('? LIKE CONCAT("%", locationName, "%")', [$val])
            ->value('locationID');
    }
    public function getCarServiceID()
    {
        return Service::where('serviceType', 'like', '%car%')
            ->first()
            ->serviceID;
    }
    public function getCarID($val)
    {
        // preload toàn bộ carID, không query 5 lần nữa
        $cars = Car::pluck('carID', 'carName')->toArray();
        return $cars[$val] ?? null;
    }
}
