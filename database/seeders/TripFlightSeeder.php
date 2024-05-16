<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Flight;
use App\Models\Trip;
use App\Models\TripFlight;
use Illuminate\Database\Seeder;

class TripFlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allOneWayTrips = Trip::where('trip_type', config('enums.trip_types.one_way'))->get();

        foreach($allOneWayTrips as $trip) {
            TripFlight::factory()->create([
                'trip_id' => $trip->id,
                'flight_id' => Flight::all()->random()->id
            ]);
        }
    }
}
