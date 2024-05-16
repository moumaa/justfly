<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airport>
 */
class AirportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $location = Location::all()->random();
        return [
            'code' => fake()->regexify('/[A-Z]{3}/'),
            'city_id' => $location->id,
            'name' => fake()->name(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'timezone' => \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $location->country_code)[0]
        ];
    }
}
