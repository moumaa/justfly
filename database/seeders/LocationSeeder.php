<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::factory()->create([
            'city' => 'Montreal',
            'region_code' => 'QC',
            'country_code' => 'CA',
        ]);

        Location::factory()->create([
            'city' => 'Vancouver',
            'region_code' => 'BC',
            'country_code' => 'CA',
        ]);

        Location::factory()->create([
            'city' => 'Los Angeles',
            'region_code' => 'CA',
            'country_code' => 'US',
        ]);

        Location::factory()->create([
            'city' => 'Paris',
            'region_code' => 'PAR',
            'country_code' => 'FR',
        ]);

        Location::factory()->create([
            'city' => 'London',
            'region_code' => 'LDN',
            'country_code' => 'GB',
        ]);

        Location::factory(5)->create();
    }
}
