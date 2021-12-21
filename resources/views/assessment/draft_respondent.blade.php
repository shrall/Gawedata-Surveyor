@extends('layouts.app')

@php
$assessment_type_id = $assessment['assessment_type_id'] ?? null;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end" style="min-height: 90vh;">
                @include('assessment.inc.sidebar.draft_respondent')
            </div>
            @if (count($assessment['respondent_types']) > 0 || $new == 'true')
                <div class="col-7 my-4">
                    <h4 class="font-lato text-start ms-5">Buat Kategori</h4>
                    <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                        @if ($assessment_type_id == 3)
                            <div id="sa-question" class="mb-3">
                                <h6 class="text-start row" id="sa-question-title">
                                    <div class="col-6">
                                        Kategori
                                    </div>
                                    <div class="col-3">
                                        Poin Minimal
                                    </div>
                                    <div class="col-3">
                                        Poin Maksimal
                                    </div>
                                </h6>
                                <div class="sa-answer-list">
                                    <div class="row mb-3">
                                        <div class="col-6 position-relative">
                                            <input type="text" name="answer" id="input-respondent-type-name"
                                                class="form-control input-text" placeholder="Tuliskan Jawaban Disini"
                                                value="{{ $assessment['respondent_types'][$i - 1]['name'] ?? '' }}"
                                                onkeyup="setRespondentTypeName();">
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="subtractPoints('min');">-</span>
                                                <input type="number" class="form-control input-text text-center"
                                                    value={{ $assessment['respondent_types'][$i - 1]['min_points'] ?? 0 }}
                                                    onkeyup="setPoints('min');" id="input-respondent-type-min-points">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="addPoints('min');">+</span>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="subtractPoints('max');">-</span>
                                                <input type="number" class="form-control input-text text-center"
                                                    value={{ $assessment['respondent_types'][$i - 1]['max_points'] ?? 100 }}
                                                    onkeyup="setPoints('max');" id="input-respondent-type-max-points">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="addPoints('max');">+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment['with_discussion'])
                            <h6 class="text-start">Pembahasan</h6>
                            <div class="row">
                                <div class="col-12 position-relative">
                                    <textarea type="text" name="discussion" id="input-discussion"
                                        class="form-control input-text"
                                        style="resize: none; height:8rem;">{{ $assessment['respondent_types'][$i - 1]['discussion'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="text-start me-auto">
                                <button class="btn btn-gawedata-danger" @if ($new == 'true') disabled @endif
                                    onclick="event.preventDefault();
                                                                                        document.getElementById('delete-respondent-form').submit();">
                                    <span class="fas fa-fw fa-trash-alt me-2"></span>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($new == 'false')
        <form action="{{ route('assessment.updaterespondenttype') }}" method="post" class="d-none"
            id="update-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="respondent_type_id"
                value="{{ $assessment['respondent_types'][$i - 1]['id'] ?? null }}">
            <input type="hidden" name="respondent_type_count" value={{ count($assessment['respondent_types']) }}>
            <input type="hidden" name="name" class="respondent-type-name"
                value="{{ $assessment['respondent_types'][$i - 1]['name'] ?? '' }}">
            <input type="hidden" name="new_bool" class="respondent-type-new-bool">
            <input type="hidden" name="change_tab_bool" class="respondent-type-change-tab-bool">
            <input type="hidden" name="next" class="respondent-type-next">
            <input type="hidden" name="min_points" class="respondent-type-min-points"
                value={{ $assessment['respondent_types'][$i - 1]['min_points'] ?? 0 }}>
            <input type="hidden" name="max_points" class="respondent-type-max-points"
                value={{ $assessment['respondent_types'][$i - 1]['max_points'] ?? 100 }}>
            <input type="hidden" name="discussion" class="respondent-type-discussion"
                value={{ $assessment['respondent_types'][$i - 1]['discussion'] ?? '' }}>
            <input type="hidden" name="submit_question" id="submit-question">
        </form>
        <form action="{{ route('assessment.deleterespondenttype') }}" method="post" class="d-none"
            id="delete-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="respondent_type_id"
                value="{{ $assessment['respondent_types'][$i - 1]['id'] ?? null }}">
            <input type="hidden" name="respondent_type_count" value={{ count($assessment['respondent_types']) }}>
        </form>
    @else
        <form action="{{ route('assessment.createrespondenttype') }}" method="post" class="d-none"
            id="create-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="name" class="respondent-type-name">
            <input type="hidden" name="new_bool" class="respondent-type-new-bool">
            <input type="hidden" name="change_tab_bool" class="respondent-type-change-tab-bool">
            <input type="hidden" name="next" class="respondent-type-next">
            <input type="hidden" name="min_points" class="respondent-type-min-points" value=0>
            <input type="hidden" name="max_points" class="respondent-type-max-points" value=100>
            <input type="hidden" name="discussion" class="respondent-type-discussion" value="">
            <input type="hidden" name="submit_question" id="submit-question">
        </form>
    @endif
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var respondent_types = @json($assessment['respondent_types']);
        var respondent_type_index = @json($i - 1);
    </script>
    <script>
        $('#survey-setting-button').click(function() {
            console.log(questions)
        });
    </script>
    <script>
        var saveClicked = false;

        function saveDraft(index, new_bool) {
            event.preventDefault();
            if (!saveClicked) {
                if (new_bool) {
                    $('.respondent-type-new-bool').val(1)
                }
                $('.respondent-type-next').val(index)
                if ({{ $new }}) {
                    document.getElementById('create-respondent-form').submit();
                } else {
                    document.getElementById('update-respondent-form').submit();
                }
                saveClicked = true;
            }
        }
    </script>
    <script>
        function submitSurvey() {
            $('#submit-question').val(1);
            $('#submit-modal-content').removeClass('d-block').addClass('d-none');
            $('#submitted-modal-content').removeClass('d-none').addClass('d-block');
        }
    </script>
    <script>
        var loadFile = function(event) {
            var formData = new FormData();
            formData.append('image', $('#photo')[0].files[0]);
            $.ajax({
                url: "{{ config('services.api.url') }}" + "/image",
                type: 'POST',
                "mimeType": "multipart/form-data",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                headers: {
                    "Authorization": "Bearer {{ session('token') }}",
                },
                success: function(data) {
                    $('.survey-question-image-preview').attr('src', URL.createObjectURL(event.target.files[
                        0]));
                    questions[question_index]['image_path'] = @json(config('services.asset.url')) + '/' + JSON.parse(
                        data)['data']['path']
                },
            }).fail(function(error) {
                console.log(error);
            });
        };
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @if ($assessment['with_discussion'])
        <script src="{{ asset('js/ckeditor.js') }}"></script>
        <script>
            ClassicEditor.create(document.querySelector('#input-discussion'), {
                    simpleUpload: {
                        uploadUrl: {
                            url: "{{ route('assessment.uploadphotodiscussion') }}"
                        }
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                }).then(editor => {
                    console.log(editor);
                    if (questions[question_index]['discussion']) {
                        editor.setData(questions[question_index]['discussion']);
                    }
                    editor.model.document.on('change:data', () => {
                        questions[question_index]['discussion'] = editor.getData();
                        console.log(editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.stack);
                });
        </script>
    @endif
    <script>
        function setRespondentTypeName() {
            $('.respondent-type-name').val($('#input-respondent-type-name').val());
            console.log($('.respondent-type-name').val());
        }

        function setPoints(type) {
            $('.respondent-type-' + type + '-points').val($('#input-respondent-type-' + type + '-points').val());
            console.log($('.respondent-type-' + type + '-points').val());
        }

        function subtractPoints(type) {
            $('#input-respondent-type-' + type + '-points').val(parseInt($('#input-respondent-type-' + type + '-points')
                .val()) - 1);
            setPoints(type);
        }

        function addPoints(type) {
            $('#input-respondent-type-' + type + '-points').val(parseInt($('#input-respondent-type-' + type + '-points')
                .val()) + 1);
            setPoints(type);
        }
    </script>
    <script>
        function changeTab(type) {
            $('.respondent-type-change-tab-bool').val(1)
            saveDraft(1, false);
        }
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                startDate: "{{ $assessment['start_time'] }}",
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
            });
            $('#assessment-end-time-non-serentak').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                startDate: "{{ $assessment['end_time'] }}",
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
            });
            $('#assessment-start-time').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                startDate: "{{ $assessment['start_time'] }}",
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
                startDate: "{{ $assessment['end_time'] }}",
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
