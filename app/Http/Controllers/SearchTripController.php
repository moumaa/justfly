<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Services\SearchTripService;
use Illuminate\Http\Request;

class SearchTripController
{

    /**
     * @var SearchTripService
     */
    protected SearchTripService $searchTripService;

    /**
     * @param SearchTripService $searchTripService
     */
    public function __construct(SearchTripService $searchTripService)
    {
        $this->searchTripService = $searchTripService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index () {

        // by default, show all the one way trips on the Brows Trips page

        $trips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
            ->where('trip_type', config('enums.trip_types.one_way'))->get();

        return view('searchTrips', compact(['trips']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function search(Request $request){
        $search = $request->input();
        $searchTripType = $search['trip_type'];

        $trips = null;

        // depending on which trip type was selected, run corresponding search methods from the seervice class

        if (isset($search['trip_type']) && $searchTripType == config('enums.trip_types.one_way')) {

            $trips = $this->searchTripService->getOneWayTrips($search);
        } elseif ((isset($search['trip_type']) && $searchTripType == config('enums.trip_types.round_trip'))) {

            $trips = $this->searchTripService->getRoundTripTrips($search);
        } elseif ((isset($search['trip_type']) && $searchTripType == config('enums.trip_types.open_jaw'))) {

            $trips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
                ->where('trip_type', config('enums.trip_types.open_jaw'));

            $airlineCode = $search['airline_code'];
            if ($airlineCode != null) {
                $trips = $trips->whereHas('flights.airline', function($query) use ($airlineCode) {
                    $query->where('iata_code', $airlineCode);
                });
            }
            $trips = $trips->get();
        } elseif ((isset($search['trip_type']) && $searchTripType == config('enums.trip_types.multi_city'))) {

            $trips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
                ->where('trip_type', config('enums.trip_types.multi_city'));

            $airlineCode = $search['airline_code'];
            if ($airlineCode != null) {
                $trips = $trips->whereHas('flights.airline', function($query) use ($airlineCode) {
                    $query->where('iata_code', $airlineCode);
                });
            }
            $trips = $trips->get();
        }

        return view('searchTrips', compact(['trips', 'search']));
    }
}
