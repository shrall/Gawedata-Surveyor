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
                @include('survey.inc.sidebar.published')
            </div>
            <div class="col-7 text-center my-4">
                <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                    <div class="d-flex ms-auto">
                        <a href="{{ config('services.api.url') . '/downloadSurveyResultExcel/' . $survey['id'] . '/' . $user['id'] }}"
                            class="btn btn-gawedata-3 font-lato font-weight-bold w-100">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
                    @foreach ($result['questions'] as $question)
                        @if ($question['survey_question_type_id'] == 1)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Single Answer - {{ $question['answers_count'] }} Jawaban
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="chart-{{ $loop->iteration }}"></div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 2)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Multi Answer - {{ $question['answers_count'] }} Jawaban
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="multi-chart-{{ $loop->iteration }}"></div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 3)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Scale Question - {{ $question['answers_count'] }} Jawaban
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="scale-chart-{{ $loop->iteration }}"></div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 4)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Grid Question - {{ $question['answers_count'] }} Jawaban
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="grid-chart-{{ $loop->iteration }}"></div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 6)
                            <div class="row mb-3">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Open Ended Question - {{ $question['answers_count'] }}
                                        Jawaban</h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="overflow-auto pe-4" style="min-height:0;max-height: 30vh;">
                                            @foreach ($question['results'] as $resulta)
                                                <div class="card-open-ended text-start mb-2 px-3 py-2">
                                                    <h6>{{ $resulta['answer'] }}</h6>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 7)
                            <div class="row mb-3">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Action Question (Video) - {{ $question['answers_count'] }}
                                        Jawaban</h6>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 8)
                            <div class="row mb-3">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Action Question (Install App) -
                                        {{ $question['answers_count'] }} Jawaban</h6>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 9)
                            <div class="row mb-3">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Action Question (Kunjungi Website) -
                                        {{ $question['answers_count'] }} Jawaban</h6>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 10)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}.{{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Action Question (Upload Gambar) -
                                        {{ $question['answers_count'] }} Jawaban</h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="action-image-carousel" class="carousel slide" data-bs-interval="false">
                                            <div class="carousel-inner">
                                                @foreach ($question['results'] as $img)
                                                    <div class="carousel-item @if ($loop->iteration == 1) active @endif">
                                                        <img src="{{ config('services.asset.url') . '/' . $img['image_path'] }}"
                                                            class="d-block mx-auto">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#action-image-carousel" data-bs-slide="prev">
                                                <span class="fa fa-fw fa-chevron-left fs-1"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#action-image-carousel" data-bs-slide="next">
                                                <span class="fa fa-fw fa-chevron-right fs-1"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center my-2 pb-2"
                                            style="overflow: auto; white-space: nowrap;">
                                            @foreach ($question['results'] as $image)
                                                <div class="survey-result-image-nav me-2"
                                                    data-bs-target="#action-image-carousel"
                                                    data-bs-slide-to="{{ $loop->iteration - 1 }}">
                                                    <img src="{{ config('services.asset.url') . '/' . $image['image_path'] }}"
                                                        class="survey-result-image-nav-item d-block mx-auto">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($question['survey_question_type_id'] == 5)
                            <div class="row">
                                <div class="text-start">
                                    <h5 class="line-height-2">{{ $loop->iteration }}. {{ $question['question'] }}
                                    </h5>
                                    <h6 class="text-gray">Priority Question - {{ $question['answers_count'] }}
                                        Jawaban</h6>
                                </div>
                                <div class="row">
                                    @foreach ($question['result'] as $key => $data)
                                        <div class="col-6">
                                            <div id="priority-chart-{{ $key }}"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
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
        @if ($question['survey_question_type_id'] == 1)
            <script>
                var data{{ $loop->iteration }} = [
                    @foreach ($question['results'] as $answer)
                        {
                        y: @json($answer['count']),
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
        @elseif ($question['survey_question_type_id'] == 2)
            <script>
                var data{{ $loop->iteration }} = [
                    @foreach ($question['results'] as $answer)
                        {
                        y: @json($answer['count']),
                        name: "{{ $answer['text'] }}"
                        },
                    @endforeach
                ]
                var multiTitle{{ $loop->iteration }} = []
                data{{ $loop->iteration }}.forEach(element => {
                    multiTitle{{ $loop->iteration }}.push(element.name)
                });
                $('#multi-chart-{{ $loop->iteration }}').highcharts({
                    chart: {
                        animation: false,
                        type: 'bar',
                        backgroundColor: null,
                        height: 250
                    },
                    exporting: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        categories: multiTitle{{ $loop->iteration }},
                    },
                    yAxis: [{
                        gridLineDashStyle: 'longdashdot',
                        min: 0,
                        title: {
                            text: ''
                        }
                    }],
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
                            var divider = 0;
                            this.series.data.forEach(element => {
                                divider += element.y
                            });
                            var percent = (100 * this.y) / divider;
                            percent = percent.toFixed(1);
                            return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                                this.y + ' Responden (' + percent + '%)</h6>';
                        }
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true,
                                formatter: function() {
                                    var divider = 0;
                                    this.series.data.forEach(element => {
                                        divider += element.y
                                    });
                                    var percent = (100 * this.y) / divider;
                                    percent = percent.toFixed(1);
                                    return this.y + ' (' + percent + '%)';
                                },
                                style: {
                                    fontFamily: 'Lato',
                                    fontWeight: 'bold',
                                    top: 0
                                },
                            }
                        },
                    },
                    series: [{
                        data: data{{ $loop->iteration }},
                        size: '90%',
                        innerSize: '75%',
                    }]
                });
            </script>
        @elseif ($question['survey_question_type_id'] == 3)
            <script>
                var data{{ $loop->iteration }} = [
                    @foreach ($question['scales'] as $key => $answer)
                        {
                        y: @json($answer),
                        name: @json(array_keys($question['scales'])[$loop->iteration - 1])
                        },
                    @endforeach
                ]
                $('#scale-chart-{{ $loop->iteration }}').highcharts({
                    chart: {
                        animation: false,
                        type: 'column',
                        backgroundColor: null,
                        height: 250
                    },
                    exporting: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    yAxis: [{
                        gridLineDashStyle: 'longdashdot',
                        min: 0,
                        title: {
                            text: ''
                        }
                    }],
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
                            var divider = 0;
                            this.series.data.forEach(element => {
                                divider += element.y
                            });
                            var percent = (100 * this.y) / divider;
                            percent = percent.toFixed(1);
                            return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                                this.y + ' Responden (' + percent + '%)</h6>';
                        }
                    },
                    plotOptions: {
                        series: {
                            pointStart: @json(array_keys($question['scales'])[0])
                        },
                        column: {
                            dataLabels: {
                                enabled: true,
                                inside: true,
                                color: '#ffffff',
                                formatter: function() {
                                    var divider = 0;
                                    this.series.data.forEach(element => {
                                        divider += element.y
                                    });
                                    var percent = (100 * this.y) / divider;
                                    percent = percent.toFixed(1);
                                    return this.y + ' (' + percent + '%)';
                                },
                                style: {
                                    fontFamily: 'Lato',
                                    fontWeight: 'bold',
                                    top: 0
                                },
                            }
                        },
                    },
                    series: [{
                        data: data{{ $loop->iteration }},
                        size: '90%',
                        innerSize: '75%',
                    }]
                });
            </script>
        @elseif ($question['survey_question_type_id'] == 4)
            <script>
                var data{{ $loop->iteration }} = [
                    @foreach ($question['result'] as $key => $result)
                        {
                        name: @json($result['question']),
                        data: [
                        @foreach ($result['answered_choices'] as $answer)
                            @json($answer['count']),
                        @endforeach
                        ]
                        },
                    @endforeach
                ]
                var gridTitle{{ $loop->iteration }} = []
                data{{ $loop->iteration }}.forEach(element => {
                    gridTitle{{ $loop->iteration }}.push(element.name)
                });
                $('#grid-chart-{{ $loop->iteration }}').highcharts({
                    chart: {
                        animation: false,
                        type: 'column',
                        backgroundColor: null,
                        height: 250
                    },
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        labelFormatter: function() {
                            return this.name;
                        }
                    },
                    xAxis: {
                        categories: [
                            @foreach ($question['result'][0]['answered_choices'] as $key => $answer)
                                @json($answer['text']),
                            @endforeach
                        ],
                        crosshair: true
                    },
                    exporting: {
                        enabled: false
                    },
                    yAxis: [{
                        gridLineDashStyle: 'longdashdot',
                        min: 0,
                        title: {
                            text: ''
                        }
                    }],
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
                            var divider = 0;
                            this.series.data.forEach(element => {
                                divider += element.y
                            });
                            var percent = (100 * this.y) / divider;
                            percent = percent.toFixed(1);
                            return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.series.name +
                                '</h5><br><br><h6>' +
                                this.y + ' Responden (' + percent + '%)</h6>';
                        }
                    },
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: false,
                            }
                        },
                    },
                    series: data{{ $loop->iteration }},
                });
            </script>
        @elseif($question['survey_question_type_id'] == 5)
            @foreach ($question['result'] as $key => $data)
                <script>
                    var data{{ $loop->iteration }} = [
                        @foreach ($data as $answer)
                            {
                            y: @json($answer['count']),
                            name: "{{ $answer['text'] }}"
                            },
                        @endforeach
                    ]
                    var multiTitle{{ $loop->iteration }} = []
                    data{{ $loop->iteration }}.forEach(element => {
                        multiTitle{{ $loop->iteration }}.push(element.name)
                    });
                    $('#priority-chart-{{ $key }}').highcharts({
                        chart: {
                            animation: false,
                            type: 'bar',
                            backgroundColor: null,
                            height: 250
                        },
                        exporting: {
                            enabled: false
                        },
                        legend: {
                            enabled: false
                        },
                        xAxis: {
                            categories: multiTitle{{ $loop->iteration }},
                        },
                        yAxis: [{
                            gridLineDashStyle: 'longdashdot',
                            min: 0,
                            title: {
                                text: ''
                            }
                        }],
                        title: {
                            text: "Urutan ke-{{ $loop->iteration }}",
                            align: "left"
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
                                var divider = 0;
                                this.series.data.forEach(element => {
                                    divider += element.y
                                });
                                var percent = (100 * this.y) / divider;
                                percent = percent.toFixed(1);
                                return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                                    this.y + ' Responden (' + percent + '%)</h6>';
                            }
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: true,
                                    formatter: function() {
                                        var divider = 0;
                                        this.series.data.forEach(element => {
                                            divider += element.y
                                        });
                                        var percent = (100 * this.y) / divider;
                                        percent = percent.toFixed(1);
                                        return this.y + ' (' + percent + '%)';
                                    },
                                    style: {
                                        fontFamily: 'Lato',
                                        fontWeight: 'bold',
                                        top: 0
                                    },
                                }
                            },
                        },
                        series: [{
                            data: data{{ $loop->iteration }},
                            size: '90%',
                            innerSize: '75%',
                        }]
                    });
                </script>
            @endforeach
        @endif
    @endforeach
    {{-- <script>
        var priority1 = [{
                y: 75,
                name: "Pria"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
        ]
        var priorityTitle1 = []
        priority1.forEach(element => {
            priorityTitle1.push(element.name)
        });
        $('#priority-chart-1').highcharts({
            chart: {
                animation: false,
                type: 'bar',
                backgroundColor: null,
                height: 250
            },
            exporting: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: priorityTitle1,
            },
            yAxis: [{
                gridLineDashStyle: 'longdashdot',
                min: 0,
                title: {
                    text: ''
                }
            }],
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
                    var divider = 0;
                    this.series.data.forEach(element => {
                        divider += element.y
                    });
                    var percent = (100 * this.y) / divider;
                    percent = percent.toFixed(1);
                    return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                        this.y + ' Responden (' + percent + '%)</h6>';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            var divider = 0;
                            this.series.data.forEach(element => {
                                divider += element.y
                            });
                            var percent = (100 * this.y) / divider;
                            percent = percent.toFixed(1);
                            return this.y + ' (' + percent + '%)';
                        },
                        style: {
                            fontFamily: 'Lato',
                            fontWeight: 'bold',
                            top: 0
                        },
                    }
                },
            },
            series: [{
                data: priority1,
                size: '90%',
                innerSize: '75%',
            }]
        });
    </script>
    <script>
        var priority2 = [{
                y: 75,
                name: "Pria"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
            {
                y: 25,
                name: "Wanita"
            },
        ]
        var priorityTitle2 = []
        priority2.forEach(element => {
            priorityTitle2.push(element.name)
        });
        $('#priority-chart-2').highcharts({
            chart: {
                animation: false,
                type: 'bar',
                backgroundColor: null,
                height: 250
            },
            exporting: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: priorityTitle2,
            },
            yAxis: [{
                gridLineDashStyle: 'longdashdot',
                min: 0,
                title: {
                    text: ''
                }
            }],
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
                    var divider = 0;
                    this.series.data.forEach(element => {
                        divider += element.y
                    });
                    var percent = (100 * this.y) / divider;
                    percent = percent.toFixed(1);
                    return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                        this.y + ' Responden (' + percent + '%)</h6>';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            var divider = 0;
                            this.series.data.forEach(element => {
                                divider += element.y
                            });
                            var percent = (100 * this.y) / divider;
                            percent = percent.toFixed(1);
                            return this.y + ' (' + percent + '%)';
                        },
                        style: {
                            fontFamily: 'Lato',
                            fontWeight: 'bold',
                            top: 0
                        },
                    }
                },
            },
            series: [{
                data: priority2,
                size: '90%',
                innerSize: '75%',
            }]
        });
    </script> --}}
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
