<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => Hash::make('adminpassword'),
            'profile_details' => 'Admin profile details for Admin One',
        ]);
    }
}
