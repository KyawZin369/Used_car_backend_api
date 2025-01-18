<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('transactions')->insert([
                'user_id' => $faker->numberBetween(1, 4), // Assumes user IDs between 1 and 4
                'car_id' => 1, // Static car ID as specified
                'bid_id' => $faker->optional()->numberBetween(1, 2), // Optional bid ID
                'transaction_date' => $faker->dateTimeBetween('-1 year', 'now'), // Random transaction date
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash']),
                'amount' => $faker->randomFloat(2, 1000, 50000), // Random transaction amount
                'created_at' => now(), // Current timestamp for created_at
                'updated_at' => now(), // Current timestamp for updated_at
            ]);
        }
    }
}
