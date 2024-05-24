<?php

namespace App\Services;

use App\Http\Requests\TripBuildRequest;
use App\Models\Flight;
use App\Models\Trip;
use App\Models\TripFlight;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BuildTripService
{
    /**
     * @param TripBuildRequest $request
     * @return array
     * @throws \Exception
     */
    public function getInputFlightsData(TripBuildRequest $request): array {
        // return data array (from flights) to use in the front end

        $tripType = $request->trip_type;
        $flightsNumbers = preg_split('/\s*,\s*/', trim($request->flights), -1, PREG_SPLIT_NO_EMPTY);

        $tripFlightsData = [];
        $tripFlightsData['trip_type'] = $tripType;
        $tripTotalPrice = 0;

        $inputFlights = Flight::whereIn('number', $flightsNumbers)->orderBy('departure_time')->get();

        if ($inputFlights->isEmpty()) {
            throw new \Exception('Input flight data failure. No Trip was created.');
        }

        foreach ($inputFlights as $flight) {
            $tripFlightsData['flights'][$flight->id]['number'] = $flight->number;
            $tripFlightsData['flights'][$flight->id]['from'] =
                '('.$flight->departedFromAirport->code.') '.$flight->departedFromAirport->name
                . ' ['.$flight->departedFromAirport->location->city . ']'
                . ' on ' . $flight->departure_time;
            $tripFlightsData['flights'][$flight->id]['to'] =
                '('.$flight->arrivedAtAirport->code.') '.$flight->arrivedAtAirport->name
                . ' ['.$flight->arrivedAtAirport->location->city . ']'
                . ' on ' . $flight->arrival_time;;
            $tripFlightsData['flights'][$flight->id]['price'] = $flight->price;
            $tripTotalPrice += $flight->price;
        }

        $tripFlightsData['total_price'] = $tripTotalPrice;

        return $tripFlightsData;
    }

    /**
     * @param Trip $trip
     * @param array $flights
     * @return void
     * @throws \Exception
     */
    protected function verifyTripDateLimit(Trip $trip, Array $flights) {
        // make sure the first flight of the trip is after the creation of the trip.
        // also make sure the first flight of the trip isn't over a year away.

        if ($trip == null) {
            throw new \Exception('Trip missing.');
        }
        if (count($flights) == 0) {
            throw new \Exception('Flights missing.');
        }

        foreach ($trip->flights as $flight) {
            if ($flight->departure_time < date('Y-m-d H:i:s')) {
                throw new \Exception('Flight #'. $flight->number . ' has already departed.');
            }
        }

        $clonedTripCreateAt = clone $trip->created_at;
        if ($trip->created_at > $flights[0]->departure_time || $clonedTripCreateAt->modify('+1 year') < $flights[0]->departure_time) {
            throw new \Exception('A trip MUST depart after creation time at the earliest or 365 days after creation time at the latest');
        }
    }

    /**
     * @param Flight|null $flight
     * @param string $tripType
     * @return array|string[]|null
     */
    public function buildOneWayTrip(?Flight $flight, string $tripType): array|null {
        if ($flight != null) {
            try {
                DB::transaction(function () use ($flight, $tripType, &$newTrip) {

                    $newTrip = Trip::create([
                        'trip_type' => $tripType
                    ]);

                    TripFlight::create([
                        'trip_id' => $newTrip->id,
                        'flight_id' => $flight->id
                    ]);

                    $this->verifyTripDateLimit($newTrip, [$flight]);
                });
                return ['success' => $tripType . ' trip #'.$newTrip->id.' created successfully.'];
            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
        }

        return null;
    }

    /**
     * @param Collection $flights
     * @return bool
     */
    protected function verifyFlightsTimingsArePossible(Collection $flights): bool {

        // Make sure that the connected flights are humanly possible.
        // The following flight cannot be departing before the previous flight arrives.
        $validFlightConnectionTiming = false;
        for ($i = 1; $i < count($flights)-1; $i++) {
            $validFlightConnectionTiming = $flights[$i]->arrival_time < $flights[$i-1]->departure_time;

            if (!$validFlightConnectionTiming) {
                return false;
            }
        }

        return $validFlightConnectionTiming;
    }

    /**
     * @param Collection $flights
     * @param string $tripType
     * @param $newTrip
     * @return array|string[]|null
     */
    public function buildRoundTripTrip(Collection $flights, string $tripType, $newTrip = null): array|null {

        try {
            // make sure the two flights for ma round way trip
            $isValidRoundTrip = $flights[0]->arrival_airport_id == $flights[1]->departure_airport_id &&
                $flights[1]->arrival_airport_id == $flights[0]->departure_airport_id;

            if (!$isValidRoundTrip) {
                return ['error' => 'Not a valid round trip trip.'];
            }

            if ($this->verifyFlightsTimingsArePossible($flights)) {
                return ['error' => 'Flight timings not possible. Departure occurs before arrival of previous flight'];
            }



            DB::transaction(function () use ($flights, $tripType, &$newTrip) {

                $newTrip = Trip::create([
                    'trip_type' => $tripType
                ]);

                foreach($flights as $flight) {
                    TripFlight::create([
                        'trip_id' => $newTrip->id,
                        'flight_id' => $flight->id
                    ]);
                }
            });
            return ['success' => $tripType . ' trip #'.$newTrip->id.' created successfully.'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @param Collection $flights
     * @param string $tripType
     * @param $newTrip
     * @return array|string[]|null
     */
    public function buildOpenJawTrip(Collection $flights, string $tripType, $newTrip = null): array|null {

        try {
            // make sure the flights form a A->B, C->A pattern
            $isValidOpenJawTrip = $flights[0]->arrival_airport_id == $flights[1]->departure_airport_id &&
                $flights[1]->arrival_airport_id != $flights[0]->departure_airport_id;

            if (!$isValidOpenJawTrip) {
                return ['error' => 'Not a valid open jaw trip.'];
            }

            if ($this->verifyFlightsTimingsArePossible($flights)) {
                return ['error' => 'Flight timings not possible. Departure occurs before arrival of previous flight'];
            }

            DB::transaction(function () use ($flights, $tripType, &$newTrip) {

                $newTrip = Trip::create([
                    'trip_type' => $tripType
                ]);

                foreach($flights as $flight) {
                    TripFlight::create([
                        'trip_id' => $newTrip->id,
                        'flight_id' => $flight->id
                    ]);
                }
            });
            return ['success' => $tripType . ' trip #'.$newTrip->id.' created successfully.'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @param Collection $flights
     * @param string $tripType
     * @param $newTrip
     * @return array|string[]|null
     */
    public function buildMultiCityTrip(Collection $flights, string $tripType, $newTrip = null): array|null {
        try {
            // make sure the flights form a A->B, B->C, C->D, etc pattern
            for ($i = 0; $i < count($flights)-1; $i++) {
                $validFlightConnection = $flights[$i]->arrival_airport_id == $flights[$i+1]->departure_airport_id &&
                    $flights[$i+1]->arrival_airport_id != $flights[$i]->departure_airport_id;

                if (!$validFlightConnection) {
                    return ['error' => 'Not a valid open multi city trip. One or more flights are not connected'];
                }
            }

            if ($this->verifyFlightsTimingsArePossible($flights)) {
                return ['error' => 'Flight timings not possible. Departure occurs before arrival of previous flight'];
            }

            DB::transaction(function () use ($flights, $tripType, &$newTrip) {
                for ($i = 0; $i < count($flights)-1; $i++) {
                    if ($flights[$i]->arrival_airport_id != $flights[$i+1]->departure_airport_id) {
                        throw new \Exception('Arrival airport for flight ' . $flights[$i]->number
                            . ' does not match departure airport for flight ' . $flights[$i+1]->number);
                    }
                }

                $newTrip = Trip::create([
                    'trip_type' => $tripType
                ]);
                foreach($flights as $flight) {
                    TripFlight::create([
                        'trip_id' => $newTrip->id,
                        'flight_id' => $flight->id
                    ]);
                }
            });
            return ['success' => $tripType . ' trip #'.$newTrip->id.' created successfully.'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
