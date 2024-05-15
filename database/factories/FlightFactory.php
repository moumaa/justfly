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
        $departureDate = $this->faker->dateTimeBetween('now', '+100 days');
        $arrivalDate = $this->faker->dateTimeBetween($departureDate, '+100 days');
        return [
            'airline_id' => Airline::factory()->create()->id,
            'number' => fake()->numberBetween(100,1000),
            'departure_airport_id' => Airport::factory()->create()->id,
            'departure_time' => $departureDate,
            'arrival_airport_id' => Airport::factory()->create()->id,
            'arrival_time' => $arrivalDate,
            'price' => $this->faker->numberBetween(100,1000),
        ];
    }
}
