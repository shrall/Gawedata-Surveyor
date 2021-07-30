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
                    {{-- @foreach ($survey['questions'] as $question)
                        @include('survey.inc.chart.hasil.single_answer')
                    @endforeach --}}
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Skala</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="scale-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Multi Answer</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="multi-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Open Ended</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="overflow-auto pe-4" style="min-height:0;max-height: 30vh;">
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                    <div class="card-open-ended text-start mb-2 px-3 py-2">
                                        <h6>Jawaban</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Grid Answer</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row text-start mb-2">
                            <div class="col-3">
                                <span class="fa fa-fw fa-circle me-2 fs-6" style="color:#3F60F5;"></span>Wanita: 25%
                            </div>
                            <div class="col-3">
                                <span class="fa fa-fw fa-circle me-2 fs-6" style="color:#46cb5a;"></span>Wanita: 25%
                            </div>
                            <div class="col-3">
                                <span class="fa fa-fw fa-circle me-2 fs-6" style="color:#b0744a;"></span>Wanita: 25%
                            </div>
                            <div class="col-3">
                                <span class="fa fa-fw fa-circle me-2 fs-6" style="color:#d5c64b;"></span>Wanita: 25%
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="grid-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Priority Answer</h4>
                            <h6 class="text-gray">100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="priority-chart-1"></div>
                            </div>
                            <div class="col-6">
                                <div id="priority-chart-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-start">
                            <h4 class="font-weight-bold">Pertanyaan Action</h4>
                            <h6 class="text-gray">Action Question (Upload Gambar) - 100 Jawaban</h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="action-image-carousel" class="carousel slide" data-bs-interval="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="https://www.imgworlds.com/wp-content/uploads/2015/12/18-CONTACTUS-HEADER.jpg"
                                                class="d-block mx-auto">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVoR5pN5H7AFWzC4ajb_eGhbBuUcm1b_W3Ow&usqp=CAU"
                                                class="d-block mx-auto">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="https://i0.wp.com/cdn2.iconfinder.com/data/icons/dog-2/32/corgi-512.png"
                                                class="d-block mx-auto">
                                        </div>
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
                                    <div class="survey-result-image-nav me-2" data-bs-target="#action-image-carousel"
                                        data-bs-slide-to="0">
                                        <img src="https://www.imgworlds.com/wp-content/uploads/2015/12/18-CONTACTUS-HEADER.jpg"
                                            class="survey-result-image-nav-item d-block mx-auto">
                                    </div>
                                    <div class="survey-result-image-nav mx-2" data-bs-target="#action-image-carousel"
                                        data-bs-slide-to="1">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVoR5pN5H7AFWzC4ajb_eGhbBuUcm1b_W3Ow&usqp=CAU"
                                            class="survey-result-image-nav-item d-block mx-auto">
                                    </div>
                                    <div class="survey-result-image-nav mx-2" data-bs-target="#action-image-carousel"
                                        data-bs-slide-to="2">
                                        <img src="https://i0.wp.com/cdn2.iconfinder.com/data/icons/dog-2/32/corgi-512.png"
                                            class="survey-result-image-nav-item d-block mx-auto">
                                    </div>
                                </div>
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
    </script>
    {{-- @foreach ($survey['questions'] as $question)
        @include('survey.inc.chart.hasil.script.single_answer')
    @endforeach --}}
    <script>
        var scale = [{
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
        $('#scale-chart').highcharts({
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
                data: scale,
                size: '90%',
                innerSize: '75%',
            }]
        });
    </script>
    <script>
        var multi = [{
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
        var multiTitle = []
        multi.forEach(element => {
            multiTitle.push(element.name)
        });
        $('#multi-chart').highcharts({
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
                categories: multiTitle,
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
                data: multi,
                size: '90%',
                innerSize: '75%',
            }]
        });
    </script>
    <script>
        var grid = [{
            name: 'Sangat Tidak Setuju',
            data: [12, 2, 3, 4]

        }, {
            name: 'Tidak Setuju',
            data: [3, 10, 4, 2]

        }, {
            name: 'Setuju',
            data: [1, 4, 7, 8]

        }, {
            name: 'Sangat Setuju',
            data: [4, 4, 6, 6]

        }]
        var gridTitle = []
        grid.forEach(element => {
            gridTitle.push(element.name)
        });
        $('#grid-chart').highcharts({
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
            series: grid,
        });
    </script>
    <script>
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
    </script>
@endsection

@section('head')
    <style>
        .highcharts-credits {
            display: none;
        }

    </style>
@endsection
