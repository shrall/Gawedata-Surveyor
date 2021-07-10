@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center gx-3 my-5 font-lato">
            <div class="mx-2">
                <h2>Daftar Survei</h2>
            </div>
            <div class="ms-auto">
                <div class="dropdown d-inline-block mx-2" id="select-filter">
                    <span class="input-select d-flex align-items-center" type="button" id="selected-filter"
                        data-bs-toggle="dropdown">
                        <span class="fa fa-fw fa-filter text-gawedata me-2"></span>
                        Filter
                        <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
                <div class="dropdown d-inline-block mx-2" id="select-sort">
                    <span class="input-select d-flex align-items-center" type="button" id="selected-sort"
                        data-bs-toggle="dropdown">
                        <span class="fa fa-fw fa-exchange-alt fa-rotate-90 text-gawedata me-2"></span>
                        Urutkan
                        <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- <div class="row justify-content-center" id="survey-list-empty">
            <div class="col-4 text-center font-nexa my-5 pt-5">
                <img src="{{asset('images/survey-empty.png')}}" alt="" srcset="">
                <h5>Yuk, mulai buat survey</h5>
            </div>
        </div> --}}
        <div class="row gy-4" id="survey-list-grid">
            <div class="col-3 cursor-pointer">
                <div class="card card-survey-grid px-1 py-3 text-gray">
                    <div class="card-header d-flex align-items-center">
                        <div>
                            <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                        </div>
                        <div class="ms-auto">Hari ini 13.00 WIB</div>
                    </div>
                    <div class="card-body mt-4 pb-0">
                        <h5 class="font-weight-bold text-dark">Survei Ras Kucing</h5>
                    </div>
                    <div class="card-footer pt-0">
                        <span class="fa fa-fw fa-users me-2"></span> 0/100 Responden
                    </div>
                </div>
            </div>
            <div class="col-3 cursor-pointer">
                <div class="card card-survey-grid px-1 py-3 text-gray">
                    <div class="card-header d-flex align-items-center">
                        <div>
                            <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                        </div>
                        <div class="ms-auto">Hari ini 13.00 WIB</div>
                    </div>
                    <div class="card-body mt-4 pb-0">
                        <h5 class="font-weight-bold text-dark">Survei Ras Kucing</h5>
                    </div>
                    <div class="card-footer pt-0">
                        <span class="fa fa-fw fa-users me-2"></span> 0/100 Responden
                    </div>
                </div>
            </div>
            <div class="col-3 cursor-pointer">
                <div class="card card-survey-grid px-1 py-3 text-gray">
                    <div class="card-header d-flex align-items-center">
                        <div>
                            <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                        </div>
                        <div class="ms-auto">Hari ini 13.00 WIB</div>
                    </div>
                    <div class="card-body mt-4 pb-0">
                        <h5 class="font-weight-bold text-dark">Survei Ras Kucing</h5>
                    </div>
                    <div class="card-footer pt-0">
                        <span class="fa fa-fw fa-users me-2"></span> 0/100 Responden
                    </div>
                </div>
            </div>
            <div class="col-3 cursor-pointer">
                <div class="card card-survey-grid px-1 py-3 text-gray">
                    <div class="card-header d-flex align-items-center">
                        <div>
                            <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                        </div>
                        <div class="ms-auto">Hari ini 13.00 WIB</div>
                    </div>
                    <div class="card-body mt-4 pb-0">
                        <h5 class="font-weight-bold text-dark">Survei Ras Kucing</h5>
                    </div>
                    <div class="card-footer pt-0">
                        <span class="fa fa-fw fa-users me-2"></span> 0/100 Responden
                    </div>
                </div>
            </div>
            <div class="col-3 cursor-pointer">
                <div class="card card-survey-grid px-1 py-3 text-gray">
                    <div class="card-header d-flex align-items-center">
                        <div class="text-green">
                            <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                        </div>
                        <div class="ms-auto">Hari ini 13.00 WIB</div>
                    </div>
                    <div class="card-body mt-4 pb-0">
                        <h5 class="font-weight-bold text-dark">Survei Ras Kucing</h5>
                    </div>
                    <div class="card-footer pt-0">
                        <span class="fa fa-fw fa-users me-2"></span> 0/100 Responden
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#select-filter').find('li').click(function() {
                $('#selected-filter').html($(this).text());
            });
            $('#select-sort').find('li').click(function() {
                $('#selected-sort').html($(this).text());
            });
        });
    </script>
@endsection
