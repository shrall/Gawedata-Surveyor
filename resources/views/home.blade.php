@extends('layouts.app')

@section('content')
    @php
    $user = Http::withHeaders([
        'Authorization' => 'Bearer ' . session('token'),
    ])
        ->get(config('services.api.url') . '/details')
        ->json()['data'];
    @endphp
    <div class="container pt-5">
        @if (session('Error'))
            <div class="alert-danger-gawedata mb-3 px-3 py-4">{{ session('Error') }}</div>
        @endif
        <div class="d-flex align-items-center gx-3 mb-3 font-lato">
            <div class="mx-2">
                <h2>Daftar Survei</h2>
            </div>
            <div class="ms-auto">
                <div class="dropdown d-inline-block mx-2" id="select-sort">
                    <span class="input-select d-flex align-items-center" type="button" id="selected-sort"
                        data-bs-toggle="dropdown">
                        <span class="fa fa-fw fa-exchange-alt fa-rotate-90 text-gawedata me-2"></span>
                        Urutkan
                        <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" id="sort-asc" onclick="changeSort('asc');">Ascending</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="sort-desc" onclick="changeSort('desc');">Descending</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gx-3 mb-5 px-2 font-nexa">
            <div class="tab-gawedata-active px-2 py-1" id="tab-general" onclick="changeType('General')">Survei Umum
            </div>
            @if ($user['is_admin'])
                <div class="tab-gawedata px-2 py-1" id="tab-daily" onclick="changeType('Daily')">Survei Harian</div>
            @endif
            <div class="tab-gawedata px-2 py-1" id="tab-assessment" onclick="changeType('Assessment')">Assessment</div>
        </div>
        <div id="survey-container">
            @if (count($surveys['data']) > 0)
                <div class="d-block" id="survey-view-grid">
                    <div class="row gy-4 mb-4" id="survey-view-grid-box">
                        @foreach ($surveys['data'] as $survey)
                            @include('inc.modal.survey.rejected_grid')
                            <a @if ($survey['status_id'] == 3) onclick="$('#reject-grid-modal-'+{{ $survey['id'] }}).modal('show');" @else href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}" @endif
                                class="col-3 text-decoration-none" title="{{ $survey['title'] }}">
                                <div class="card card-survey-grid px-1 py-3 text-gray">
                                    <div class="card-header d-flex align-items-center">
                                        @if ($survey['status_id'] == 4)
                                            <div>
                                                <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                            </div>
                                        @elseif ($survey['status_id'] == 5)
                                            <div class="text-gawedata">
                                                <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                            </div>
                                        @elseif ($survey['status_id'] == 6)
                                            <div class="text-green">
                                                <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                            </div>
                                        @elseif ($survey['status_id'] == 7)
                                            <div class="text-finished">
                                                <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                            </div>
                                        @elseif ($survey['status_id'] == 8)
                                            <div class="text-red">
                                                <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                            </div>
                                        @elseif ($survey['status_id'] == 3)
                                            <div class="text-red">
                                                <span class="fa fa-fw fa-circle text-red me-2"></span>Rejected
                                            </div>
                                        @endif
                                        <div class="ms-auto">
                                            {{ date('d-m-y, H:i', strtotime($survey['created_at'])) }}
                                            WIB</div>
                                    </div>
                                    <div class="card-body mt-4 pb-0">
                                        <h5 class="font-weight-bold text-dark">
                                            {{ strlen($survey['title']) > 25 ? substr($survey['title'], 0, 20) . '...' : $survey['title'] }}
                                        </h5>
                                    </div>
                                    <div class="card-footer pt-0">
                                        <span class="fa fa-fw fa-users me-2"></span>
                                        {{ $survey['respondents_answered_question_count'] }}/{{ $survey['respondent_quota'] }}
                                        Responden
                                    </div>
                                </div>
                            </a>
                        @endforeach
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
                        <tbody class="text-gray" id="survey-view-list-box">
                            @foreach ($surveys['data'] as $survey)
                                @include('inc.modal.survey.rejected_list')
                                <tr class="survey-row cursor-pointer @if ($loop->iteration > 1) border-top @endif"
                                    data-href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}"
                                    data-status={{$survey['status_id']}} data-id={{ $survey['id'] }}>
                                    <th class="py-4 text-dark fs-5" scope="row">
                                        {{ strlen($survey['title']) > 25 ? substr($survey['title'], 0, 33) . '...' : $survey['title'] }}
                                    </th>
                                    @if ($survey['status_id'] == 4)
                                        <td class="py-4">
                                            <div>
                                                <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                            </div>
                                        </td>
                                    @elseif ($survey['status_id'] == 5)
                                        <td class="py-4">
                                            <div class="text-gawedata">
                                                <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                            </div>
                                        </td>
                                    @elseif ($survey['status_id'] == 6)
                                        <td class="py-4">
                                            <div class="text-green">
                                                <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                            </div>
                                        </td>
                                    @elseif ($survey['status_id'] == 7)
                                        <td class="py-4">
                                            <div class="text-finished">
                                                <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                            </div>
                                        </td>
                                    @elseif ($survey['status_id'] == 8)
                                        <td class="py-4">
                                            <div class="text-red">
                                                <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                            </div>
                                        </td>
                                    @elseif ($survey['status_id'] == 3)
                                        <td class="py-4">
                                            <div class="text-red">
                                                <span class="fa fa-fw fa-circle text-red me-2"></span>Rejected
                                            </div>
                                        </td>
                                    @else
                                        <td class="py-4"></td>
                                    @endif
                                    @if ($survey['is_private'])
                                        <td class="py-4">
                                            <div class="text-gray">
                                                <span class="fa fa-fw fa-lock me-2"></span>Private
                                            </div>
                                        </td>
                                    @else
                                        <td class="py-4">
                                            <div class="text-gawedata">
                                                <span class="fa fa-fw fa-globe me-2"></span>Public
                                            </div>
                                        </td>
                                    @endif
                                    <td class="py-4"><span class="fa fa-fw fa-users me-2"></span>
                                        {{ $survey['respondents_answered_question_count'] }}/{{ $survey['respondent_quota'] }}
                                        Responden</td>
                                    <td class="py-4">{{ date('d-m-y, H:i', strtotime($survey['created_at'])) }}
                                        WIB
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="row justify-content-center" id="survey-view-empty">
                    <div class="col-4 text-center font-nexa my-5 pt-5">
                        <img src="{{ asset('images/survey-empty.png') }}" alt="" srcset="">
                        <h5>Yuk, mulai buat survey</h5>
                    </div>
                </div>
            @endif
            @if ($surveys['total'] > 0)
                <nav id="survey-pagination">
                    <ul class="pagination justify-content-center">
                        @foreach ($surveys['links'] as $page)
                            <li
                                class="cursor-pointer page-item @if (!$page['url']) disabled @endif @if ($page['active']) active @endif">
                                @if ($loop->iteration == 1)
                                    <a onclick="changePage({{ $surveys['current_page'] - 1 }});" class="page-link">
                                        Previous
                                    </a>
                                @elseif ($loop->iteration == count($surveys['links']))
                                    <a onclick="changePage({{ $surveys['current_page'] + 1 }});" class="page-link">
                                        Next
                                    </a>
                                @else
                                    <a onclick="changePage({{ $page['label'] }});" class="page-link">
                                        {{ $page['label'] }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    {{-- to survey detail --}}
    <script>
        $(".survey-row").click(function() {
            if ($(this).data("status") == 3) {
                if (survey_type != 'Assessment') {
                    $('#reject-list-modal-' + $(this).data("id")).modal('show');
                }
            } else {
                window.location = $(this).data("href");
            }
        });
    </script>
    {{-- filter + sort --}}
    <script>
        var survey_sort = "";
        var survey_filter = "";
        var survey_page = 1;
        $(function() {
            $('#select-sort').find('li').click(function() {
                $('#selected-sort').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            });
        });

        function changePage(page) {
            survey_page = page;
            changeSortFilter(survey_filter, survey_sort, survey_page);
        };

        function changeFilter(filter) {
            survey_filter = filter;
            changeSortFilter(survey_filter, survey_sort, survey_page);
        }

        function changeSort(sort) {
            survey_sort = sort;
            changeSortFilter(survey_filter, survey_sort, survey_page);
        }

        function changeSortFilter(filter, sort, page) {
            $.post('{{ config('app.url') }}' + "/" + current_tab + "/filter_sort", {
                    _token: CSRF_TOKEN,
                    filter: filter,
                    sort: sort,
                    filter: survey_type,
                    page: page,
                    view: survey_view
                })
                .done(function(data) {
                    console.log(data);
                    $('#survey-container').html(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }
    </script>
    {{-- toggle view --}}
    <script>
        var survey_view = 'card';

        function toggleSurveyViewList() {
            if ($("#survey-view-grid").hasClass('d-block')) {
                survey_view = 'list';
                toggleSurveyView('#survey-view-list', '#survey-button-list', '#survey-view-grid', '#survey-button-grid')
            }
        }

        function toggleSurveyViewGrid() {
            if ($("#survey-view-list").hasClass('d-block')) {
                survey_view = 'card';
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
                $('#survey-category').val($(this).data("id"));
                enableFirstButton();
            });
            $('#select-survey-type').find('li').click(function() {
                $('#selected-survey-type').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
                if ($(this).data("type") == 'public') {
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
        //second step public
        function enableSecondButton() {
            if ($("#age-start").val() != "" &&
                $("#age-end").val() != "" &&
                $("#survey-province").val() != "" &&
                $("#survey-city").val() != "" &&
                $("#survey-education").val() != "" &&
                $("#survey-profession").val() != "" &&
                $("#survey-expense").val() != "") {
                if ($("#check-pria").prop("checked") == true ||
                    $("#check-wanita").prop("checked") == true) {
                    $("#create-survey-next-button-2-public").prop("disabled", false);
                } else {
                    $("#create-survey-next-button-2-public").prop("disabled", true);
                }
            } else {
                $("#create-survey-next-button-2-public").prop("disabled", true);
            }
        }
        $("#age-start").change(function() {
            $("#age-end").attr('min', $("#age-start").val());
        });
        $(document).ready(function() {
            $('#survey-province').select2({
                dropdownParent: $('#create-survey-modal'),
                placeholder: 'Domisili (Provinsi)'
            });
            $('#survey-city').select2({
                dropdownParent: $('#create-survey-modal'),
                placeholder: 'Domisili (Kota)',
                disabled: true
            });
            $('#survey-education').select2({
                dropdownParent: $('#create-survey-modal'),
                placeholder: 'Latar Belakang Pendidikan'
            });
            $('#survey-profession').select2({
                dropdownParent: $('#create-survey-modal'),
                placeholder: 'Profesi'
            });
            $('#survey-expense').select2({
                dropdownParent: $('#create-survey-modal'),
                placeholder: 'Pengeluaran Rumah Tangga Per-Bulan'
            });
        });
        //get city list
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#survey-province').on('change', function(e) {
            if ($('#survey-province').val().length == 0) {
                $('#survey-province').html('<option value="all">Semua Provinsi</option>')
                Object.values(@json($locations)).forEach(element => {
                    $('#survey-province').append('<option value="' + element.id +
                        '">' +
                        element.province_name + '</option>')
                });
            }
            if ($('#survey-province').val()[0] == 'all') {
                $('#survey-province').html('<option value="all" selected>Semua Provinsi</option>')
                $.post('{{ config('app.url') }}' + "/survey/getcity", {
                        _token: CSRF_TOKEN,
                    })
                    .done(function(data) {
                        $('#survey-city').html('');
                        $('#survey-city').val(null);
                        if (data.length == 0) {
                            $('#survey-city').prop("disabled", true);
                        } else {
                            $('#survey-city').prop("disabled", false);
                            $('#survey-city').append('<option value="all">Semua Kota</option>')
                            Object.values(data).forEach(element => {
                                element.cities.forEach(element => {
                                    $('#survey-city').append('<option value="' + element.id +
                                        '">' +
                                        element.type + " " + element.city_name + '</option>'
                                    )
                                });
                            });
                        }
                    })
                    .fail(function() {
                        console.log('fail');
                    });
            } else {
                $.post('{{ config('app.url') }}' + "/survey/getcity", {
                        _token: CSRF_TOKEN,
                        data: $('#survey-province').val(),
                    })
                    .done(function(data) {
                        $('#survey-city').html('');
                        $('#survey-city').val(null);
                        if (data.length == 0) {
                            $('#survey-city').prop("disabled", true);
                        } else {
                            $('#survey-city').prop("disabled", false);
                            $('#survey-city').append('<option value="all">Semua Kota</option>')
                            Object.values(data).forEach(element => {
                                element.cities.forEach(element => {
                                    $('#survey-city').append('<option value="' + element.id +
                                        '">' +
                                        element.type + " " + element.city_name + '</option>'
                                    )
                                });
                            });
                        }
                    })
                    .fail(function() {
                        console.log('fail');
                    });
            }
        });
        $("#check-pria").click(function() {
            enableSecondButton();
        });
        $("#check-wanita").click(function() {
            enableSecondButton();
        });
        $("#age-start").keyup(function() {
            enableSecondButton();
        });
        $("#age-end").keyup(function() {
            enableSecondButton();
        });
        $('#survey-city').on('change', function(e) {
            $('#survey-city-all').val(null);
            if ($('#survey-city').val().length == 0) {
                $('#survey-city').html('<option value="all">Semua Kota</option>')
                $('#survey-province').trigger('change')
            }
            if ($('#survey-city').val()[0] == 'all') {
                var selectedCities = [];
                $("#survey-city option").each(function() {
                    if ($(this).val() != 'all') {
                        selectedCities.push($(this).val());
                    }
                });
                $('#survey-city').html('<option value="all" selected>Semua Kota</option>')
                $("#survey-city-all").val(selectedCities);
            }
            enableSecondButton();
        });
        $('#survey-education').on('change', function(e) {
            $('#survey-education-all').val(null);
            if ($('#survey-education').val().length == 0) {
                $('#survey-education').html('<option value="all">Semua Pendidikan</option>')
                Object.values(@json($educations)).forEach(element => {
                    $('#survey-education').append('<option value="' + element.id +
                        '">' +
                        element.name + '</option>')
                });
            }
            if ($(this).val()[0] == 'all') {
                var selectedEducations = [];
                $("#survey-education option").each(function() {
                    if ($(this).val() != 'all') {
                        selectedEducations.push($(this).val());
                    }
                });
                $("#survey-education-all").val(selectedEducations);
                $('#survey-education').html('<option value="all" selected>Semua Pendidikan</option>')
            }
            enableSecondButton();
        });
        $('#survey-profession').on('change', function(e) {
            $('#survey-profession-all').val(null);
            if ($('#survey-profession').val().length == 0) {
                $('#survey-profession').html('<option value="all">Semua Profesi</option>')
                Object.values(@json($professions)).forEach(element => {
                    $('#survey-profession').append('<option value="' + element.id +
                        '">' +
                        element.name + '</option>')
                });
            }
            if ($(this).val()[0] == 'all') {
                var selectedProfessions = [];
                $("#survey-profession option").each(function() {
                    if ($(this).val() != 'all') {
                        selectedProfessions.push($(this).val());
                    }
                });
                $("#survey-profession-all").val(selectedProfessions);
                $('#survey-profession').html('<option value="all" selected>Semua Profesi</option>')
            }
            enableSecondButton();
        });
        $('#survey-expense').on('change', function(e) {
            $('#survey-expense-all').val(null);
            if ($('#survey-expense').val().length == 0) {
                $('#survey-expense').html('<option value="all">Semua Pengeluaran</option>')
                Object.values(@json($expenses)).forEach(element => {
                    $('#survey-expense').append('<option value="' + element.id +
                        '">' +
                        element.name + '</option>')
                });
            }
            if ($(this).val()[0] == 'all') {
                var selectedExpenses = [];
                $("#survey-expense option").each(function() {
                    if ($(this).val() != 'all') {
                        selectedExpenses.push($(this).val());
                    }
                });
                $("#survey-expense-all").val(selectedExpenses);
                $('#survey-expense').html('<option value="all" selected>Semua Pengeluaran</option>')
            }
            enableSecondButton();
        });
    </script>
    <script>
        //third step
        $(function() {
            $("#survey-deadline").datepicker({
                minDate: 0,
            });
        });

        function enableThirdButton() {
            if ($("#survey-deadline").val() != "" &&
                parseInt($("#survey-respondent").val()) <= parseInt($(".user-quota").html())) {
                $("#create-survey-next-button-3").prop("disabled", false);
            } else {
                $("#create-survey-next-button-3").prop("disabled", true);
            }
        }
        $("#survey-respondent").keyup(function() {
            if (parseInt($("#survey-respondent").val()) <= parseInt($(".user-quota").html())) {
                $('#survey-respondent').removeClass('is-invalid');
            } else {
                $('#survey-respondent').addClass('is-invalid');
            }
            enableThirdButton();
        });
        $("#survey-deadline").change(function() {
            enableThirdButton();
        });
    </script>
    <script>
        //change step
        function changeStep(beforeStep, afterStep, beforeSidebar, afterSidebar) {
            $(beforeStep).addClass('d-none');
            $(afterStep).removeClass('d-none');
            $('#create-survey-sidebar').find('li:nth-child(' + beforeSidebar + ')').removeClass('active');
            $('#create-survey-sidebar').find('li:nth-child(' + afterSidebar + ')').addClass('active');
            $('#create-survey-sidebar').find('li:nth-child(' + beforeSidebar + ')').find('div').removeClass('d-inline');
            $('#create-survey-sidebar').find('li:nth-child(' + beforeSidebar + ')').find('div').addClass('d-none');
            $('#create-survey-sidebar').find('li:nth-child(' + afterSidebar + ')').find('div').removeClass('d-none');
            $('#create-survey-sidebar').find('li:nth-child(' + afterSidebar + ')').find('div').addClass('d-inline');
        }
        $('#create-survey-next-button-1').click(function() {
            if ($('#survey-type').val() == 'Private') {
                changeStep('#first-step', '#second-step-private', 1, 2);
            } else {
                changeStep('#first-step', '#second-step-public', 1, 2);
            }
        })
        $('#create-survey-next-button-2-private').click(function() {
            changeStep('#second-step-private', '#third-step', 2, 3);
        })
        $('#create-survey-next-button-2-public').click(function() {
            changeStep('#second-step-public', '#third-step', 2, 3);
        })
        $('#create-survey-back-button-2-public').click(function() {
            changeStep('#second-step-public', '#first-step', 2, 1);
        })
        $('#create-survey-back-button-2-private').click(function() {
            changeStep('#second-step-private', '#first-step', 2, 1);
        })
        $('#create-survey-back-button-3').click(function() {
            if ($('#survey-type').val() == 'Private') {
                changeStep('#third-step', '#second-step-private', 3, 2);
            } else {
                changeStep('#third-step', '#second-step-public', 3, 2);
            }
        })
    </script>
    {{-- date range picker --}}
    {{-- https://www.daterangepicker.com/ --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        //create daily survey
        $(function() {
            $('input[name="daily_datepicker"]').daterangepicker({
                singleDatePicker: true,
                startDate: moment(),
                minDate: moment(),
            }, function(start, end, label) {
                console.log(start.format('YYYY-MM-DD'));
                $('#input-daily-date').val(start.format('YYYY-MM-DD'));
            });
            $('input[name="daily_timepicker"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                minDate: moment(),
                locale: {
                    format: 'HH:mm'
                }
            }, function(start, end, label) {
                console.log(start.format('HH:mm'));
                $('#input-daily-start').val(start.format('HH:mm'));
                $('#input-daily-end').val(end.format('HH:mm'));
                console.log($('#input-daily-start').val());
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
            });
        });

        function changePointValue(type) {
            if (type == "+") {
                $('#survey-points-daily').val(+$('#survey-points-daily').val() + 1);
            } else {
                if ($('#survey-points-daily').val() > 0) {
                    $('#survey-points-daily').val(+$('#survey-points-daily').val() - 1);
                }
            }
        }
    </script>
    {{-- daily survey tabs --}}
    <script>
        var survey_type = 'General';
        var current_tab = 'survey';

        function changeType(type) {
            survey_type = type;
            if (type != 'Assessment') {
                current_tab = 'survey';
                if (type == 'Daily') {
                    //ke daily
                    $('#tab-general').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                    $('#tab-assessment').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                    $('#tab-daily').removeClass('tab-gawedata').addClass('tab-gawedata-active');
                    $('#create-survey-daily').removeClass('d-none').addClass('d-block');
                    $('#create-survey-general').removeClass('d-block').addClass('d-none');
                    $('#create-assessment').removeClass('d-block').addClass('d-none');
                } else {
                    //ke general
                    $('#tab-general').removeClass('tab-gawedata').addClass('tab-gawedata-active');
                    $('#tab-assessment').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                    $('#tab-daily').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                    $('#create-survey-daily').removeClass('d-block').addClass('d-none');
                    $('#create-survey-general').removeClass('d-none').addClass('d-block');
                    $('#create-assessment').removeClass('d-block').addClass('d-none');
                }
                changeSortFilter(survey_filter, survey_sort, 1);
            } else {
                current_tab = 'assessment';
                $('#tab-assessment').removeClass('tab-gawedata').addClass('tab-gawedata-active');
                $('#tab-general').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                $('#tab-daily').removeClass('tab-gawedata-active').addClass('tab-gawedata');
                $('#create-assessment').removeClass('d-none').addClass('d-block');
                $('#create-survey-general').removeClass('d-block').addClass('d-none');
                $('#create-survey-daily').removeClass('d-block').addClass('d-none');
                changeSortFilter(survey_filter, survey_sort, 1);
            }
        }

        function changeToAssessment(sort, page) {

            $.post('{{ config('app.url') }}' + "/assessment/get_assessment", {
                    _token: CSRF_TOKEN,
                    sort: sort,
                    page: page
                })
                .done(function(data) {
                    $('#survey-container').html(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }
    </script>
    {{-- assessment --}}
    <script>
        var assessment_type = 'irt';
        var serentak = false;

        function changeAssessmentType(type) {
            //remove serentak
            if (type != 'rs') {
                serentak = false;
                $('#with_ranking_rs').prop('checked', false);
                $('.serentak').removeClass('d-block').addClass('d-none');
                $('.non-serentak').removeClass('d-none').addClass('d-block');
            }
            if (type != 'irt') {
                serentak = false;
                $('#with_ranking_irt').prop('checked', false);
                $('.serentak').removeClass('d-block').addClass('d-none');
                $('.non-serentak').removeClass('d-none').addClass('d-block');
            }
            assessment_type = type;
            $('#radio-label-assessment-irt').removeClass('active');
            $('#radio-label-assessment-rs').removeClass('active');
            $('#radio-label-assessment-sa').removeClass('active');
            $('#radio-label-assessment-' + type).addClass('active');
            $('.assessment-irt').removeClass('d-block').addClass('d-none');
            $('.assessment-rs').removeClass('d-block').addClass('d-none');
            $('.assessment-sa').removeClass('d-block').addClass('d-none');
            $('.assessment-' + type).removeClass('d-none').addClass('d-block');
            if (type == 'irt' || type == 'rs') {
                toggleSerentak();
            }
            $('#assessment-method').val(type);
            if (serentak) {
                $('#assessment-serentak').val('true');
            } else {
                $('#assessment-serentak').val('false');
            }
            enableSecondAssessmentButton();
        }

        function toggleSerentak() {
            if ($('#with_ranking_irt').prop("checked") == true || $('#with_ranking_rs').prop("checked") == true) {
                serentak = true;
                $('.non-serentak').removeClass('d-block').addClass('d-none');
                $('.serentak').removeClass('d-none').addClass('d-block');
            } else {
                serentak = false;
                $('.serentak').removeClass('d-block').addClass('d-none');
                $('.non-serentak').removeClass('d-none').addClass('d-block');
            }
        }
        //change step
        function changeAssessmentStep(beforeStep, afterStep, beforeSidebar, afterSidebar) {
            $(beforeStep).addClass('d-none');
            $(afterStep).removeClass('d-none');
            $('.create-assessment-sidebar').find('li:nth-child(' + beforeSidebar + ')').removeClass('active');
            $('.create-assessment-sidebar').find('li:nth-child(' + afterSidebar + ')').addClass('active');
            $('.create-assessment-sidebar').find('li:nth-child(' + beforeSidebar + ')').find('div').removeClass('d-inline');
            $('.create-assessment-sidebar').find('li:nth-child(' + beforeSidebar + ')').find('div').addClass('d-none');
            $('.create-assessment-sidebar').find('li:nth-child(' + afterSidebar + ')').find('div').removeClass('d-none');
            $('.create-assessment-sidebar').find('li:nth-child(' + afterSidebar + ')').find('div').addClass('d-inline');
        }
        $('#create-assessment-next-button-1').click(function() {
            changeAssessmentStep('#assessment-first-step', '#assessment-second-step', 1, 2);
        })
        $('#create-assessment-next-button-2').click(function() {
            if (assessment_type == 'irt') {
                changeAssessmentStep('#assessment-second-step', '#assessment-third-step-irt', 2,
                    3);
            } else {
                document.getElementById('create-assessment-form').submit();
            }
        })
        $('#create-assessment-back-button-2').click(function() {
            changeAssessmentStep('#assessment-second-step', '#assessment-first-step', 2, 1);
        })
        $('#create-assessment-next-button-3-irt').click(function() {
            changeAssessmentStep('#assessment-third-step-irt',
                '#assessment-fourth-step-irt', 3, 4);
        })
        $('#create-assessment-next-button-4-irt').click(function() {
            document.getElementById('create-assessment-form').submit();
        })
        $('#create-assessment-back-button-3-irt').click(function() {
            changeAssessmentStep('#assessment-third-step-irt', '#assessment-second-step', 3, 2);
        })
        $('#create-assessment-back-button-4-irt').click(function() {
            changeAssessmentStep('#assessment-fourth-step-irt',
                '#assessment-third-step-irt', 4, 3);
        })
    </script>
    {{-- second step --}}
    <script>
        $(function() {
            $("#assessment-date").datepicker();
        });
        $(function() {
            $('#assessment-start-time-non-serentak').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                startDate: moment(),
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                timePickerIncrement: 1,
                drops: "up",
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            }, function(start, end, label) {});
            $('#assessment-start-time-non-serentak').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                $('input[name="start_time"]').val(picker.startDate.format('YYYY-MM-DD'));
                setEndTimeNS(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });
            $('#assessment-end-time-non-serentak').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                startDate: moment(),
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                timePickerIncrement: 1,
                drops: "up",
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            }, function(start, end, label) {});
            $('#assessment-end-time-non-serentak').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                $('input[name="end_time"]').val(picker.startDate.format('YYYY-MM-DD'));
                setStartTimeNS(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });

            function setStartTimeNS(time) {
                $('#assessment-start-time-non-serentak').daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate: moment(),
                    maxDate: time,
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerSeconds: true,
                    timePickerIncrement: 1,
                    drops: "up",
                    locale: {
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                }, function(start, end, label) {});
                $('#assessment-start-time-non-serentak').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                    $('input[name="start_time"]').val(picker.startDate.format('YYYY-MM-DD'));
                    setEndTimeNS(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                });
            }

            function setEndTimeNS(time) {
                $('#assessment-end-time-non-serentak').daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate: time,
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerSeconds: true,
                    timePickerIncrement: 1,
                    drops: "up",
                    locale: {
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                }, function(start, end, label) {});
                $('#assessment-end-time-non-serentak').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                    $('input[name="end_time"]').val(picker.startDate.format('YYYY-MM-DD'));
                    setStartTimeNS(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                });
            }
            $('#assessment-start-time').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                startDate: moment(),
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                timePickerIncrement: 1,
                drops: "up",
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            }, function(start, end, label) {});
            $('#assessment-start-time').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });
            $('#assessment-end-time').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                startDate: moment(),
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                timePickerIncrement: 1,
                drops: "up",
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            }, function(start, end, label) {});
            $('#assessment-end-time').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });
        });

        function enableSecondAssessmentButton() {
            if (serentak) {
                if ($("#assessment-title").val() != "" &&
                    $("#assessment-description").val() != "" &&
                    $("#assessment-duration").val() != "" &&
                    $("#assessment-start-time").val() != "" &&
                    $("#assessment-type").val() != "") {
                    $("#create-assessment-next-button-2").prop("disabled", false);
                } else {
                    $("#create-assessment-next-button-2").prop("disabled", true);
                }
            } else {
                if (assessment_type != 'sa') {
                    if ($("#assessment-title").val() != "" &&
                        $("#assessment-description").val() != "" &&
                        $("#assessment-duration").val() != "" &&
                        $("#assessment-start-time-non-serentak").val() != "" &&
                        $("#assessment-end-time-non-serentak").val() != "" &&
                        $("#assessment-type").val() != "") {
                        $("#create-assessment-next-button-2").prop("disabled", false);
                    } else {
                        $("#create-assessment-next-button-2").prop("disabled", true);
                    }
                } else {
                    if ($("#assessment-title").val() != "" &&
                        $("#assessment-description").val() != "" &&
                        $("#assessment-end-time").val() != "" &&
                        $("#assessment-type").val() != "") {
                        $("#create-assessment-next-button-2").prop("disabled", false);
                    } else {
                        $("#create-assessment-next-button-2").prop("disabled", true);
                    }
                }
            }
        }
        $(function() {
            $('#select-assessment-type').find('li').click(function() {
                $('#selected-assessment-type').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
                if ($(this).data("type") == 'public') {
                    $('#assessment-type').val('Public');
                } else {
                    $('#assessment-type').val('Private');
                }
                enableSecondAssessmentButton();
            });
        });
        $("#assessment-title").keyup(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-description").keyup(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-duration").keyup(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-start-time-non-serentak").change(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-end-time-non-serentak").change(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-start-time").change(function() {
            enableSecondAssessmentButton();
        });
        $("#assessment-end-time").change(function() {
            enableSecondAssessmentButton();
        });
    </script>
    {{-- third step irt rs --}}
    <script>
        function enableThirdAssessmentIRTButton() {
            if ($("#assessment-easy-in-percent").val() != "" &&
                $("#assessment-medium-in-percent").val() != "" &&
                $("#assessment-hard-in-percent").val() != "") {
                $("#create-assessment-next-button-3-irt").prop("disabled", false);
            } else {
                $("#create-assessment-next-button-3-irt").prop("disabled", true);
            }
        }

        $("#assessment-easy-in-percent").keyup(function() {
            enableThirdAssessmentIRTButton();
        });
        $("#assessment-medium-in-percent").keyup(function() {
            enableThirdAssessmentIRTButton();
        });
        $("#assessment-hard-in-percent").keyup(function() {
            enableThirdAssessmentIRTButton();
        });
    </script>
    {{-- fourth step irt rs --}}
    <script>
        function addPoints(difficulty) {
            $('#assessment-' + difficulty + '-in-points').val(parseInt($('#assessment-' + difficulty + '-in-points')
                .val()) + 1);
        }

        function subtractPoints(difficulty) {
            $('#assessment-' + difficulty + '-in-points').val(parseInt($('#assessment-' + difficulty + '-in-points')
                .val()) - 1);
        }
    </script>
@endsection
