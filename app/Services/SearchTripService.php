<?php

namespace App\Services;

use App\Models\Flight;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchTripService
{
    /**
     * @param array $requestData
     * @return Collection
     */
    public function getOneWayTrips(Array $requestData): Collection {
        $departureAirport = $requestData['departure_airport'];
        $arrivalAirport = $requestData['arrival_airport'];
        $airlineCode = $requestData['airline_code'];
        $departureDate = $requestData['departure_date'];

        $trips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
            ->where('trip_type', config('enums.trip_types.one_way'));


        if ($departureAirport != null) {
            $trips = $trips->whereHas('flights.departedFromAirport', function($query) use ($departureAirport) {
                $query->where('code', $departureAirport);
            });
        }
        if ($arrivalAirport != null) {
            $trips = $trips->whereHas('flights.arrivedAtAirport', function($query) use ($arrivalAirport) {
                $query->where('code', $arrivalAirport);
            });
        }
        if ($airlineCode != null) {
            $trips = $trips->whereHas('flights.airline', function($query) use ($airlineCode) {
                $query->where('iata_code', $airlineCode);
            });
        }

        if ($departureDate != null) {
            $trips = $trips->whereHas('flights', function($query) use ($departureDate) {
                $query->whereDate('departure_time', $departureDate);
            });
        }

        return $trips->get();
    }

    /**
     * @param array $requestData
     * @return \Illuminate\Support\Collection
     */
    public function getRoundTripTrips(Array $requestData): \Illuminate\Support\Collection
    {
        $departureAirport = $requestData['departure_airport'];
        $arrivalAirport = $requestData['arrival_airport'];
        $airlineCode = $requestData['airline_code'];
        $departureDate = $requestData['departure_date'];
        $returnDate = $requestData['return_date'];


        $departureTrips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
            ->where('trip_type', config('enums.trip_types.round_trip'));
        $arrivalTrips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
            ->where('trip_type', config('enums.trip_types.round_trip'));


        if ($departureAirport != null) {
            $departureTrips = $departureTrips->whereHas('flights.departedFromAirport', function($query) use ($departureAirport) {
                $query->where('code', $departureAirport);
            });
        }
        if ($arrivalAirport != null) {
            $departureTrips = $departureTrips->whereHas('flights.arrivedAtAirport', function($query) use ($arrivalAirport) {
                $query->where('code', $arrivalAirport);
            });
        }
        if ($airlineCode != null) {
            $departureTrips = $departureTrips->whereHas('flights.airline', function($query) use ($airlineCode) {
                $query->where('iata_code', $airlineCode);
            });
            $arrivalTrips = $arrivalTrips->whereHas('flights.airline', function($query) use ($airlineCode) {
                $query->where('iata_code', $airlineCode);
            });
        }

        if ($departureAirport != null) {
            $arrivalTrips = $arrivalTrips->whereHas('flights.departedFromAirport', function($query) use ($arrivalAirport) {
                $query->where('code', $arrivalAirport);
            });
        }
        if ($arrivalAirport != null) {
            $arrivalTrips = $arrivalTrips->whereHas('flights.arrivedAtAirport', function($query) use ($departureAirport) {
                $query->where('code', $departureAirport);
            });
        }

        if ($departureDate != null) {
            $departureTrips = $departureTrips->whereHas('flights', function($query) use ($departureDate) {
                $query->whereDate('departure_time', $departureDate);
            });
        }

        if ($returnDate != null) {
            $arrivalTrips = $arrivalTrips->whereHas('flights', function($query) use ($returnDate) {
                $query->whereDate('arrival_time', $returnDate);
            });
        }

        if ($departureTrips->get()->isNotEmpty() || $arrivalTrips->get()->isNotEmpty()) {
            return $departureTrips->get()->merge($arrivalTrips->get());
        }

        return collect();
    }

    /**
     * @param array $requestData
     * @return void
     */
    public function getOpenJawTrips(Array $requestData) {
    }

    /**
     * @param array $requestData
     * @return void
     */
    public function getMultiCityTrips(Array $requestData) {
    }

    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function getFlights(Array $requestData): LengthAwarePaginator {
        $departureAirport = $requestData['departure_airport'] ?? null;
        $arrivalAirport = $requestData['arrival_airport']  ?? null;
        $airlineCode = $requestData['airline_code']  ?? null;
        $departureDate = $requestData['departure_date'] ?? null;
        $arrivalDate = $requestData['arrival_date'] ?? null;

        $flights =  Flight::query()->with('departedFromAirport.location', 'arrivedAtAirport.location', 'airline');

        if ($departureAirport != null) {
            $flights =  $flights
                ->whereHas('departedFromAirport', function($query) use ($departureAirport) {
                    $query->where('code', $departureAirport);
                });
        }

        if ($arrivalAirport != null) {
            $flights =  $flights
                ->whereHas('arrivedAtAirport', function($query) use ($arrivalAirport) {
                    $query->where('code', $arrivalAirport);
                });
        }

        if ($airlineCode != null) {
            $flights =  $flights
                ->whereHas('airline', function($query) use ($airlineCode) {
                    $query->where('iata_code', $airlineCode);
                });
        }

        if ($departureDate != null) {
            $flights =  $flights->whereDate('departure_time', $departureDate);
        }

        if ($arrivalDate != null) {
            $flights =  $flights->whereDate('arrival_time', $arrivalDate);
        }


        return $flights->paginate(10)->withQueryString();
    }
}
