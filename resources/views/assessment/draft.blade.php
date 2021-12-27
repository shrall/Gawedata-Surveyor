@extends('layouts.app')

@php
$assessment_type_id = $assessment['assessment_type_id'] ?? null;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end" style="min-height: 90vh;">
                @include('assessment.inc.sidebar.draft')
            </div>
            <div class="col-7 my-4">
                @if (count($assessment['questions']) > 0)
                    <h4 class="font-lato text-start ms-5">Buat Pertanyaan</h4>
                    <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                        <h6 class="text-start">Pertanyaan</h6>
                        <div class="row">
                            <div class="col-12 position-relative">
                                <span
                                    class="badge-pertanyaan position-absolute start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                    style="color: #3f60f5 !important; top:1.75rem;">P{{ $i }}</span>
                                <textarea type="text" name="question" id="input-question" class="form-control input-text"
                                    style="padding-left:3.5rem !important;resize: none; height:8rem;"
                                    placeholder="Tuliskan Pertanyaan Disini"
                                    onkeyup="setQuestion()">{{ $assessment['questions'][$i - 1]['question'] == 'Pertanyaan Baru' ? '' : $assessment['questions'][$i - 1]['question'] }}</textarea>
                            </div>
                        </div>
                        @if ($assessment_type_id == 1)
                            <div id="irt-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7 position-relative mt-2" style="padding-right: 0;">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100">
                                        @if ($assessment['questions'][$i - 1]['image_path'])
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image"
                                                onclick="deleteQuestionImage();"></span>
                                        @else
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image d-none"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image d-none"
                                                onclick="deleteQuestionImage();"></span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start mt-2" id="irt-question-title">Jawaban <span
                                        class="font-weight-bold">(Pilih
                                        satu yang benar)</span></h6>
                                <div class="irt-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-1 text-start d-flex align-items-center">
                                                @if ($answer['is_right_answer'])
                                                    <span
                                                        class="fas fa-fw fa-check-circle text-gawedata cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @else
                                                    <span
                                                        class="far fa-fw fa-circle text-gray cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @endif
                                            </div>
                                            <div class="col-7 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] == 'Answer Choice 1' || $answer['text'] == 'Answer Choice 2' ? '' : $answer['text'] }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-3">
                                                <div class="input-group">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="subtractAnswerPoints({{ $loop->iteration }});">-</span>
                                                    <input type="number" class="form-control input-text text-center"
                                                        value={{ $answer['points'] }}
                                                        onkeyup="setAnswerPoints({{ $loop->iteration }});"
                                                        id="answer-points-{{ $loop->iteration }}">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="addAnswerPoints({{ $loop->iteration }});">+</span>
                                                </div>
                                            </div>
                                            <div class="col-1 text-start d-flex align-items-center">
                                                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                                    id="answer_delete{{ $loop->iteration }}"
                                                    onclick="deleteAnswer({{ $loop->iteration }});"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment_type_id == 2)
                            <div id="rs-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7 position-relative mt-2" style="padding-right: 0;">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100">
                                        @if ($assessment['questions'][$i - 1]['image_path'])
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image"
                                                onclick="deleteQuestionImage();"></span>
                                        @else
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image d-none"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image d-none"
                                                onclick="deleteQuestionImage();"></span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start row mt-2" id="rs-question-title">
                                    <div class="col-8">
                                        Jawaban <span class="font-weight-bold">(Pilih satu yang benar)</span>
                                    </div>
                                    <div class="col-4">
                                        Poin <span class="text-gray">(Positif (+) atau negatif (-))</span>
                                    </div>
                                </h6>
                                <div class="rs-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-1 text-start d-flex align-items-center">
                                                @if ($answer['is_right_answer'])
                                                    <span
                                                        class="fas fa-fw fa-check-circle text-gawedata cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @else
                                                    <span
                                                        class="far fa-fw fa-circle text-gray cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @endif
                                            </div>
                                            <div class="col-7 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] ?? '' }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-3">
                                                <div class="input-group">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="subtractAnswerPoints({{ $loop->iteration }});">-</span>
                                                    <input type="number" class="form-control input-text text-center"
                                                        value={{ $answer['points'] }}
                                                        onkeyup="setAnswerPoints({{ $loop->iteration }});"
                                                        id="answer-points-{{ $loop->iteration }}">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="addAnswerPoints({{ $loop->iteration }});">+</span>
                                                </div>
                                            </div>
                                            <div class="col-1 text-start d-flex align-items-center">
                                                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                                    id="answer_delete{{ $loop->iteration }}"
                                                    onclick="deleteAnswer({{ $loop->iteration }});"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment_type_id == 3)
                            <div id="sa-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7 position-relative mt-2" style="padding-right: 0;">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100">
                                        @if ($assessment['questions'][$i - 1]['image_path'])
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image"
                                                onclick="deleteQuestionImage();"></span>
                                        @else
                                            <div class="survey-question-image-delete p-2 position-absolute survey-question-image d-none"
                                                onclick="deleteQuestionImage();">
                                                <span class="fa fa-fw fa-trash fs-4"></span>
                                            </div>
                                            <span
                                                class="fa fa-fw fa-trash fs-4 position-absolute survey-question-image-delete-icon survey-question-image d-none"
                                                onclick="deleteQuestionImage();"></span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start row mt-2" id="sa-question-title">
                                    <div class="col-8">
                                        Jawaban
                                    </div>
                                    <div class="col-4">
                                        Poin <span class="text-gray">(Positif (+) atau negatif (-))</span>
                                    </div>
                                </h6>
                                <div class="sa-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-8 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] ?? '' }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-3">
                                                <div class="input-group">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="subtractAnswerPoints({{ $loop->iteration }});">-</span>
                                                    <input type="number" class="form-control input-text text-center"
                                                        value={{ $answer['points'] }}
                                                        onkeyup="setAnswerPoints({{ $loop->iteration }});"
                                                        id="answer-points-{{ $loop->iteration }}">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="addAnswerPoints({{ $loop->iteration }});">+</span>
                                                </div>
                                            </div>
                                            <div class="col-1 text-start d-flex align-items-center">
                                                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                                    id="answer_delete{{ $loop->iteration }}"
                                                    onclick="deleteAnswer({{ $loop->iteration }});"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment['with_discussion'] && $assessment_type_id != 3)
                            <h6 class="text-start">Pembahasan</h6>
                            <div class="row">
                                <div class="col-12 position-relative">
                                    <textarea type="text" name="discussion" id="input-discussion"
                                        class="form-control input-text"
                                        style="resize: none; height:8rem; text-align: left;">{{ $assessment['questions'][$i - 1]['discussion'] }}</textarea>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="text-start me-auto">
                                <button class="btn btn-gawedata-danger" onclick="deleteQuestion({{ $i }});">
                                    <span class="fas fa-fw fa-trash-alt me-2"></span>Hapus
                                </button>
                            </div>
                            <div class="text-end me-2">
                                <button class="btn btn-gawedata-3" onclick="copyQuestion({{ $i }});" disabled
                                    id="button-duplicate">
                                    <label class="font-lato cursor-pointer">
                                        <span class="fas fa-fw fa-copy me-2"></span>Duplikat
                                    </label>
                                </button>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-gawedata-3">
                                    <label for="photo" class="font-lato cursor-pointer">
                                        <span class="fas fa-fw fa-image me-2"></span>
                                        @if ($assessment['questions'][$i - 1]['image_path'])
                                            <span id="label-gambar">Ganti gambar</span>
                                        @else
                                            <span id="label-gambar">Gambar</span>
                                        @endif
                                    </label>
                                    <input type="file" name="photo" id="photo" class="d-none" accept="image/*"
                                        onchange="loadFile(event)">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <form action="{{ route('assessment.update', $assessment['id']) }}" method="post" class="d-none"
        id="question-form">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <input type="text" name="questions" id="input-questions">
        <input type="text" name="question_index" id="input-question-index">
        <input type="text" name="new_question" id="new-question">
        <input type="text" name="submit_question" id="submit-question">
        <input type="hidden" name="change_tab" id="change-tab">
    </form>
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var questions = @json($assessment['questions']);
        var question_index = @json($i - 1);
        var question_id = questions[question_index].id;
    </script>
    <script>
        $('#survey-setting-button').click(function() {
            console.log(questions)
        });
    </script>
    <script>
        function getQuestionIndex(next_question_id) {
            var the_index = "";
            questions.forEach(function(question, index) {
                if (question['id'] == next_question_id) {
                    the_index = index;
                }
            })
            return the_index;
        }
    </script>
    <script>
        // main question
        function setQuestion() {
            questions[question_index]['question'] = $('#input-question').val();
            checkAllFields();
        }
    </script>
    <script>
        // irt answer
        function addAnswer() {
            questions[question_index]['answer_choices'].push({
                "text": "Jawaban Baru",
                "points": 0,
                "is_right_answer": false
            });
            questions[question_index]['answer_choices'][questions[question_index]['answer_choices'].length - 1]['text'] =
                "";
            if ({{ $assessment_type_id }} == 1) {
                refreshIRTAnswer();
            } else if ({{ $assessment_type_id }} == 2) {
                refreshRSAnswer();
            } else if ({{ $assessment_type_id }} == 3) {
                refreshSAAnswer();
            }
            checkAllFields();
        }

        function deleteAnswer(int) {
            questions[question_index]['answer_choices'].splice(int - 1, 1);
            if (questions[question_index]['answer_choices'].length > 0) {
                if ({{ $assessment_type_id }} == 1) {
                    refreshIRTAnswer();
                } else if ({{ $assessment_type_id }} == 2) {
                    refreshRSAnswer();
                } else if ({{ $assessment_type_id }} == 3) {
                    refreshSAAnswer();
                }
            } else {
                $('#question-answer' + int).remove();
            }
        }

        function refreshIRTAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshirtanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".irt-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshRSAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshrsanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".rs-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshSAAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshsaanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".sa-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function setNewAnswer(index) {
            questions[question_index]['answer_choices'][index - 1]['text'] = $('#answer-' + index).val();
            checkAllFields();
        }
    </script>
    <script>
        var saveClicked = false;

        function saveDraft(index, new_bool) {
            event.preventDefault();
            if (!saveClicked) {
                var fieldEmpty = false;
                if (new_bool) {
                    $('#new-question').val(1);
                }
                $('#input-question-index').val(index);
                if (questions.length > 0) {
                    questions[question_index].answer_choices.forEach(element => {
                        if (element.text == '') {
                            fieldEmpty = true;
                        }
                    });
                    if (questions[question_index].question == '') {
                        fieldEmpty = true;
                    }
                }
                if (fieldEmpty) {
                    questions.splice(question_index, 1);
                    $('#input-questions').val(JSON.stringify(questions));
                    document.getElementById('question-form').submit();
                } else {
                    $('#input-questions').val(JSON.stringify(questions));
                    document.getElementById('question-form').submit();
                }
                saveClicked = true;
            }
        }
    </script>
    <script>
        function deleteQuestion(index) {
            questions.splice(index - 1, 1);
            if (index == 1) {
                saveDraft(index, false);
            } else {
                saveDraft(index - 1, false);
            }
        }
    </script>
    <script>
        checkAllFields();
        var isNull = false;

        function checkAllFields() {
            if (questions[question_index].question == "") {
                isNull = true;
            }
            questions[question_index].answer_choices.forEach(element => {
                if (element.text == '') {
                    isNull = true;
                }
            });
            if (!isNull) {
                $("#button-duplicate").prop("disabled", false);
            } else {
                $("#button-duplicate").prop("disabled", true);
            }
            isNull = 0;
        }

        function copyQuestion(index) {
            var copied_question = questions[index - 1];
            questions.push(copied_question);
            saveDraft(questions.length, false);
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
                    $('.survey-question-image').removeClass('d-none').addClass('d-block');
                    questions[question_index]['image_path'] = @json(config('services.asset.url')) + '/' + JSON.parse(
                        data)['data']['path'];
                    $('#label-gambar').html('Ganti gambar');
                },
            }).fail(function(error) {
                console.log(error);
            });
        };
    </script>
    <script>
        function deleteQuestionImage() {
            $('.survey-question-image-preview').attr('src', null);
            $('.survey-question-image').addClass('d-none').removeClass('d-block');
            questions[question_index]['image_path'] = null
            $('#label-gambar').html('Gambar');
        }
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!-- Latest Sortable -->
    <script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
    <script>
        Sortable.create(simpleList, {
            handle: '.drag-handle',
            animation: 150,
            direction: 'vertical',
            onEnd: function(evt) {
                var element = questions[evt.oldIndex];
                questions.splice(evt.oldIndex, 1);
                questions.splice(evt.newIndex, 0, element);
                questions.forEach(function(value, i) {
                    if (value.id == question_id) {
                        question_index = i;
                        $('#save-draft-button').attr("onclick", "saveDraft(" + (i + 1) + ", false);");
                    }
                });
                reorder_question_link();
            },
        });
    </script>
    <script>
        function reorder_question_link() {
            $(".survey-question-card").each(function(index) {
                $(this).attr("onclick", "saveDraft(" + (index + 1) + ", false);");
            });
        };
    </script>
    <script>
        var answerSelectedOnLoad = true;
        if ({{ $assessment_type_id }} == 1 || {{ $assessment_type_id }} == 2) {
            questions[question_index]['answer_choices'].forEach(element => {
                if (element.is_right_answer) {
                    answerSelectedOnLoad = false;
                }
            });
            if (answerSelectedOnLoad) {
                changeCorrectAnswer(1)
            }
        }

        function changeCorrectAnswer(order) {
            $('.assessment-correct-radio').removeClass('fas').removeClass('fa-check-circle').removeClass('text-gawedata');
            $('.assessment-correct-radio').addClass('far').addClass('fa-circle').addClass('text-gray');
            $('#answer-radio-' + order).removeClass('far').removeClass('fa-circle').removeClass('text-gray');
            $('#answer-radio-' + order).addClass('fas').addClass('fa-check-circle').addClass('text-gawedata');
            questions[question_index]['answer_choices'].forEach(element => {
                element.is_right_answer = false;
            });
            questions[question_index]['answer_choices'][order - 1]['is_right_answer'] = true;
        }
    </script>
    @if ($assessment['with_discussion'] && $assessment['assessment_type_id'] != 3)
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
        function setAnswerPoints(index) {
            questions[question_index]['answer_choices'][index - 1]['points'] = $('#answer-points-' + index).val();
        }
    </script>
    <script>
        function addAnswerPoints(order) {
            $('#answer-points-' + order).val(parseInt($('#answer-points-' + order).val()) + 1);
            setAnswerPoints(order);
        }

        function subtractAnswerPoints(order) {
            $('#answer-points-' + order).val(parseInt($('#answer-points-' + order).val()) - 1);
            setAnswerPoints(order);
        }
    </script>
    <script>
        function changeTab(type) {
            $('#change-tab').val(1);
            saveDraft(1, false);
        }
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- assessment --}}
    <script>
        console.log(@json($assessment));
        if (@json($assessment['assessment_type_id']) == 1) {
            var assessment_type = 'irt';
        } else if (@json($assessment['assessment_type_id']) == 2) {
            var assessment_type = 'rs';
        } else if (@json($assessment['assessment_type_id']) == 3) {
            var assessment_type = 'sa';
        }
        if (@json($assessment['is_simultaneously']) == 1 || @json($assessment['with_ranking'])) {
            var serentak = true;
        } else {
            var serentak = false;
        }

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
                setEndTimeNS(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
            });
            $('#assessment-end-time-non-serentak').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
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
                minDate: moment(),
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
