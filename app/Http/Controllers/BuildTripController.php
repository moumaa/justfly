<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightSearchRequest;
use App\Http\Requests\TripBuildRequest;
use App\Models\Flight;
use App\Models\Trip;
use App\Services\BuildTripService;
use App\Services\SearchTripService;
use Illuminate\Http\Request;

class BuildTripController
{
    /**
     * @var BuildTripService
     */
    protected BuildTripService $buildTripService;
    /**
     * @var SearchTripService
     */
    protected SearchTripService $searchTripService;

    /**
     * @param BuildTripService $buildTripService
     * @param SearchTripService $searchTripService
     */
    public function __construct(
        BuildTripService $buildTripService,
        SearchTripService $searchTripService)
    {
        $this->buildTripService = $buildTripService;
        $this->searchTripService = $searchTripService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index () {

        // by default, show a paginated list of all flights on the create trip page to help the user decide which flights build a trip with
        $flights =  Flight::query()->with('departedFromAirport.location', 'arrivedAtAirport.location', 'airline')
            ->paginate(10);

        return view('createTrip', compact(['flights']));
    }

    /**
     * @param TripBuildRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function getTripDataBeforeCreation (TripBuildRequest $request) {

        // after choosing your flights, this will get the relevant trip flights data for the confirm page.
        // It shows you an easy to read table of the flights information before you confirm the creating the flight
        try {
            $tripFlightsData = $this->buildTripService->getInputFlightsData($request);
        } catch (\Exception $e) {
            $flights =  Flight::query()->with('departedFromAirport.location', 'arrivedAtAirport.location', 'airline')->paginate(10);
            $errorMessage = $e->getMessage();
            return view('createTrip', compact(['flights', 'errorMessage']));
        }


        return view('tripConfirm', compact(['tripFlightsData']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createTrip (Request $request) {
        $search = $request->input();
        $flightIds = array_keys($search['tripFlightsData']['flights']);
        $tripType = $search['tripFlightsData']['trip_type'];

        // depending on what kind of trip you create, the corresponding method from the service class will be run.
        // each method has custom validations to make sure creating the corresponding trip is possible with the user's input

        if (count($flightIds) == 1 && $tripType == config('enums.trip_types.one_way')) {
            $flight = Flight::where('id', $flightIds[0])->first();
            $message = $this->buildTripService->buildOneWayTrip($flight, $tripType);
        } elseif (count($flightIds) == 2 && $tripType == config('enums.trip_types.round_trip')) {
            $flights = Flight::whereIn('id', $flightIds)->orderBy('departure_time')->get();
            $message = $this->buildTripService->buildRoundTripTrip($flights, $tripType);
        } elseif (count($flightIds) == 2 && $tripType == config('enums.trip_types.open_jaw')) {
            $flights = Flight::whereIn('id', $flightIds)->orderBy('departure_time')->get();
            $message = $this->buildTripService->buildOpenJawTrip($flights, $tripType);
        } elseif (count($flightIds) > 1 && count($flightIds) <=  5 && $tripType == config('enums.trip_types.multi_city')) {
            $flights = Flight::whereIn('id', $flightIds)->orderBy('departure_time')->get();
            $message = $this->buildTripService->buildMultiCityTrip($flights, $tripType);
        } else {
            $message = ['error' => 'An error occurred. No trip was created'];
        }

        $trips =  Trip::query()->with('flights.departedFromAirport.location', 'flights.arrivedAtAirport.location', 'flights.airline')
            ->where('trip_type', config('enums.trip_types.one_way'))->get();

        return view('searchTrips')->with([
            'trips' => $trips,
            'successMessage' => $message['success'] ?? null,
            'errorMessage' => $message['error'] ?? null
        ]);

    }

    /**
     * @param FlightSearchRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function searchFlights(FlightSearchRequest $request){

        $search= $request->input();

        // search flights (according to user input) on the build trip page to help users choose their flights

        $flights = $this->searchTripService->getFlights($search);

        return view('createTrip', compact(['flights', 'search']));
    }
}
