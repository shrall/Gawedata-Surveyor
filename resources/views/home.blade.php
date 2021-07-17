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
        {{-- <div class="row justify-content-center" id="survey-view-empty">
            <div class="col-4 text-center font-nexa my-5 pt-5">
                <img src="{{asset('images/survey-empty.png')}}" alt="" srcset="">
                <h5>Yuk, mulai buat survey</h5>
            </div>
        </div> --}}
        <div class="d-block" id="survey-view-grid">
            <div class="row gy-4">
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
                <div class="col-3 cursor-pointer">
                    <div class="card card-survey-grid px-1 py-3 text-gray">
                        <div class="card-header d-flex align-items-center">
                            <div class="text-gawedata">
                                <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
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
        <div class="d-none" id="survey-view-list">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr class="text-gray">
                        <th class="font-weight-regular" scope="col" width="45%">Nama Survei</th>
                        <th class="font-weight-regular" scope="col">Status</th>
                        <th class="font-weight-regular" scope="col">Jenis</th>
                        <th class="font-weight-regular" scope="col">Jumlah Responden</th>
                        <th class="font-weight-regular" scope="col">Tanggal Rilis</th>
                    </tr>
                </thead>
                <tbody class="text-gray">
                    <tr class="cursor-pointer">
                        <th class="py-4 text-dark fs-5" scope="row">Survei Ras Kucing</th>
                        <td class="py-4">
                            <div class="text-green">
                                <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-gawedata">
                                <span class="fa fa-fw fa-globe me-2"></span>Public
                            </div>
                        </td>
                        <td class="py-4"><span class="fa fa-fw fa-users me-2"></span> 0/100 Responden</td>
                        <td class="py-4">Hari ini 13.00 WIB</td>
                    </tr>
                    <tr class="cursor-pointer border-top">
                        <th class="py-4 text-dark fs-5" scope="row">Survei Ras Kucing</th>
                        <td class="py-4">
                            <div>
                                <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-gray">
                                <span class="fa fa-fw fa-lock me-2"></span>Private
                            </div>
                        </td>
                        <td class="py-4"><span class="fa fa-fw fa-users me-2"></span> 0/100 Responden</td>
                        <td class="py-4">Hari ini 13.00 WIB</td>
                    </tr>
                    <tr class="cursor-pointer border-top">
                        <th class="py-4 text-dark fs-5" scope="row">Survei Ras Kucing</th>
                        <td class="py-4">
                            <div class="text-gawedata">
                                <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-gawedata">
                                <span class="fa fa-fw fa-globe me-2"></span>Public
                            </div>
                        </td>
                        <td class="py-4"><span class="fa fa-fw fa-users me-2"></span> 0/100 Responden</td>
                        <td class="py-4">Hari ini 13.00 WIB</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- filter --}}
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
    {{-- toggle view --}}
    <script>
        function toggleSurveyViewList() {
            if ($("#survey-view-grid").hasClass('d-block')) {
                toggleSurveyView('#survey-view-list', '#survey-button-list', '#survey-view-grid', '#survey-button-grid')
            }
        }

        function toggleSurveyViewGrid() {
            if ($("#survey-view-list").hasClass('d-block')) {
                toggleSurveyView('#survey-view-grid', '#survey-button-grid', '#survey-view-list', '#survey-button-list')
            }
        }

        function toggleSurveyView(listOn, buttonOn, listOff, buttonOff) {
            $(listOn).removeClass('d-none');
            $(listOn).addClass('d-block');
            $(buttonOn).removeClass('text-secondary');
            $(buttonOn).addClass('text-gawedata');

            $(listOff).removeClass('d-block');
            $(listOff).addClass('d-none');
            $(buttonOff).removeClass('text-gawedata');
            $(buttonOff).addClass('text-secondary');
        }
    </script>
    {{-- create survey --}}
    <script>
        //first step
        function enableFirstButton() {
            if ($("#survey-title").val() != "" &&
                $("#survey-description").val() != "" &&
                $("#survey-category").val() != "" &&
                $("#survey-type").val() != "") {
                $("#create-survey-next-button-1").prop("disabled", false);
            } else {
                $("#create-survey-next-button-1").prop("disabled", true);
            }
        }
        $(function() {
            $('#select-survey-category').find('li').click(function() {
                $('#selected-survey-category').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
                $('#survey-category').val($(this).text());
                enableFirstButton();
            });
            $('#select-survey-type').find('li').click(function() {
                $('#selected-survey-type').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
                if ($(this).text() == 'Public (Semua responden dapat melihat dan mengisi survei)') {
                    $('#survey-type').val('Public');
                } else {
                    $('#survey-type').val('Private');
                }
                enableFirstButton();
            });
        });
        $("#survey-title").keyup(function() {
            enableFirstButton();
        });
        $("#survey-description").keyup(function() {
            enableFirstButton();
        });
    </script>
    <script>
        function changeStep(beforeStep, afterStep) {
            $(beforeStep).addClass('d-none');
            $(afterStep).removeClass('d-none');
        }
        $('#create-survey-next-button-1').click(function() {
            if ($('#survey-type').val() == 'Private') {
                changeStep('#first-step', '#second-step-private');
            } else {
                changeStep('#first-step', '#second-step-public');
            }
            $('#create-survey-sidebar').find('li:nth-child(1)').removeClass('active');
            $('#create-survey-sidebar').find('li:nth-child(2)').addClass('active');
            $('#create-survey-sidebar').find('li:nth-child(1)').find('div').removeClass('d-inline');
            $('#create-survey-sidebar').find('li:nth-child(1)').find('div').addClass('d-none');
            $('#create-survey-sidebar').find('li:nth-child(2)').find('div').removeClass('d-none');
            $('#create-survey-sidebar').find('li:nth-child(2)').find('div').addClass('d-inline');
        })
    </script>
@endsection
