<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LocationSeeder::class);
        $this->call(AirlineSeeder::class);
        $this->call(AirportSeeder::class);
        $this->call(FlightSeeder::class);
        $this->call(TripSeeder::class);
        $this->call(TripFlightSeeder::class);
    }
}
