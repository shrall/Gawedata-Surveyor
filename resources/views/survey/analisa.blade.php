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
                    <div class="row justify-content-end">
                        <a href="{{ config('services.api.url') . '/downloadSurveyResultExcel/' . $survey['id'] . '/' . $user['id'] }}"
                            class="col-3 btn btn-gawedata-3 font-lato font-weight-bold">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
                    @include('survey.inc.chart.analisa.gender')
                    @include('survey.inc.chart.analisa.age')
                    @include('survey.inc.chart.analisa.city')
                    @include('survey.inc.chart.analisa.province')
                    @include('survey.inc.chart.analisa.education')
                    @include('survey.inc.chart.analisa.profession')
                    @include('survey.inc.chart.analisa.expense')
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
    @include('survey.inc.chart.analisa.script.gender')
    @include('survey.inc.chart.analisa.script.age')
    @include('survey.inc.chart.analisa.script.city')
    @include('survey.inc.chart.analisa.script.province')
    @include('survey.inc.chart.analisa.script.education')
    @include('survey.inc.chart.analisa.script.profession')
    @include('survey.inc.chart.analisa.script.expense')
@endsection

@section('head')
    <style>
        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
