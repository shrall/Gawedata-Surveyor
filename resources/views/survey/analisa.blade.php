@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar.published')
            </div>
            <div class="col-7 text-center my-4">
                <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                    <div class="row justify-content-end">
                        <a href="#" class="col-3 btn btn-gawedata-3 font-lato font-weight-bold">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
                    @include('survey.inc.chart.analisa.gender')
                    @include('survey.inc.chart.analisa.age')
                    {{-- <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Provinsi</h4>
                            <h6 class="text-gray">Belum ada respon</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-gray">Grafik akan muncul setelah ada respon</h6>
                            </div>
                        </div>
                    </div> --}}
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
    </script>
    @include('survey.inc.chart.analisa.script.gender')
    @include('survey.inc.chart.analisa.script.age')
@endsection

@section('head')
    <style>
        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
