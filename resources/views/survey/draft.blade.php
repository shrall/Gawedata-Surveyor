@extends('layouts.app')

@php
$question_type_id = $survey['questions'][$i - 1]['survey_question_type_id'];
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar.draft')
            </div>
            <div class="col-7 text-center my-4">
                <h4 class="font-lato text-start ms-5">Buat Pertanyaan</h4>
                <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                    <h6 class="text-start">Pertanyaan</h6>
                    <div class="row">
                        <div class="col-7 position-relative">
                            <span
                                class="badge-pertanyaan position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                style="color: #3f60f5 !important;">P{{ $i }}</span>
                            <input type="text" name="question" id="input-question" class="form-control input-text"
                                style="padding-left:3.5rem !important;" placeholder="Tuliskan Pertanyaan Disini"
                                value="{{ $survey['questions'][$i - 1]['question'] }}">
                        </div>
                        <div class="col-5">
                            <input type="hidden" name="question-type">
                            <div class="dropdown" id="select-question-type">
                                <span class="form-control input-text d-flex align-items-center" type="button"
                                    data-bs-toggle="dropdown" id="selected-question-type">
                                    @if ($question_type_id == 1)
                                        Single Answer
                                    @elseif ($question_type_id == 2)
                                        Multiple Answer
                                    @elseif ($question_type_id == 3)
                                        Scale Question
                                    @elseif ($question_type_id == 4)
                                        Grid Question
                                    @elseif ($question_type_id == 5)
                                        Priority Question
                                    @elseif ($question_type_id == 6)
                                        Open Ended Question
                                    @else
                                        Action
                                    @endif
                                    <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                </span>
                                <ul class="dropdown-menu w-100 px-2">
                                    <div class="overflow-auto px-1" style="min-height:0;max-height: 30vh;">
                                        <li class="dropdown-item" data-type=1>Single Answer</li>
                                        <li class="dropdown-item" data-type=2>Multiple Answer</li>
                                        <li class="dropdown-item" data-type=3>Scale Question</li>
                                        <li class="dropdown-item" data-type=4>Grid Question</li>
                                        <li class="dropdown-item" data-type=5>Priority Question</li>
                                        <li class="dropdown-item" data-type=6>Open Ended Question</li>
                                        <li class="dropdown-item" data-type=7>Action</li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="single-answer-question" class="@if ($question_type_id==1 ||
                    $question_type_id==2 || $question_type_id==5) d-block @else d-none @endif">
                        <div class="row justify-content-end">
                            <div class="col-5">
                                <h6 class="question-type-text-guide text-start text-gray my-2" style="font-size: 0.875rem;">
                                    @if ($question_type_id == 1)
                                        Responden hanya dapat memilih 1 jawaban.
                                    @elseif ($question_type_id == 2)
                                        Responden dapat memilih lebih dari 1 jawaban.
                                    @elseif ($question_type_id == 5)
                                        Responden mengurutkan jawaban.
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <h6 class="text-start">Jawaban</h6>
                        <div class="single-answer-list">
                            @foreach ($survey['questions'][$i - 1]['answer_choices'] as $answer)
                                <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                    <div class="col-7 position-relative">
                                        <span
                                            class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                            id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                        <input type="text" name="answer{{ $loop->iteration }}"
                                            id="answer{{ $loop->iteration }}" class="form-control input-text"
                                            style="padding-left:3.5rem !important;" placeholder="Tuliskan Jawaban Disini"
                                            value="{{ $answer['text'] }}">
                                    </div>
                                    <div class="col-5 text-start d-flex align-items-center">
                                        <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                            id="answer_delete{{ $loop->iteration }}"
                                            onclick="deleteSingleAnswer({{ $loop->iteration }});"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addSingleAnswer();">
                                    + Tambah Jawaban
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="scale-question" class="@if ($question_type_id==3) d-block @else d-none @endif">
                        <div class="row justify-content-end">
                            <div class="col-5">
                                <h6 class="question-type-text-guide text-start text-gray my-2" style="font-size: 0.875rem;">
                                    Responden mengurutkan jawaban berdasarkan peringkat.
                                </h6>
                            </div>
                        </div>
                        <h6 class="text-start">Jawaban</h6>
                        <div class="scale-answer">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center">
                                    <input type="number" name="minimal_scale" id="minimal_scale"
                                        value="{{ $survey['questions'][$i - 1]['minimal_scale'] }}"
                                        class="form-control input-text text-center">
                                    <span class="mx-2">sampai</span>
                                    <input type="number" name="maximal_scale" id="maximal_scale"
                                        value="{{ $survey['questions'][$i - 1]['maximal_scale'] }}"
                                        class="form-control input-text text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="open-ended-question" class="@if ($question_type_id==6) d-block @else d-none @endif">
                        <div class="row justify-content-end">
                            <div class="col-5">
                                <h6 class="question-type-text-guide text-start text-gray my-2" style="font-size: 0.875rem;">
                                    Responden menjawab berupa opini atau penjelasan.
                                </h6>
                            </div>
                        </div>
                        <h6 class="text-start">Jawaban</h6>
                        <div class="open-ended-answer">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" name="open_ended_answer" id="open_ended_answer"
                                        class="form-control input-text" placeholder="Responden akan menjawab sendiri"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center justify-content-between">
                        <div class="col-3 text-start">
                            <button class="btn btn-gawedata-danger"><span
                                    class="fas fa-fw fa-trash-alt me-2"></span>Hapus</button>
                        </div>
                        <div class="col-3 text-end">
                            <button class="btn btn-gawedata-3"><span class="fas fa-fw fa-image me-2"></span>Gambar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var questions = @json($survey['questions']);
        var question_index = @json($i - 1);
    </script>
    <script>
        // answer templates
        var new_answer_single = {
            "text": "",
        };
    </script>
    <script>
        function changeQuestionType() {
            $('#single-answer-question').removeClass('d-block').addClass('d-none');
            $('#scale-question').removeClass('d-block').addClass('d-none');
            $('#open-ended-question').removeClass('d-block').addClass('d-none');
            questions[question_index]['answer_choices'] = null;
            questions[question_index]['minimal_scale'] = null;
            questions[question_index]['maximal_scale'] = null;
            $('#minimal_scale').val('');
            $('#maximal_scale').val('');
            $('#minimal_scale').removeAttr('value');
            $('#maximal_scale').removeAttr('value');
        }
        $('#select-question-type').find('li').click(function() {
            $('#selected-question-type').html($(this).text() +
                '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            $('#question-type').val($(this).data("type"));
            questions[question_index]['survey_question_type_id'] = $(this).data("type");
            changeQuestionType();
            if ($(this).data("type") == 1) {
                questions[question_index]['answer_choices'] = [new_answer_single];
                refreshSingleAnswerAjax();
                $('.question-type-text-guide').html('Responden hanya dapat memilih 1 jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 2) {
                questions[question_index]['answer_choices'] = [new_answer_single];
                refreshSingleAnswerAjax();
                $('.question-type-text-guide').html('Responden dapat memilih lebih dari 1 jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 3) {
                $('.question-type-text-guide').html('Responden mengurutkan jawaban berdasarkan peringkat.')
                $('#scale-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 5) {
                questions[question_index]['answer_choices'] = [new_answer_single];
                refreshSingleAnswerAjax();
                $('.question-type-text-guide').html('Responden mengurutkan jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 6) {
                $('.question-type-text-guide').html('Responden menjawab berupa opini atau penjelasan.')
                $('#open-ended-question').removeClass('d-none').addClass('d-block');
            }

        });
    </script>
    <script>
        // single answer
        function addSingleAnswer() {
            questions[question_index]['answer_choices'].push(new_answer_single);
            refreshSingleAnswerAjax();
        }

        function deleteSingleAnswer(int) {
            questions[question_index]['answer_choices'].splice(int - 1, 1);
            if (questions[question_index]['answer_choices'].length > 0) {
                refreshSingleAnswerAjax();
            } else {
                $('#question-answer' + int).remove();
            }
        }

        function refreshSingleAnswerAjax() {
            $.post("{{ config('app.url') }}" + "/survey/refreshsingleanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".single-answer-list").html(data)
                })
                .fail(function() {
                    console.log("fail");
                });
        }
    </script>
@endsection
