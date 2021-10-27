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
                <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                    @foreach ($result['questions'] as $question)
                        <div class="row">
                            <div class="text-start">
                                <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                </h5>
                                <h6 class="text-gray">{{ $question['answers_count'] ?? 0 }} Jawaban
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-{{ $loop->iteration }}"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    @foreach ($result['questions'] as $question)
        <script>
            var data{{ $loop->iteration }} = [
                @foreach ($question['answer_choices'] as $answer)
                    {
                    y: @json($answer['answers_count']),
                    name: "{{ $answer['text'] }}"
                    },
                @endforeach
            ]
            $('#chart-{{ $loop->iteration }}').highcharts({
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
                    data: data{{ $loop->iteration }},
                    size: '90%',
                    innerSize: '75%',
                }]
            });
        </script>
    @endforeach
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
