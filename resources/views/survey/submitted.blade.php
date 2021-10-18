@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar.submitted')
            </div>
            <div class="col-7 text-start my-4">
                <div class="card card-survey-detail border-0 p-4 font-lato font-weight-bold">
                    <div class="card-body">
                        @if ($survey['questions'][$i - 1]['survey_question_type_id'] == 1)
                            <div class="single-answer-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Single Answer</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Jawaban</h6>
                                    @foreach ($survey['questions'][$i - 1]['answer_choices'] as $answer)
                                        <h6>{{ $answer['text'] }}</h6>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 2)
                            <div class="multiple-answer-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Multiple Answer</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Jawaban</h6>
                                    @foreach ($survey['questions'][$i - 1]['answer_choices'] as $answer)
                                        <h6>{{ $answer['text'] }}</h6>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 3)
                            <div class="scale-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Scale Question</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Jawaban</h6>
                                    <h6 class="d-flex">
                                        {{ $survey['questions'][$i - 1]['minimal_scale'] }}-{{ $survey['questions'][$i - 1]['maximal_scale'] }}
                                    </h6>
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 4)
                            <div class="grid-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Grid Question</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Grid</h6>
                                    @foreach ($survey['questions'][$i - 1]['sub_questions'] as $question)
                                        <h6>{{ $question['question'] }}</h6>
                                    @endforeach
                                    <h6 class="text-gray">Jawaban</h6>
                                    @foreach ($survey['questions'][$i - 1]['sub_questions'][0]['answer_choices'] as $answer)
                                        <h6>{{ $answer['text'] }}</h6>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 5)
                            <div class="priority-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Priority Question</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Jawaban</h6>
                                    @foreach ($survey['questions'][$i - 1]['answer_choices'] as $answer)
                                        <h6>{{ $answer['text'] }}</h6>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 6)
                            <div class="open-ended-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Open Ended Question</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 7)
                            <div class="action-video-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Action Question - Lihat Video</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Action</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['youtube_url'] }}">
                                        {{ $survey['questions'][$i - 1]['youtube_url'] }}
                                    </a>
                                </div>
                            </div>
                            @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 8)
                                <div class="action-app-question row">
                                    <div class="col-1 pe-0">
                                        <span
                                            class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                    </div>
                                    <div class="col-11 d-flex flex-column">
                                        <h6 class="text-gray">Action Question - Install Aplikasi</h6>
                                        <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                        <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                            class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                        <h6 class="text-gray">Action</h6>
                                        <a href="{{ $survey['questions'][$i - 1]['android_app_url'] }}">
                                            {{ $survey['questions'][$i - 1]['android_app_url'] }}
                                        </a>
                                        <a href="{{ $survey['questions'][$i - 1]['ios_app_url'] }}">
                                            {{ $survey['questions'][$i - 1]['ios_app_url'] }}
                                        </a>
                                    </div>
                                </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 9)
                            <div class="action-website-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Action Question - Link Website</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                    <h6 class="text-gray">Action</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['website_url'] }}">
                                        {{ $survey['questions'][$i - 1]['website_url'] }}
                                    </a>
                                </div>
                            </div>
                        @elseif ($survey['questions'][$i - 1]['survey_question_type_id'] == 10)
                            <div class="action-photo-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6 class="text-gray">Action Question - Unggah Foto</h6>
                                    <h6>{{ $survey['questions'][$i - 1]['question'] }}</h6>
                                    <a href="{{ $survey['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{$survey['questions'][$i - 1]['image_path'] ?? ''}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
