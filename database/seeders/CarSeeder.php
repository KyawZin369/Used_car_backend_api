<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first(); // Assuming at least one user exists in the database

        Car::create([
            'user_id' => $user->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'registration_year' => 2020,
            'price' => 25000.00,
            'picture_url' => 'https://example.com/toyota-camry.jpg',
        ]);

        Car::create([
            'user_id' => $user->id,
            'make' => 'Honda',
            'model' => 'Civic',
            'registration_year' => 2021,
            'price' => 22000.00,
            'picture_url' => 'https://example.com/honda-civic.jpg',
        ]);
    }
}
