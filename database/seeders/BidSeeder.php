<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bid;
use App\Models\Car;
use App\Models\User;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first(); // Assuming at least one user exists in the database
        $car = Car::first(); // Assuming at least one car exists in the database

        Bid::create([
            'car_id' => $car->id,
            'user_id' => $user->id,
            'bid_price' => 24000.00,
        ]);

        Bid::create([
            'car_id' => $car->id,
            'user_id' => $user->id,
            'bid_price' => 23000.00,
        ]);
    }
}
