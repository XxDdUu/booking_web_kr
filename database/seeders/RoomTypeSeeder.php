<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        $roomTypes = require database_path('data/roomType.php');

        foreach ($roomTypes as $type) {
            RoomType::create([
                'roomType' => $type,
            ]);
        }
    }
}