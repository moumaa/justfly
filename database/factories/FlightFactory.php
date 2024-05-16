<?php

namespace Database\Factories;

use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureDate = $this->faker->dateTimeBetween('+1 days', '+400 days');
        $clonedDepartureDate = clone $departureDate;
        $clonedDepartureDate1 = clone $departureDate;
        $clonedDepartureDate2 = clone $departureDate;
        $clonedLowerEndDepartureDate = $clonedDepartureDate1->modify('+90 minutes');
        $clonedHigherEndDepartureDate = $clonedDepartureDate2->modify('+18 hours');
        $arrivalDate = $this->faker->dateTimeBetween($clonedLowerEndDepartureDate, $clonedHigherEndDepartureDate);

        return [
            'airline_id' => Airline::all()->random()->id,
            'number' => fake()->unique()->numberBetween(100,5000),
            'departure_airport_id' => Airport::all()->random()->id,
            'departure_time' => $clonedDepartureDate,
            'arrival_airport_id' => Airport::all()->random()->id,
            'arrival_time' => $arrivalDate,
            'price' => $this->faker->numberBetween(100,1000),
        ];
    }
}
