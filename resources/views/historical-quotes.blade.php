@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Historical Quotes</div>

                <div class="card-body">
                    <!-- Display historical data in a table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Open</th>
                                <th>High</th>
                                <th>Low</th>
                                <th>Close</th>
                                <th>Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filteredDataPaginated as $data)
                            <tr>
                                <td>{{ date('Y-m-d', $data['date']) }}</td>
                                <td>{{ $data['open'] }}</td>
                                <td>{{ $data['high'] }}</td>
                                <td>{{ $data['low'] }}</td>
                                <td>{{ $data['close'] }}</td>
                                <td>{{ $data['volume'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Display pagination links -->
                    <div class="d-flex justify-content-center">
                        {{ $filteredDataPaginated->links() }}
                    </div>
                    <!-- Chart.js chart for Open and Close prices -->
                    <div style="width: 600px; margin: auto;">
                        <canvas id="priceChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js library and create the chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>

<script>
var ctx = document.getElementById('priceChart').getContext('2d');
var dates = {!! json_encode($dates) !!}; // An array of date values

// Format dates using Moment.js
var formattedDates = dates.map(date => moment(date).format('dd.mm.yyyy'));

var openPrices = {!! json_encode($openPrices) !!}; // An array of open prices
var closePrices = {!! json_encode($closePrices) !!}; // An array of close prices

document.addEventListener('DOMContentLoaded', function() {
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates, // Use the formatted dates
        datasets: [{
            label: 'Open Price',
            data: openPrices,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false,
        }, {
            label: 'Close Price',
            data: closePrices,
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            fill: false,
        }]
    },
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd MMM yyyy'
                    }
                },
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                beginAtZero: false,
                title: {
                    display: true,
                    text: 'Price'
                }
            }
        }
    }
});

});

</script>
@endsection
