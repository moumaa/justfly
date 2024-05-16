@extends('main')

@section('content')
    <div>
        <h2 class="text-center">Search Trips</h2>
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <div>
                <div class="row" style ="width: 50%; margin:auto;">
                    <div class="form-group col-6" style ="width: 50%; margin: 10px auto;">
                        <label>Trip Type</label>
                        <select class="form-control" name="trip_type" id="trip_type" required>
                            @foreach (config('enums.trip_types') as $key => $tripType)
                                <option value="{{ $tripType }}" @selected(isset($search['trip_type']) && $search['trip_type'] == $tripType)>
                                    {{ $tripType }}
                                </option>
                            @endForeach
                        </select>
                    </div>

                    <div class="form-group col-6" style ="width: 50%; margin: 10px auto;">
                        <label>IATA Airline Code</label>
                        <input type="text" class="form-control" placeholder="IATA Airline Code" value="{{$search['airline_code'] ?? ''}}" name="airline_code">
                    </div>
                </div>

                <div class="row trip_type_menu one_way_menu" style ="width: 50%; margin:auto;">
                    <div class="form-group col-3">
                        <label>Departure Airport</label>
                        <input type="text" class="form-control" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport">
                    </div>

                    <div class="form-group col-3">
                        <label>Arrival Airport</label>
                        <input type="text" class="form-control" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport">
                    </div>

                    <div class="form-group col-6">
                        <label>Departure Date</label>
                        <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                    </div>
                </div>

                <div class="row trip_type_menu round_trip_menu" style ="width: 50%; margin:auto; display:none">
                    <div class="form-group col-3">
                        <label>Departure Airport</label>
                        <input type="text" class="form-control" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport">
                    </div>

                    <div class="form-group col-3">
                        <label>Arrival Airport</label>
                        <input type="text" class="form-control" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport">
                    </div>

                    <div class="form-group col-3">
                        <label>Departure Date</label>
                        <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                    </div>

                    <div class="form-group col-3">
                        <label>Return Date</label>
                        <input type="date" class="form-control" placeholder="Return Date" value="{{$search['return_date'] ?? ''}}" name="return_date">
                    </div>
                </div>

                <div class="row trip_type_menu open_jaw_menu" style ="width: 50%; margin:auto; display:none">
                    <p style="text-align:center; background-color: lightpink; padding:5px; border-radius: 5px;">note: only the trip type and airline code fields work for open jaw search</p>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" id="open_jaw_departure_airport_flight_1" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_1">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_1">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date_flight_1">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date_flight_1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_2">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="open_jaw_arrival_airport_flight_2" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_2">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date_flight_2">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date_flight_2">
                        </div>
                    </div>
                </div>

                <div class="trip_type_menu multi_city_menu" style="width: 50%; margin:auto;display:none">
                    <p style="text-align:center; background-color: lightpink; padding:5px; border-radius: 5px;">note: only the trip type and airline code fields work for multi city search</p>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_1">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="multi_city_arrival_airport_flight_1" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_1">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                        </div>

                        <div class="form-group col-3">
                            <label>Return Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" id="multi_city_departure_airport_flight_2" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_2">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="multi_city_arrival_airport_flight_2" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_2">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                        </div>

                        <div class="form-group col-3">
                            <label>Return Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" id="multi_city_departure_airport_flight_3" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_3">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="multi_city_arrival_airport_flight_3" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_3">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                        </div>

                        <div class="form-group col-3">
                            <label>Return Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" id="multi_city_departure_airport_flight_4" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_4">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="multi_city_arrival_airport_flight_4" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_4">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                        </div>

                        <div class="form-group col-3">
                            <label>Return Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Departure Airport</label>
                            <input type="text" class="form-control" id="multi_city_departure_airport_flight_5" placeholder="Code" value="{{$search['departure_airport'] ?? ''}}" name="departure_airport_flight_5">
                        </div>

                        <div class="form-group col-3">
                            <label>Arrival Airport</label>
                            <input type="text" class="form-control" id="multi_city_arrival_airport_flight_5" placeholder="Code" value="{{$search['arrival_airport'] ?? ''}}" name="arrival_airport_flight_5">
                        </div>

                        <div class="form-group col-3">
                            <label>Departure Date</label>
                            <input type="date" class="form-control" placeholder="Departure Date" value="{{$search['departure_date'] ?? ''}}" name="departure_date">
                        </div>

                        <div class="form-group col-3">
                            <label>Return Date</label>
                            <input type="date" class="form-control" placeholder="Arrival Date" value="{{$search['arrival_date'] ?? ''}}" name="arrival_date">
                        </div>
                    </div>
                </div>

                <div class="form-group col-4" style ="width: 50%; margin: 10px auto;">
                    <button class="btn btn-primary form-control" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div style="margin: 30px 0;">
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
            <h4 style ="text-align:center"> List of Trips</h4>
            <table style="width:100%">
                <thead>
                <tr>
                    <th>
                        Trip Number
                    </th>
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
                @if(isset($trips) && $trips->isNotEmpty())
                    @foreach ($trips as $trip)
                        @php
                            $i = 0;
                            $i++;
                        @endphp
                        @foreach ($trip->flights as $flight)
                            <tr>
                                <td>
                                    {{ $i == 1 ? $trip->id : '' }}
                                </td>
                                @php
                                    $i = 0;
                                @endphp
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="special_cell">
                                Total Price:
                            </td>
                            <td class="special_cell">
                                {{ $trip->flights()->sum('price') }}
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
    </div>

    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            empty-cells: hide;
        }

        table thead tr {
            background-color: #4478c2;
            color: #ffffff;
            text-align: left;
        }

        table td,th{
            border-bottom:1px solid black;
            text-align:center;
            padding: 12px 15px;
        }

        .special_cell {
            background-color: #718096;
            color: #ffffff;
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

            $(".trip_type_menu").hide();
            $(".trip_type_menu input").prop( "disabled", true );

            var tripTypeSelector = $("#trip_type");

            var loadedTripTypeValue = tripTypeSelector.val().replace(/\s+/g, '_');

            $('.'+loadedTripTypeValue+'_menu').show();
            $('.'+loadedTripTypeValue+'_menu'+" input").prop( "disabled", false );

            $("#open_jaw_arrival_airport_flight_1").keyup(function() {
                $("#open_jaw_departure_airport_flight_2").val($(this).val());
            });

            $("#multi_city_arrival_airport_flight_1").keyup(function() {
                $("#multi_city_departure_airport_flight_2").val($(this).val());
            });
            $("#multi_city_arrival_airport_flight_2").keyup(function() {
                $("#multi_city_departure_airport_flight_3").val($(this).val());
            });
            $("#multi_city_arrival_airport_flight_3").keyup(function() {
                $("#multi_city_departure_airport_flight_4").val($(this).val());
            });
            $("#multi_city_arrival_airport_flight_4").keyup(function() {
                $("#multi_city_departure_airport_flight_5").val($(this).val());
            });

            tripTypeSelector.change(function() {

                $(".trip_type_menu input").each(function() {
                    this.value = "";
                });
                $(".trip_type_menu").hide();
                $(".trip_type_menu input").prop( "disabled", true );

                var tripTypeValue = $(this).val().replace(/\s+/g, '_');

                $('.'+tripTypeValue+'_menu').show();
                $('.'+tripTypeValue+'_menu'+" input").prop( "disabled", false );
            })
        });


    </script>
@endsection
