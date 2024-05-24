@extends('main')

@section('content')
    <div>
        <div>
            <h2 style ="text-align:center">Build a Trip</h2>
            <form action="{{ route('getTripInfo') }}" method="GET">
                @csrf
                <div>
                    <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                        <label>Flight Type</label>
                        <select class="form-control" name="trip_type" required>
                            @foreach (config('enums.trip_types') as $key => $tripType)
                                <option value="{{ $tripType }}" @selected(isset($search['trip_type']) && $search['trip_type'] == $tripType)>
                                    {{ $tripType }}
                                </option>
                            @endForeach
                        </select>
                    </div>

                    <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                        <label>Flights</label>
                        <input type="text" class="form-control" placeholder="Flight number(s) separated by commas" name="flights" required>
                    </div>

                    <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                        <button class="btn btn-primary form-control"  type="submit">Create Trip</button>
                    </div>

                    @if(isset($successMessage) && $successMessage != null)
                        <div class="form-group col-4" style ="width: 50%; margin: 10px auto; background-color: lightgreen; padding:5px; border-radius: 5px;">
                                <p>{{$successMessage}}</p>
                        </div>
                    @endif
                    @if(isset($errorMessage) && $errorMessage != null)
                        <div class="form-group col-4" style ="width: 50%; margin: 10px auto; background-color: lightpink; padding:5px; border-radius: 5px;">
                            <p>{{$errorMessage}}</p>
                        </div>
                    @endif
                </div>
            </form>
        </div>

        <h3 class="text-center">Search Flights</h3>
        <form action="{{ route('searchFlights') }}" method="GET">
            @csrf
            <div>
                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <label>Departure Airport</label>
                    <input type="text" class="form-control" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport">
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <label>Arrival Airport</label>
                    <input type="text" class="form-control" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport">
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <label>IATA Airline Code</label>
                    <input type="text" class="form-control" placeholder="IATA Airline Code" value="{{$search['airline_code'] ?? ''}}" name="airline_code">
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <label>Departure Date</label>
                    <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <label>Arrival Date</label>
                    <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <button class="btn btn-primary form-control" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div style="margin: 30px 0;">
            <h4 style ="text-align:center"> List of available flights</h4>
            <table style="width:100%">
                <thead>
                <tr>
                    <th>
                        Airline
                    </th>
                    <th>
                        Flight Number
                    </th>
                    <th>
                        Departure Airport
                    </th>
                    <th>
                        Departure Time
                    </th>
                    <th>
                        Arrival Airport
                    </th>
                    <th>
                        Arrival Time
                    </th>
                    <th>
                        Flight Time
                    </th>
                    <th>
                        Price
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(isset($flights) && $flights->isNotEmpty())
                    @foreach ($flights as $flight)
                        <tr>
                            <td>
                                {{ '('.$flight->airline->iata_code.') '.$flight->airline->name }}
                            </td>
                            <td>
                                {{ $flight->number }}
                            </td>
                            <td>
                                {{ '('.$flight->departedFromAirport->code.') '.$flight->departedFromAirport->name . ' ['.$flight->departedFromAirport->location->city . ']' }}
                            </td>
                            <td>
                                {{ $flight->departure_time }}
                            </td>
                            <td>
                                {{ '('.$flight->arrivedAtAirport->code.') '.$flight->arrivedAtAirport->name . ' ['.$flight->arrivedAtAirport->location->city . ']' }}
                            </td>
                            <td>
                                {{ $flight->arrival_time }}
                            </td>
                            <td>
                                {{ $flight->flightTime }}
                            </td>
                            <td>
                                {{ $flight->price }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        {{ $flights->links() }}
    </div>

    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        table thead tr {
            background-color: #4478c2;
            color: #ffffff;
            text-align: left;
        }

        table td,th{
            border:1px solid black;
            text-align:center;
            padding: 12px 15px;
        }

        tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        tbody tr:last-of-type {
            border-bottom: 2px solid #4478c2;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
            color: #4478c2;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type=date]').attr({"min" : new Date().toISOString().split('T')[0]});
        });
    </script>
@endsection
