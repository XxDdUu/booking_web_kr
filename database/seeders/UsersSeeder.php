<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        // 5 ADMIN
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Admin $i",
                'email' => "admin{$i}@example.com",
                'phone' => "09000000{$i}",
                'language' => 'vi',
                'role' => 'admin',
                'password' => '11111111',
            ]);
        }

        // 5 STAFF
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Staff $i",
                'email' => "staff{$i}@example.com",
                'phone' => "09100000{$i}",
                'language' => 'vi',
                'role' => 'staff',
                'password' => '11111111',
            ]);
        }

        // 5 CUSTOMER
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Customer $i",
                'email' => "customer{$i}@example.com",
                'phone' => "09200000{$i}",
                'language' => 'vi',
                'role' => 'customer',
                'password' => '11111111',
            ]);
        }
    }
}
