@extends('main')

@section('content')
    <div>
        <h2 class="text-center">Creating New Trip</h2>

        <div style="margin: 30px 0;">
            <h4 style ="text-align:center"> Flights for this Trip</h4>
            <table style="width:100%">
                <thead>
                <tr>
                    <th>
                        Flight Number
                    </th>
                    <th>
                        From
                    </th>
                    <th>
                        To
                    </th>
                    <th>
                        Price
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(isset($tripFlightsData))
                    @foreach ($tripFlightsData['flights'] as $flight)
                        <tr>
                            <td>
                                {{ $flight['number'] }}
                            </td>
                            <td>
                                {{ $flight['from'] }}
                            </td>
                            <td>
                                {{ $flight['to'] }}
                            </td>
                            <td>
                                {{ $flight['price'] }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {{ 'total: '.$tripFlightsData['total_price'] }}
                        </td>
                    </tr>
                @else
                    <h4 style ="text-align:center"> There are no flights on this trip.</h4>
                @endif
                </tbody>
            </table>
            <div style="margin: 0 42%;">
                <div style="padding:5px">
                    <a class="btn btn-warning form-control" href="/trips">Go Back</a>
                </div>
                <form action="{{ route('createTrip', ['tripFlightsData' => $tripFlightsData]) }}" method="POST">
                    @csrf
                    <div style="padding:5px">
                        <button class="btn btn-primary form-control" type="submit">Confirm Trip</button>
                    </div>
                </form>
            </div>
        </div>
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
@endsection
