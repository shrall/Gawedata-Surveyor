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
                @if ($assessment['respondent_count'] != 0)
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
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%">
                        <div class="span fa fa-fw fa-pie-chart text-gray mb-4" style="font-size: 12rem"></div>
                        <h3 class="text-gray">Hasil tes akan muncul setelah tes selesai.</h3>
                    </div>
                @endif
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
    <script>
        var start = new Date().getUTCDate();
        var end = start + @json($assessment['duration'] * 60);
        var distance = end - start;

        function startAssessment(id) {
            $.ajax({
                    url: '{{ config('services.api.url') }}' + "/startStopAssessment/" + id + "?action=STARTED",
                    type: 'PATCH',
                    headers: {
                        "Authorization": "Bearer {{ session('token') }}",
                    },
                    success: function(res) {
                        console.log(res);
                        $('#start-button').removeClass('d-flex').addClass('d-none');
                        $('#stop-button').removeClass('d-none').addClass('d-flex');
                        startCountdown(distance);
                    }
                })
                .done(function(data) {
                    console.log(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function stopAssessment(id) {
            $.ajax({
                    url: '{{ config('services.api.url') }}' + "/startStopAssessment/" + id + "?action=STOPPED",
                    type: 'PATCH',
                    headers: {
                        "Authorization": "Bearer {{ session('token') }}",
                    },
                    success: function(res) {
                        console.log(res);
                        $('#stop-button').removeClass('d-flex').addClass('d-none');
                        $('#done-button').removeClass('d-none').addClass('d-flex');
                    }
                })
                .done(function(data) {
                    console.log(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }
    </script>
    <script>
        var negativeTrigger = false;

        function startCountdown(intervals) {
            var interval = intervals;
            setInterval(function() {
                if (interval < 0 || negativeTrigger) {
                    negativeTrigger = true;
                    interval = Math.abs(interval);
                }
                var hours = Math.floor((interval % (1000 * 60 * 60 * 24)) / 60 / 60);
                var minutes = Math.floor((interval % (1000 * 60 * 60)) / 60);
                var seconds = Math.floor((interval % (1000 * 60))) - (parseInt(minutes) * 60);
                if (hours < 10 && hours > 0) {
                    hours = "0" + hours
                }
                if (minutes < 10 && minutes > 0) {
                    minutes = "0" + minutes
                }
                if (seconds < 10 && seconds > 0) {
                    seconds = "0" + seconds
                }
                if (!negativeTrigger) {
                    $('.assessment-countdown').html(hours + ":" + minutes + ":" + seconds);
                    interval--;
                }else{
                    $('.assessment-countdown').html("-"+hours + ":" + minutes + ":" + seconds);
                    interval++;
                }
            }, 1000);
        }
    </script>
    @if ($assessment['status_id'] == 9)
        <script>
            var startnew = @json(strtotime(Carbon\Carbon::now()->tz('utc')));
            var endnew = @json(strtotime($assessment['end_time']));
            var distancenew = endnew - startnew;
            console.log(startnew);
            console.log(endnew);
            console.log(distancenew);
            $(window).on('load', function() {
                startCountdown(distancenew);
            });
        </script>
    @endif
@endsection

@section('head')
    <style>
        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
