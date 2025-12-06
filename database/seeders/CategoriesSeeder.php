<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['hotel','resort','villa','apartment','motel','hostel'];
        foreach($categories as $cate){
            Category::create(['categoryName'=>$cate]);
        };
    }
}
