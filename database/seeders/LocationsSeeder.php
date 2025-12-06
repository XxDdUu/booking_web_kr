<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = ['Hà Nội', 'Đà Nẵng', 'TP. Hồ Chí Minh', 'Huế', 'Hạ Long Bay', 
        'Hà Giang', 'Sapa', 'Đà Lạt', 'Vũng Tàu', 'Nha Trang', 'Quy Nhơn', 'Ninh Bình', 
        'Hội An', 'Cần Thơ', 'Phú Quốc'];
        foreach($locations as $name){
            Location::create(['locationName'=>$name]);
        }
    }
}
