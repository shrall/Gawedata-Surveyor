@extends('layouts.app')

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
                                    @if ($survey['questions'][$i - 1]['survey_question_type_id'] == 1)
                                        Single Answer
                                    @elseif ($survey['questions'][$i-1]['survey_question_type_id'] == 2)
                                        Multiple Answer
                                    @elseif ($survey['questions'][$i-1]['survey_question_type_id'] == 3)
                                        Scale Question
                                    @elseif ($survey['questions'][$i-1]['survey_question_type_id'] == 4)
                                        Grid Question
                                    @elseif ($survey['questions'][$i-1]['survey_question_type_id'] == 5)
                                        Priority Question
                                    @elseif ($survey['questions'][$i-1]['survey_question_type_id'] == 6)
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
                    <div id="#single-answer-question">
                        <div class="row justify-content-end">
                            <div class="col-5">
                                <h6 class="text-start text-gray my-2" id="question-type-text-guide" style="font-size: 0.">
                                    Responden hanya dapat memilih 1
                                    jawaban.</h6>
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
        var survey = @json($survey);
        var question = @json($survey['questions'][$i - 1]);
        var answers = @json($survey['questions'][$i - 1]['answer_choices']);
    </script>
    <script>
        // answer templates
        var new_answer_single = {
            "text": "",
        };
    </script>
    <script>
        $('#select-question-type').find('li').click(function() {
            $('#selected-question-type').html($(this).text() +
                '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            $('#question-type').val($(this).data("type"));
            question['survey_question_type_id'] = $(this).data("type");
            if ($(this).data("type") == 1 || $(this).data("type") == 2) {
                answers = [new_answer_single];
                refreshSingleAnswerAjax();
            }
            if ($(this).data("type") == 1) {
                $('#question-type-text-guide').html('Responden hanya dapat memilih 1 jawaban.')
            } else if ($(this).data("type") == 2) {
                $('#question-type-text-guide').html('Responden dapat memilih lebih dari 1 jawaban.')
            }
        });
    </script>
    <script>
        // single answer
        function addSingleAnswer() {
            answers.push(new_answer_single);
            refreshSingleAnswerAjax();
        }

        function deleteSingleAnswer(int) {
            answers.splice(int - 1, 1);
            refreshSingleAnswerAjax();
        }

        function refreshSingleAnswerAjax() {
            $.post("{{ config('app.url') }}" + "/survey/refreshanswer", {
                    _token: CSRF_TOKEN,
                    answers: answers
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
