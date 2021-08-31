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
                        <li>
                            <a class="dropdown-item" href="#" id="filter-general"
                                onclick="changeFilter('general');">General</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="filter-daily" onclick="changeFilter('daily');">Daily</a>
                        </li>
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
        <div id="survey-container">
            @if (count($surveys) > 0)
                <div class="d-block" id="survey-view-grid">
                    <div class="row gy-4 mb-4" id="survey-view-grid-box">
                        @foreach ($surveys as $survey)
                            <a href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}"
                                class="col-3 text-decoration-none">
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
                                        <span class="fa fa-fw fa-users me-2"></span> 0/{{ $survey['respondent_quota'] }}
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
                            @foreach ($surveys as $survey)
                                <tr class="survey-row cursor-pointer @if ($loop->iteration > 1) border-top @endif"
                                    data-href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}">
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
                                        0/{{ $survey['respondent_quota'] }} Responden</td>
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
        </div>
    </div>
@endsection

@section('scripts')
    {{-- to survey detail --}}
    <script>
        $(".survey-row").click(function() {
            window.location = $(this).data("href");
        });
    </script>
    {{-- filter + sort --}}
    <script>
        var survey_sort = "";
        var survey_filter = "";
        $(function() {
            $('#select-filter').find('li').click(function() {
                $('#selected-filter').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            });
            $('#select-sort').find('li').click(function() {
                $('#selected-sort').html($(this).text() +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            });
        });

        function changeFilter(filter) {
            survey_filter = filter;
            changeSortFilter(survey_filter, survey_sort);
        }

        function changeSort(sort) {
            survey_sort = sort;
            changeSortFilter(survey_filter, survey_sort);
        }

        function changeSortFilter(filter, sort) {
            $.post('{{ config('app.url') }}' + "/survey/filter_sort", {
                    _token: CSRF_TOKEN,
                    filter: filter,
                    sort: sort,
                })
                .done(function(data) {
                    $('#survey-container').html(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }
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
                                        element.city_name + '</option>')
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
                                        element.city_name + '</option>')
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
            $("#survey-deadline").datepicker();
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
@endsection
