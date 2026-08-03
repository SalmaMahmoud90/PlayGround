<?php

namespace Database\Seeders;

use App\Models\Playground;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayGroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Playground::create([
            'location' => 'Al Hamra Street',
            'city' => 'Latakia',
            'type' => 'Football',
            'image' => 'playground1.jpg',
            'hourPrice' => 50,
            'hourWork' => 12,
            'minHours' => 1,
            'maxHours' => 5,
        ]);
    }
}
