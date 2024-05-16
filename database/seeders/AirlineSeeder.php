<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airline::factory()->create([
            'iata_code' => 'AA',
            'name' => 'American Airlines'
        ]);
        Airline::factory()->create([
            'iata_code' => 'DL',
            'name' => 'Delta Airlines'
        ]);
        Airline::factory()->create([
            'iata_code' => 'AC',
            'name' => 'Air Canada'
        ]);
        Airline::factory()->create([
            'iata_code' => 'AF',
            'name' => 'Air France'
        ]);
        Airline::factory()->create([
            'iata_code' => 'EK',
            'name' => 'Emirates'
        ]);

        Airline::factory(15)->create();
    }
}
