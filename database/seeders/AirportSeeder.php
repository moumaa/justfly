<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Location;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airport::factory()->create([
            'code' => 'YUL',
            'city_id' => '1',
            'name' => 'Pierre Elliott Trudeau International',
            'latitude' => 45.457714,
            'longitude' => -73.749908,
            'timezone' => 'America/Montreal'
        ]);

        Airport::factory()->create([
            'code' => 'YVR',
            'city_id' => '2',
            'name' => 'Vancouver International',
            'latitude' => 49.194698,
            'longitude' => -123.179192,
            'timezone' => 'America/Vancouver'
        ]);

        Airport::factory()->create([
            'code' => 'LAX',
            'city_id' => '3',
            'name' => 'Los Angeles International',
            'latitude' => 33.943,
            'longitude' => -118.407,
            'timezone' => 'America/Los_Angeles'
        ]);

        Airport::factory()->create([
            'code' => 'CDG',
            'city_id' => '4',
            'name' => 'Charles De Gaulle',
            'latitude' => 49.017,
            'longitude' => 2.55,
            'timezone' => 'Europe/Paris'
        ]);

        Airport::factory()->create([
            'code' => 'LHR',
            'city_id' => '5',
            'name' => 'London Heathrow',
            'latitude' => 51.47,
            'longitude' => -0.451,
            'timezone' => 'Europe/London'
        ]);

        Airport::factory(5)->create();
    }
}
