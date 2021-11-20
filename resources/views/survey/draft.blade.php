@extends('layouts.app')

@php
$question_type_id = $survey['questions'][$i - 1]['survey_question_type_id'] ?? null;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end" style="min-height: 90vh;">
                @include('survey.inc.sidebar.draft')
            </div>
            <div class="col-7 text-center my-4">
                @if ($question_type_id != null)
                    <h4 class="font-lato text-start ms-5">Buat Pertanyaan</h4>
                    <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                        <h6 class="text-start">Pertanyaan</h6>
                        <div class="row">
                            <div class="col-7 position-relative">
                                <span
                                    class="badge-pertanyaan position-absolute start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                    style="color: #3f60f5 !important; top:1.75rem;">P{{ $i }}</span>
                                <textarea type="text" name="question" id="input-question" class="form-control input-text"
                                    style="padding-left:3.5rem !important;resize: none; height:8rem;"
                                    placeholder="Tuliskan Pertanyaan Disini"
                                    onkeyup="setQuestion()">{{ $survey['questions'][$i - 1]['question'] }}</textarea>
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
                                <h6 class="question-type-text-guide text-start text-gray my-2" style="font-size: 0.875rem;">
                                    @if ($question_type_id == 1)
                                        Responden hanya dapat memilih 1 jawaban.
                                    @elseif ($question_type_id == 2)
                                        Responden dapat memilih lebih dari 1 jawaban.
                                    @elseif ($question_type_id == 3)
                                        Responden mengurutkan jawaban berdasarkan peringkat.
                                    @elseif ($question_type_id == 4)
                                        Responden mengurutkan jawaban berdasarkan peringkat.
                                    @elseif ($question_type_id == 5)
                                        Responden mengurutkan jawaban.
                                    @elseif ($question_type_id == 6)
                                        Responden menjawab berupa opini atau penjelasan.
                                    @elseif ($question_type_id == 7)
                                        Responden melakukan sesuatu untuk menjawab.
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div id="grid-question" class="@if ($question_type_id == 4) d-block @else d-none @endif">
                            <div class="row">
                                <div class="col-7 position-relative">
                                    <img src="{{ $survey['questions'][$i - 1]['image_path'] }}"
                                        class="survey-question-image-preview w-100 my-2">
                                    @if ($survey['questions'][$i - 1]['image_path'])
                                        <div class="survey-question-image-delete p-2" onclick="deleteQuestionImage();">
                                            <span class="fa fa-fw fa-trash fs-4"></span>
                                        </div>
                                    @else
                                        <div class="survey-question-image-delete p-2 d-none"
                                            onclick="deleteQuestionImage();">
                                            <span class="fa fa-fw fa-trash fs-4"></span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-5">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-start">Grid Pertanyaan<span class="text-gray ms-2">(Baris)</span>
                                    </h6>
                                    <div class="grid-question-list">
                                        @foreach ($survey['questions'][$i - 1]['sub_questions'] as $question)
                                            <div class="row mb-3" id="grid-question{{ $loop->iteration }}">
                                                <div class="col-10 position-relative">
                                                    <span
                                                        class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                        id="question-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                    <input type="text" name="question{{ $loop->iteration }}"
                                                        id="question{{ $loop->iteration }}"
                                                        class="form-control input-text"
                                                        style="padding-left:3.5rem !important;"
                                                        placeholder="Tuliskan Jawaban Disini"
                                                        value="{{ $question['question'] }}"
                                                        onkeyup="setNewGridQuestion({{ $loop->iteration }});">
                                                </div>
                                                <div class="col-1 text-start d-flex align-items-center ps-0">
                                                    <label for="question_image{{ $loop->iteration }}"
                                                        class="font-lato cursor-pointer"><span
                                                            class="fas fa-fw fa-image text-gray cursor-pointer fs-4"></span></label>
                                                    <input type="file" name="photo_grid"
                                                        id="question_image{{ $loop->iteration }}" class="d-none"
                                                        accept="image/*"
                                                        onchange="gridLoadFile(event,{{ $loop->iteration }})">

                                                </div>
                                                <div class="col-1 text-start d-flex align-items-center ps-0">
                                                    <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-4"
                                                        id="question_delete{{ $loop->iteration }}"
                                                        onclick="deleteGridQuestion({{ $loop->iteration }});"></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-10">
                                            <button class="btn btn-gawedata-2 font-lato w-100 py-2"
                                                onclick="addGridQuestion();">
                                                + Tambah Pertanyaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-start">Jawaban<span class="text-gray ms-2">(Kolom)</span></h6>
                                    <div class="grid-answer-list">
                                        @foreach ($survey['questions'][$i - 1]['sub_questions'] as $key => $question)
                                            @if ($key == 0)
                                                @foreach ($question['answer_choices'] as $answer)
                                                    <div class="row mb-3" id="grid-answer{{ $loop->iteration }}">
                                                        <div class="col-10 position-relative">
                                                            <span
                                                                class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                                id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                            <input type="text" name="answer{{ $loop->iteration }}"
                                                                id="answer-grid{{ $loop->iteration }}"
                                                                class="form-control input-text"
                                                                style="padding-left:3.5rem !important;"
                                                                placeholder="Tuliskan Jawaban Disini"
                                                                value="{{ $answer['text'] }}"
                                                                onkeyup="setNewGridAnswer({{ $loop->iteration }});">
                                                        </div>
                                                        <div class="col-1 text-start d-flex align-items-center ps-0">
                                                            <span
                                                                class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-4"
                                                                id="answer_delete{{ $loop->iteration }}"
                                                                onclick="deleteGridAnswer({{ $loop->iteration }});"></span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-10">
                                            <button class="btn btn-gawedata-2 font-lato w-100 py-2"
                                                onclick="addGridAnswer();">
                                                + Tambah Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2" id="input-lainnya-container">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-start mt-2 mb-0">Aktifkan Jawaban 'Lainnya'</h6>
                                        <span
                                            class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Lorem Ipsum dolor sit amet"></span>
                                        <div class="form-check form-switch ms-auto mb-0">
                                            <input
                                                class="form-check-input form-check-input-switch cursor-pointer input-lainnya"
                                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_other_option_enabled']) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2 d-block">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-start mt-2 mb-0">Pertanyaan Mandatory</h6>
                                        <span
                                            class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Lorem Ipsum dolor sit amet"></span>
                                        <div class="form-check form-switch ms-auto mb-0">
                                            <input
                                                class="form-check-input form-check-input-switch cursor-pointer input-mandatory"
                                                type="checkbox" @if ($survey['questions'][$i - 1]['is_mandatory']) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="single-answer-question" class="@if ($question_type_id == 1 || $question_type_id == 2 || $question_type_id == 5) d-block @else d-none @endif">
                            <div class="row">
                                <div class="col-7">
                                    <img src="{{ $survey['questions'][$i - 1]['image_path'] }}"
                                        class="survey-question-image-preview w-100 my-2" alt="" srcset="">
                                </div>
                                <div class="col-5">
                                </div>
                            </div>
                            <h6 class="text-start @if ($question_type_id == 1 || $question_type_id == 2) d-block @else d-none @endif" id="single-question-title">Jawaban</h6>
                            <div class="row mb-2 @if ($question_type_id == 5) d-block @else d-none @endif" id="priority-question-title">
                                <div class="col-8 row align-items-center pe-0">
                                    <h6 class="text-start col-3 mt-2">Jawaban</h6>
                                    <div class="col-9 d-flex align-items-center justify-content-end">
                                        <div class="form-check p-0">
                                            <input class="form-check-input" type="checkbox" value="" id="input-minimum"
                                                @if ($survey['questions'][$i - 1]['minimum_answer'] == 3) checked @endif>
                                            <label class="form-check-label" for="priority-minimum-checkbox">
                                                Pengguna dapat memilih TOP 3 saja
                                            </label>
                                        </div>
                                        <span class="badge-lainnya ms-2 fas fa-fw fa-info-circle text-gray cursor-pointer"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Lorem Ipsum dolor sit amet"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="single-answer-list">
                                @foreach ($survey['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                    <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                        <div class="col-7 position-relative">
                                            <span
                                                class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                            <input type="text" name="answer{{ $loop->iteration }}"
                                                id="answer-single{{ $loop->iteration }}" class="form-control input-text"
                                                onfocus="focusSkipMenu({{ $loop->iteration }});"
                                                style="padding-left:3.5rem !important;"
                                                placeholder="Tuliskan Jawaban Disini" value="{{ $answer['text'] ?? '' }}"
                                                @if ($question_type_id == 1)
                                            onkeyup="setNewSingleAnswerSkipLogic({{ $loop->iteration }});"
                                        @else
                                            onkeyup="setNewSingleAnswer({{ $loop->iteration }});"
                                @endif>
                                @if ($answer['next_question_id'])
                                    @php
                                        $order = collect($survey['questions'])->where('id', $answer['next_question_id']);
                                    @endphp
                                    <span
                                        class="position-absolute top-50 end-0 translate-middle-y font-weight-bold me-4 px-2 py-1 d-block skip-info-{{ $loop->iteration }}"
                                        id="skip-info-{{ $key }}">Skip ke P{{ $order->keys()[0] + 1 }}
                                        Aktif</span>
                                @else
                                    <span
                                        class="position-absolute top-50 end-0 translate-middle-y font-weight-bold me-4 px-2 py-1 d-none skip-info-{{ $loop->iteration }}"
                                        id="skip-info-{{ $key }}">Skip ke P1 Aktif</span>
                                @endif
                            </div>
                            <div class="col-5 text-start d-flex align-items-center">
                                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                    id="answer_delete{{ $loop->iteration }}"
                                    onclick="deleteSingleAnswer({{ $loop->iteration }});"></span>
                            </div>
                            @if ($answer['next_question_id'])
                                <div id="input-skip-container-{{ $loop->iteration }}"
                                    class="col-12 mt-1 mb-2 d-none input-skip-container">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input input-skip"
                                                onchange="triggerSkipCheckbox({{ $loop->iteration }});" type="checkbox"
                                                value="" id="input-skip-{{ $loop->iteration }}" checked>
                                            <label class="form-check-label" for="input-skip-{{ $loop->iteration }}">
                                                Skip ke pertanyaan tertentu jika memilih jawaban ini
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="input-skip-container-{{ $loop->iteration }}"
                                    class="col-12 mt-1 mb-2 d-none input-skip-container">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input input-skip"
                                                onchange="triggerSkipCheckbox({{ $loop->iteration }});" type="checkbox"
                                                value="" data-id="{{ $loop->iteration }}"
                                                id="input-skip-{{ $loop->iteration }}">
                                            <label class="form-check-label" for="input-skip-{{ $loop->iteration }}">
                                                Skip ke pertanyaan tertentu jika memilih jawaban ini
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="input-skip-dropdown-container col-7 mt-1 d-none"
                                id="input-skip-dropdown-container-{{ $loop->iteration }}">
                                <div class="d-flex align-items-center">
                                    <label class="form-check-label font-weight-bold me-2" style="width: 100px;">
                                        Lompat ke
                                    </label>
                                    <div class="dropdown w-100 position-relative"
                                        id="select-survey-skip-{{ $loop->iteration }}">
                                        @if ($answer['next_question_id'])
                                            @php
                                                $order = collect($survey['questions'])->where('id', $answer['next_question_id']);
                                            @endphp
                                            <span class="form-control input-text d-flex align-items-center"
                                                style="padding-left: 4rem !important;" type="button"
                                                data-bs-toggle="dropdown" id="selected-survey-skip-{{ $key }}">
                                                {{ strlen($order->first()['question']) > 25 ? substr($order->first()['question'], 0, 23) . '...' : $order->first()['question'] }}
                                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                            </span>
                                            <span
                                                class="badge-pertanyaan position-absolute top-50 translate-middle-y font-weight-bold p-2"
                                                id="skip-badge-{{ $key }}"
                                                style="color: #3f60f5 !important; left:1rem;">P{{ $order->keys()[0] + 1 }}</span>
                                        @else
                                            <span class="form-control input-text d-flex align-items-center"
                                                style="padding-left: 4rem !important;" type="button"
                                                data-bs-toggle="dropdown" id="selected-survey-skip-{{ $key }}">
                                                {{ strlen($survey['questions'][0]['question']) > 25 ? substr($survey['questions'][0]['question'], 0, 23) . '...' : $survey['questions'][0]['question'] }}
                                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                            </span>
                                            <span
                                                class="badge-pertanyaan position-absolute top-50 translate-middle-y font-weight-bold p-2"
                                                id="skip-badge-{{ $key }}"
                                                style="color: #3f60f5 !important; left:1rem;">P1</span>
                                        @endif
                                        <ul class="dropdown-menu w-100 px-2">
                                            <div class="overflow-auto px-1" style="min-height:0;max-height: 30vh;">
                                                @foreach ($survey['questions'] as $question)
                                                    <li class="dropdown-item cursor-pointer"
                                                        onclick="changeSkipDropdown({{ $loop->iteration }}, {{ $key }}, {{ $question['id'] }});">
                                                        P{{ $loop->iteration }} |
                                                        {{ strlen($question['question']) > 25 ? substr($question['question'], 0, 23) . '...' : $question['question'] }}
                                                    </li>
                                                @endforeach
                                            </div>
                                        </ul>
                                    </div>
                                </div>
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
            <div class="row mt-4 mb-2 @if ($question_type_id == 1 || $question_type_id == 2 || $question_type_id == 5) d-block @else d-none @endif" id="input-lainnya-container">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Aktifkan Jawaban 'Lainnya'</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-lainnya"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_other_option_enabled']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-2 @if ($question_type_id == 1 || $question_type_id == 2) d-block @else d-none @endif" id="input-none-container">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Aktifkan Jawaban 'None of the Above'</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-none"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_no_answer_enabled']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-2 d-block">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Pertanyaan Mandatory</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-mandatory"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_mandatory']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="scale-question" class="@if ($question_type_id == 3) d-block @else d-none @endif">
            <div class="row">
                <div class="col-7">
                    <img src="{{ $survey['questions'][$i - 1]['image_path'] }}"
                        class="survey-question-image-preview w-100 my-2" alt="" srcset="">
                </div>
                <div class="col-5">
                </div>
            </div>
            <h6 class="text-start">Jawaban</h6>
            <div class="scale-answer">
                <div class="row">
                    <div class="col-4 d-flex align-items-center">
                        <input type="number" name="minimal_scale" id="minimal-scale"
                            value="{{ $survey['questions'][$i - 1]['minimal_scale'] }}"
                            class="form-control input-text text-center" onkeyup="setMinimalScale();">
                        <span class="mx-2">sampai</span>
                        <input type="number" name="maximal_scale" id="maximal-scale"
                            value="{{ $survey['questions'][$i - 1]['maximal_scale'] }}"
                            class="form-control input-text text-center" onkeyup="setMaximalScale();">
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-2 d-block">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Pertanyaan Mandatory</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-mandatory"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_mandatory']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="open-ended-question" class="@if ($question_type_id == 6) d-block @else d-none @endif">
            <div class="row">
                <div class="col-7">
                    <img src="{{ $survey['questions'][$i - 1]['image_path'] }}"
                        class="survey-question-image-preview w-100 my-2" alt="" srcset="">
                </div>
                <div class="col-5">
                </div>
            </div>
            <h6 class="text-start">Jawaban</h6>
            <div class="open-ended-answer">
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="open_ended_answer" id="open_ended_answer" class="form-control input-text"
                            placeholder="Responden akan menjawab sendiri" disabled>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-2 d-block">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Pertanyaan Mandatory</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-mandatory"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_mandatory']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="action-question" class="@if ($question_type_id == 7 || $question_type_id == 8 || $question_type_id == 9 || $question_type_id == 10) d-block @else d-none @endif">
            <div class="row">
                <div class="col-7">
                    <img src="{{ $survey['questions'][$i - 1]['image_path'] }}"
                        class="survey-question-image-preview w-100 my-2" alt="" srcset="">
                </div>
                <div class="col-5">
                </div>
            </div>
            <h6 class="text-start">Jawaban</h6>
            <div class="open-ended-answer">
                <div class="row">
                    <div class="col-5">
                        <div class="dropdown" id="select-action-type">
                            <span class="form-control input-text d-flex align-items-center" type="button"
                                data-bs-toggle="dropdown" id="selected-action-type">
                                @if ($question_type_id == 7)
                                    Lihat Video
                                @elseif ($question_type_id == 8)
                                    Install Aplikasi
                                @elseif ($question_type_id == 9)
                                    Kunjungi Website
                                @elseif ($question_type_id == 10)
                                    Unggah Foto
                                @else
                                    Pilih Action
                                @endif
                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                            </span>
                            <ul class="dropdown-menu w-100 px-2">
                                <div class="overflow-auto px-1" style="min-height:0;max-height: 30vh;">
                                    <li class="dropdown-item" data-type=7>Lihat Video</li>
                                    <li class="dropdown-item" data-type=8>Install Aplikasi</li>
                                    <li class="dropdown-item" data-type=9>Kunjungi Website</li>
                                    <li class="dropdown-item" data-type=10>Unggah Foto</li>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-7 @if ($question_type_id == 7) d-block @else d-none @endif" id="input-url-video">
                        <input type="text" name="action_video_answer" id="action_video_answer"
                            class="form-control input-text action_answer" placeholder="Tuliskan URL Video Disini"
                            value="{{ $survey['questions'][$i - 1]['youtube_url'] }}" onkeyup="setVideoURL();">
                    </div>
                    <div
                        class="col-7 input-url-application position-relative @if ($question_type_id == 8) d-block @else d-none @endif
                                                                                                mb-2">
                        <span
                            class="fab fa-fw fa-android position-absolute top-50 start-0 translate-middle-y ms-4 ps-2"></span>
                        <input type="text" name="action_android_answer" id="action_android_answer"
                            class="form-control input-text action_answer"
                            placeholder="Tuliskan URL Aplikasi Android Disini" style="padding-left:3.5rem !important;"
                            value="{{ $survey['questions'][$i - 1]['android_app_url'] }}" onkeyup="setAndroidURL();">
                    </div>
                    <div class="col-5 input-url-application @if ($question_type_id == 8) d-block @else d-none @endif">
                    </div>
                    <div class="col-7 input-url-application position-relative @if ($question_type_id == 8) d-block @else d-none @endif">
                        <span
                            class="fab fa-fw fa-apple position-absolute top-50 start-0 translate-middle-y ms-4 ps-2 fs-5"></span>
                        <input type="text" name="action_ios_answer" id="action_ios_answer"
                            class="form-control input-text action_answer" placeholder="Tuliskan URL Aplikasi iOS Disini"
                            style="padding-left:3.5rem !important;"
                            value="{{ $survey['questions'][$i - 1]['ios_app_url'] }}" onkeyup="setiOSURL();">
                    </div>
                    <div class="col-7 @if ($question_type_id == 9) d-block @else d-none @endif" id="input-url-website">
                        <input type="text" name="action_website_answer" id="action_website_answer"
                            class="form-control input-text action_answer" placeholder="Tuliskan URL Website Disini"
                            value="{{ $survey['questions'][$i - 1]['website_url'] }}" onkeyup="setWebsiteURL();">
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-2 d-block">
                <div class="col-7">
                    <div class="d-flex align-items-center">
                        <h6 class="text-start mt-2 mb-0">Pertanyaan Mandatory</h6>
                        <span class="badge-lainnya fas fa-fw fa-info-circle text-gray ms-2 mt-2 cursor-pointer"
                            data-toggle="tooltip" data-placement="bottom" title="Lorem Ipsum dolor sit amet"></span>
                        <div class="form-check form-switch ms-auto mb-0">
                            <input class="form-check-input form-check-input-switch cursor-pointer input-mandatory"
                                type="checkbox" id="" @if ($survey['questions'][$i - 1]['is_mandatory']) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex align-items-center justify-content-end">
            <div class="text-start me-auto">
                <button class="btn btn-gawedata-danger" onclick="deleteQuestion({{ $i }});">
                    <span class="fas fa-fw fa-trash-alt me-2"></span>Hapus
                </button>
            </div>
            <div class="text-end me-2">
                <button class="btn btn-gawedata-3" onclick="copyQuestion({{ $i }});">
                    <label class="font-lato cursor-pointer">
                        <span class="fas fa-fw fa-copy me-2"></span>Duplikat
                    </label>
                </button>
            </div>
            <div class="text-end">
                <button class="btn btn-gawedata-3">
                    <label for="photo" class="font-lato cursor-pointer"><span
                            class="fas fa-fw fa-image me-2"></span>Gambar</label>
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
    <form action="{{ route('survey.update', $survey['id']) }}" method="post" class="d-none" id="question-form">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <input type="text" name="questions" id="input-questions">
        <input type="text" name="question_index" id="input-question-index">
        <input type="text" name="new_question" id="new-question">
        <input type="text" name="submit_question" id="submit-question">
    </form>
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var questions = @json($survey['questions']);
        var question_index = @json($i - 1);
    </script>
    <script>
        // answer templates
        var new_answer_single = "Jawaban Baru";
        var new_answer_single_skip_logic = {
            "answer": "Jawaban Baru",
            "next_question": ""
        };
        var new_question_grid = {
            "question": "Pertanyaan Baru",
            "answer_choices": []
        }
    </script>
    <script>
        $(window).on("load", function() {
            questions.forEach(function(question, index) {
                if (question.survey_question_type_id == 2 || question.survey_question_type_id == 5) {
                    question.answer_choices.forEach(function(answer, i) {
                        questions[index].answer_choices[i] = answer.text;
                    })
                } else if (question.survey_question_type_id == 4) {
                    question.sub_questions.forEach(function(subs, ind) {
                        subs.answer_choices.forEach(function(answer, i) {
                            questions[index].sub_questions[ind].answer_choices[i] = answer
                                .text;
                        });
                    })
                } else if (question.survey_question_type_id == 1) {
                    question.answer_choices.forEach(function(answer, i) {
                        questions[index].answer_choices[i]['answer'] = answer.text;
                        questions[index].answer_choices[i]['next_question'] = getQuestionIndex(
                            questions[index].answer_choices[i]['next_question_id']);
                    })
                }
            })
        });
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
        function changeQuestionType() {
            $('#single-answer-question').removeClass('d-block').addClass('d-none');
            $('#grid-question').removeClass('d-block').addClass('d-none');
            $('#scale-question').removeClass('d-block').addClass('d-none');
            $('#open-ended-question').removeClass('d-block').addClass('d-none');
            $('#action-question').removeClass('d-block').addClass('d-none');
            $('#input-url-video').removeClass('d-block').addClass('d-none');
            $('.input-url-application').removeClass('d-block').addClass('d-none');
            $('#single-question-title').removeClass('d-block').addClass('d-none');
            $('#priority-question-title').removeClass('d-block').addClass('d-none');
            $('#input-url-website').removeClass('d-block').addClass('d-none');
            $('#input-lainnya-container').removeClass('d-block').addClass('d-none');
            $('#input-none-container').removeClass('d-block').addClass('d-none');
            questions[question_index]['answer_choices'] = null;
            questions[question_index]['sub_questions'] = null;
            questions[question_index]['minimal_scale'] = null;
            questions[question_index]['maximal_scale'] = null;
            questions[question_index]['youtube_url'] = null;
            questions[question_index]['website_url'] = null;
            questions[question_index]['android_app_url'] = null;
            questions[question_index]['ios_app_url'] = null;
            $('#minimal_scale').val('');
            $('#maximal_scale').val('');
            $('#minimal_scale').removeAttr('value');
            $('#maximal_scale').removeAttr('value');
            $('.action_answer').val('');
            $('.action_answer').removeAttr('value');
        }
        $('#select-question-type').find('li').click(function() {
            $('#selected-question-type').html($(this).text() +
                '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            $('#question-type').val($(this).data("type"));
            questions[question_index]['survey_question_type_id'] = $(this).data("type");
            changeQuestionType();
            if ($(this).data("type") == 1) {
                questions[question_index]['answer_choices'] = [new_answer_single_skip_logic];
                questions[question_index]['answer_choices'][0]['answer'] = "";
                refreshSingleAnswerSkipLogicAjax();
                $('.question-type-text-guide').html('Responden hanya dapat memilih 1 jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
                $('#single-question-title').removeClass('d-none').addClass('d-block');
                $('#input-lainnya-container').removeClass('d-none').addClass('d-block');
                $('#input-none-container').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 2) {
                questions[question_index]['answer_choices'] = [new_answer_single];
                questions[question_index]['answer_choices'][0] = "";
                refreshSingleAnswerAjax();
                $('.question-type-text-guide').html('Responden dapat memilih lebih dari 1 jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
                $('#single-question-title').removeClass('d-none').addClass('d-block');
                $('#input-lainnya-container').removeClass('d-none').addClass('d-block');
                $('#input-none-container').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 3) {
                $('.question-type-text-guide').html('Responden mengurutkan jawaban berdasarkan peringkat.')
                $('#scale-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 4) {
                $('#input-lainnya-container').removeClass('d-none').addClass('d-block');
                questions[question_index]['sub_questions'] = [new_question_grid];
                questions[question_index]['sub_questions'][0]['question'] = "";
                questions[question_index]['sub_questions'][0]['answer_choices'] = [new_answer_single];
                questions[question_index]['sub_questions'][0]['answer_choices'][0] = "";
                refreshGridQuestionAjax();
                refreshGridAnswerAjax();
                $('.question-type-text-guide').html('Responden mengurutkan jawaban berdasarkan peringkat.')
                $('#grid-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 5) {
                $('#priority-question-title').removeClass('d-none').addClass('d-block');
                $('#input-lainnya-container').removeClass('d-none').addClass('d-block');
                questions[question_index]['answer_choices'] = [new_answer_single];
                questions[question_index]['answer_choices'][0] = "";
                refreshSingleAnswerAjax();
                $('.question-type-text-guide').html('Responden mengurutkan jawaban.')
                $('#single-answer-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 6) {
                $('.question-type-text-guide').html('Responden menjawab berupa opini atau penjelasan.')
                $('#open-ended-question').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 7) {
                $('.question-type-text-guide').html('Responden melakukan sesuatu untuk menjawab.')
                $('#action-question').removeClass('d-none').addClass('d-block');
            }
        });
    </script>
    <script>
        // main question
        function setQuestion() {
            questions[question_index]['question'] = $('#input-question').val();
        }
    </script>
    <script>
        // single answer
        function addSingleAnswer() {
            if (questions[question_index]['survey_question_type_id'] == 1) {
                questions[question_index]['answer_choices'].push({
                    "answer": "Jawaban Baru",
                    "next_question": ""
                });
                questions[question_index]['answer_choices'][questions[question_index]['answer_choices'].length - 1][
                    'answer'
                ] = ""
                refreshSingleAnswerSkipLogicAjax();
            } else {
                questions[question_index]['answer_choices'].push(new_answer_single);
                questions[question_index]['answer_choices'][questions[question_index]['answer_choices'].length - 1] = ""
                refreshSingleAnswerAjax();
            }
        }

        function deleteSingleAnswer(int) {
            questions[question_index]['answer_choices'].splice(int - 1, 1);
            if (questions[question_index]['answer_choices'].length > 0) {
                if (questions[question_index]['survey_question_type_id'] == 1) {
                    refreshSingleAnswerSkipLogicAjax();
                } else {
                    refreshSingleAnswerAjax();
                }
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
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshSingleAnswerSkipLogicAjax() {
            console.log(questions[question_index]['answer_choices']);
            $.post("{{ config('app.url') }}" + "/survey/refreshsingleanswerskiplogic", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices'],
                    questions: @json($survey['questions'])
                })
                .done(function(data) {
                    $(".single-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e.responseText);
                });
        }

        function setNewSingleAnswer(index) {
            questions[question_index]['answer_choices'][index - 1] = $('#answer-single' + index).val();
        }

        function setNewSingleAnswerSkipLogic(index) {
            questions[question_index]['answer_choices'][index - 1]['answer'] = $('#answer-single' + index).val();
        }
    </script>
    <script>
        function setMinimalScale() {
            questions[question_index]['minimal_scale'] = $('#minimal-scale').val();
        }

        function setMaximalScale() {
            questions[question_index]['maximal_scale'] = $('#maximal-scale').val();
        }
    </script>
    <script>
        // grid question
        function addGridQuestion() {
            if (questions[question_index]['sub_questions'].length == 0) {
                questions[question_index]['sub_questions'].push({
                    "question": "Pertanyaan Baru",
                    "answer_choices": []
                });
            } else {
                if (questions[question_index]['sub_questions'][0]['answer_choices'].length > 0) {
                    questions[question_index]['sub_questions'].push({
                        "question": "Pertanyaan Baru",
                        "answer_choices": questions[question_index]['sub_questions'][0]['answer_choices']
                    });
                } else {
                    questions[question_index]['sub_questions'].push({
                        "question": "Pertanyaan Baru",
                        "answer_choices": []
                    });
                }
            }
            questions[question_index]['sub_questions'][questions[question_index]['sub_questions'].length - 1]['question'] =
                ""
            refreshGridQuestionAjax();
        }

        function addGridAnswer() {
            questions[question_index]['sub_questions'].forEach((element, index) => {
                if (index < 1) {
                    element['answer_choices'].push(new_answer_single);
                    questions[question_index]['sub_questions'][index]['answer_choices'][questions[question_index][
                            'sub_questions'
                        ][index]['answer_choices'].length - 1] =
                        ""
                }
            });
            refreshGridAnswerAjax();
        }

        function deleteGridQuestion(int) {
            questions[question_index]['sub_questions'].splice(int - 1, 1);
            if (questions[question_index]['sub_questions'].length > 0) {
                refreshGridQuestionAjax();
            } else {
                $('#grid-question' + int).remove();
            }
        }

        function deleteGridAnswer(int) {
            questions[question_index]['sub_questions'].forEach(element => {
                element['answer_choices'].splice(int - 1, 1);
            });
            if (questions[question_index]['sub_questions'][0]['answer_choices'].length > 0) {
                refreshGridAnswerAjax();
            } else {
                $('#grid-answer' + int).remove();
            }
        }

        function refreshGridQuestionAjax() {
            $.post("{{ config('app.url') }}" + "/survey/refreshgridquestion", {
                    _token: CSRF_TOKEN,
                    questions: questions[question_index]['sub_questions']
                })
                .done(function(data) {
                    $(".grid-question-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshGridAnswerAjax() {
            $.post("{{ config('app.url') }}" + "/survey/refreshgridanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['sub_questions'][0]['answer_choices']
                })
                .done(function(data) {
                    $(".grid-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function setNewGridQuestion(index) {
            questions[question_index]['sub_questions'][index - 1]['question'] = $('#question' + index).val();
        }

        function setNewGridAnswer(index) {
            questions[question_index]['sub_questions'].forEach(element => {
                element['answer_choices'][index - 1] = $('#answer-grid' + index).val();
            });
        }
    </script>
    <script>
        //action question
        $('#select-action-type').find('li').click(function() {
            $('#selected-action-type').html($(this).text() +
                '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            $('#question-type').val($(this).data("type"));
            questions[question_index]['survey_question_type_id'] = $(this).data("type");
            changeQuestionType();
            $('#action-question').removeClass('d-none').addClass('d-block');
            if ($(this).data("type") == 7) {
                $('#input-url-video').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 8) {
                $('.input-url-application').removeClass('d-none').addClass('d-block');
            } else if ($(this).data("type") == 9) {
                $('#input-url-website').removeClass('d-none').addClass('d-block');
            }
        });

        function setVideoURL() {
            questions[question_index]['youtube_url'] = $('#action_video_answer').val();
        }

        function setAndroidURL() {
            questions[question_index]['android_app_url'] = $('#action_android_answer').val();
        }

        function setiOSURL() {
            questions[question_index]['ios_app_url'] = $('#action_ios_answer').val();
        }

        function setWebsiteURL() {
            questions[question_index]['website_url'] = $('#action_website_answer').val();
        }
    </script>
    <script>
        function saveDraft(index, new_bool) {
            event.preventDefault();
            if (new_bool) {
                $('#new-question').val(1);
            }
            $('#input-questions').val(JSON.stringify(questions));
            $('#input-question-index').val(index);
            console.log(questions);
            document.getElementById('question-form').submit();
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
                    $('.survey-question-image-delete').removeClass('d-none').addClass('d-block');
                    questions[question_index]['image_path'] = @json(config('services.asset.url')) + '/' + JSON.parse(
                        data)['data']['path']
                },
            }).fail(function(error) {
                console.log(error);
            });
        };
    </script>
    <script>
        function deleteQuestionImage() {
            $('.survey-question-image-preview').attr('src', null);
            $('.survey-question-image-delete').addClass('d-none').removeClass('d-block');
            questions[question_index]['image_path'] = null
        }
    </script>
    <script>
        var gridLoadFile = function(event) {
            var formData = new FormData();
            formData.append('image', $('#question_image' + index)[0].files[0]);
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
                    questions[question_index]['sub_questions'][index - 1]['image_path'] =
                        @json(config('services.asset.url')) + '/' + JSON.parse(data)['data']['path']
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
    <script>
        $(".input-lainnya").on('change', function() {
            if ($(this).is(':checked')) {
                questions[question_index]['is_other_option_enabled'] = true;
            } else {
                questions[question_index]['is_other_option_enabled'] = false;
            }
        });
    </script>
    <script>
        $(".input-none").on('change', function() {
            if ($(this).is(':checked')) {
                questions[question_index]['is_no_answer_enabled'] = true;
            } else {
                questions[question_index]['is_no_answer_enabled'] = false;
            }
        });
    </script>
    <script>
        $(".input-mandatory").on('change', function() {
            if ($(this).is(':checked')) {
                questions[question_index]['is_mandatory'] = true;
            } else {
                questions[question_index]['is_mandatory'] = false;
            }
        });
    </script>
    <script>
        $(".input-minimum").on('change', function() {
            if ($(this).is(':checked')) {
                console.log(3);
                questions[question_index]['minimum_answer'] = 3;
            } else {
                questions[question_index]['minimum_answer'] = 0;
            }
        });
    </script>
    {{-- update survey --}}
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
                dropdownParent: $('#update-survey-modal'),
                placeholder: 'Domisili (Provinsi)'
            });
            $('#survey-city').select2({
                dropdownParent: $('#update-survey-modal'),
                placeholder: 'Domisili (Kota)',
            });
            $('#survey-education').select2({
                dropdownParent: $('#update-survey-modal'),
                placeholder: 'Latar Belakang Pendidikan'
            });
            $('#survey-profession').select2({
                dropdownParent: $('#update-survey-modal'),
                placeholder: 'Profesi'
            });
            $('#survey-expense').select2({
                dropdownParent: $('#update-survey-modal'),
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
                $('#survey-profession').html('<option value="all" selected>Semua Pengeluaran</option>')
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
    <script>
        var the_cities = @json($survey['city_criteria']);
        var selected_cities = [];
        $("#survey-city option").each(function() {
            if ($(this).val() != 'all') {
                selected_cities.push($(this).val());
            } else {
                the_cities.forEach(element => {
                    selected_cities.push(element.city_id)
                });
            }
        });
        $("#survey-city-all").val(selected_cities);
        var the_educations = @json($survey['education_criteria']);
        var selected_educations = [];
        $("#survey-education option").each(function() {
            if ($(this).val() != 'all') {
                selected_educations.push($(this).val());
            } else {
                the_educations.forEach(element => {
                    selected_educations.push(element.education_id)
                });
            }
        });
        $("#survey-education-all").val(selected_educations);
        var the_professions = @json($survey['profession_criteria']);
        var selected_professions = [];
        $("#survey-profession option").each(function() {
            if ($(this).val() != 'all') {
                selected_professions.push($(this).val());
            } else {
                the_professions.forEach(element => {
                    selected_professions.push(element.profession_id)
                });
            }
        });
        $("#survey-profession-all").val(selected_professions);
        var the_expenses = @json($survey['household_expense_criteria']);
        var selected_expenses = [];
        $("#survey-expense option").each(function() {
            if ($(this).val() != 'all') {
                selected_expenses.push($(this).val());
            } else {
                the_expenses.forEach(element => {
                    selected_expenses.push(element.household_expense_id)
                });
            }
        });
        $("#survey-expense-all").val(selected_expenses);
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
                $('#save-draft-button').attr("onclick", "saveDraft(" + (evt.newIndex + 1) + ", false);");
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
    {{-- skip logic --}}
    <script>
        function focusSkipMenu(id) {
            $('.input-skip-container').addClass('d-none').removeClass('d-block');
            $('.input-skip-dropdown-container').addClass('d-none').removeClass('d-block');
            $('#input-skip-container-' + id).addClass('d-block').removeClass('d-none');
            if ($('#input-skip-' + id).is(':checked')) {
                $('#input-skip-dropdown-container-' + id).addClass('d-block').removeClass('d-none');
            }
        }
    </script>
    <script>
        function triggerSkipCheckbox(data_id) {
            if ($('#input-skip-' + data_id).is(':checked')) {
                $('#input-skip-dropdown-container-' + data_id).addClass('d-block').removeClass('d-none');
                $('.skip-info-' + data_id).addClass('d-block').removeClass('d-none');
                questions[question_index]['answer_choices'][data_id - 1]['next_question'] =
                    questions[0]['id'];
            } else {
                $('#input-skip-dropdown-container-' + data_id).addClass('d-none').removeClass('d-block');
                $('.skip-info-' + data_id).addClass('d-none').removeClass('d-block');
                questions[question_index]['answer_choices'][data_id - 1]['next_question'] = "";
                $('#selected-survey-skip-' + (data_id + 1)).html(questions[0]['question'] +
                    '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
                $('#skip-badge-' + (data_id - 1)).html('P1');
                $('#skip-info-' + (data_id - 1)).html('Skip ke P1 aktif');
            }
        };
    </script>
    <script>
        function changeSkipDropdown(order, key, id) {
            $('#selected-survey-skip-' + key).html(questions[order - 1]['question'] +
                '<span class="fa fa-fw fa-chevron-down ms-auto"></span>');
            $('#skip-badge-' + key).html('P' + order);
            $('#skip-info-' + key).html('Skip ke P' + order + ' aktif');
            $('#skip-info-' + key).addClass('d-block').removeClass('d-none');
            questions[question_index]['answer_choices'][key]['next_question'] = order - 1;
        };
    </script>
    @if ($survey['daily_date'])
        {{-- date range picker --}}
        {{-- https://www.daterangepicker.com/ --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script>
            //update daily survey
            $(function() {
                $('input[name="daily_datepicker"]').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD',
                    },
                    singleDatePicker: true,
                    startDate: "{{ $survey['daily_date'] }}",
                }, function(start, end, label) {
                    $('#input-daily-date').val(start.format('YYYY-MM-DD'));
                });
                $('input[name="daily_timepicker"]').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: true,
                    timePickerIncrement: 1,
                    locale: {
                        format: 'HH:mm'
                    },
                    startDate: "{{ $survey['start_time'] }}",
                    endDate: "{{ $survey['end_time'] }}",
                }, function(start, end, label) {
                    $('#input-daily-start').val(start.format('HH:mm'));
                    $('#input-daily-end').val(end.format('HH:mm'));
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
    @endif
@endsection
