@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar')
            </div>
            <div class="col-7 text-center my-4">
                <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                    <div class="row justify-content-end">
                        <a href="#" class="col-3 btn btn-gawedata-3 font-lato font-weight-bold">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Jenis Kelamin</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="gender-chart"></div>
                            </div>
                            <div class="col-6 d-flex align-items-center"
                                style="overflow: auto; white-space: nowrap;">
                                <div class="d-flex flex-row">
                                    <div class="col-12 d-flex flex-column h-100 justify-content-start">
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#3F60F5;"></span>Pria: 75%
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#46cb5a;"></span>Wanita: 25%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Umur</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="age-chart"></div>
                            </div>
                            <div class="col-6 d-flex align-items-center"
                                style="overflow: auto; white-space: nowrap;">
                                <div class="d-flex flex-row">
                                    <div class="col-12 d-flex flex-column h-100 justify-content-start">
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#3F60F5;"></span>21: 75%
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#46cb5a;"></span>22: 5%
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#b0744a;"></span>23: 5%
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#d5c64b;"></span>24: 5%
                                            </div>
                                        </div>
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#6bd5cf;"></span>25: 5%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex flex-column h-100 justify-content-start">
                                        <div class="row my-2 justify-content-start">
                                            <div class="col-12 text-start">
                                                <span class="fa fa-fw fa-circle me-2 fs-6"
                                                    style="color:#d56bcb;"></span>26: 5%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Provinsi</h4>
                            <h6 class="text-gray">Belum ada respon</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-gray">Grafik akan muncul setelah ada respon</h6>
                            </div>
                        </div>
                    </div>
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
        Highcharts.setOptions({
            colors: ['#3F60F5', '#46cb5a', '#b0744a', '#d5c64b', '#6bd5cf', '#d56bcb']
        });
        var gender = [{
                y: 75,
                name: "Pria"
            },
            {
                y: 25,
                name: "Wanita"
            },
        ]
        var age = [{
                y: 75,
                name: "21"
            },
            {
                y: 5,
                name: "22"
            },
            {
                y: 5,
                name: "23"
            },
            {
                y: 5,
                name: "24"
            },
            {
                y: 5,
                name: "25"
            },
            {
                y: 5,
                name: "26"
            },
        ]

        var initChart = function(_data) {
            $('#gender-chart').highcharts({
                chart: {
                    animation: false,
                    type: 'pie',
                    backgroundColor: null,
                    height: 250
                },
                title: {
                    text: null
                },
                tooltip: {
                    enabled: false
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
                    data: gender,
                    size: '90%',
                    innerSize: '75%',
                }]
            });
            $('#age-chart').highcharts({
                chart: {
                    animation: false,
                    type: 'pie',
                    backgroundColor: null,
                    height: 250
                },
                title: {
                    text: null
                },
                tooltip: {
                    enabled: false
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
                    data: age,
                    size: '90%',
                    innerSize: '75%',
                }]
            });
        };

        initChart();
    </script>
@endsection

@section('head')
    <style>
        .highcharts-no-tooltip {
            display: none;
        }

        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
