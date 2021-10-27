@extends('layouts.app')
@php
$user = Http::withHeaders([
    'Authorization' => 'Bearer ' . session('token'),
])
    ->get(config('services.api.url') . '/details')
    ->json()['data'];
@endphp
@section('content')
    <div class="container">
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.published')
            </div>
            <div class="col-7 text-center my-4">
                <div class="row">
                    <div class="row">
                        <div class="col-12">
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <div id="survey-view-list">
                    <table class="table table-borderless table-hover text-start">
                        <thead>
                            <tr class="text-gray">
                                <th class="font-weight-regular" scope="col" width="45%">Nama Responden</th>
                                <th class="font-weight-regular" scope="col">Kategori</th>
                                <th class="font-weight-regular" scope="col">Skor</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray" id="survey-view-list-box">
                            @foreach ($result['data'] as $respondent)
                                <tr class="survey-row cursor-pointer @if ($loop->iteration > 1) border-top @endif">
                                    <th class="py-4 text-dark flex align-items-center justify-content-start" scope="row">
                                        @if ($respondent['profile_picture_path'])
                                            <img src="{{ config('services.asset.url') . '/' . $respondent['profile_picture_path'] }}"
                                                id="user-profile" class="rounded-circle me-2" width="30px" height="30px">
                                        @else
                                            <img src="{{ asset('images/logo.png') }}" class="rounded-circle me-2"
                                                width="30px" height="30px">
                                        @endif
                                        {{ $respondent['fullname'] }}
                                    </th>
                                    <td class="py-4 text-dark align-middle">{{ $respondent['category']['name'] }}
                                    </td>
                                    <td class="py-4 text-dark align-middle">{{ $respondent['score'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        var data = [
            @foreach ($assessment['respondent_types'] as $type)
                {
                y: {{ $type['respondent_count'] }},
                name: "{{ $type['name'] }}"
                },
            @endforeach
        ]
        $('#chart').highcharts({
            chart: {
                animation: false,
                type: 'pie',
                backgroundColor: null,
                height: 250
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                labelFormatter: function() {
                    return this.name + ': ' + Math.round(this.percentage) + '%';
                }
            },
            exporting: {
                enabled: false
            },
            title: {
                text: null
            },
            tooltip: {
                valueSuffix: ' Responden',
                enabled: true,
                backgroundColor: '#ffffff',
                borderColor: '#ffffff',
                borderRadius: 12,
                style: {
                    fontFamily: 'Lato',
                    fontWeight: 'bold',
                },
                formatter: function() {
                    return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                        this.y + ' Responden (' + this.percentage + '%)</h6>';
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%'],
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                },
            },
            series: [{
                showInLegend: true,
                data: data,
                size: '90%',
                innerSize: '75%',
            }]
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/3.0.3/main/clipboard-polyfill.js"
        integrity="sha512-0IaxYIj68pTzpOBGd7U3RFiF6sUPKefI5SRsYaZkGiJsM+U1/VuKnzT7dkDUxlIYcZ57gULzEk+PgtMfVAyFTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function copyToClipboard() {
            clipboard.writeText($('#survey-link').val());
        }
    </script>
@endsection

@section('head')
    <style>
        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
