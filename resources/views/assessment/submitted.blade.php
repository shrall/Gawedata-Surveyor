@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.submitted')
            </div>
            <div class="col-7 text-start my-4">
                <div class="card card-survey-detail border-0 p-4 font-lato font-weight-bold">
                    <div class="card-body">
                        <div class="single-answer-question row">
                            <div class="col-1 pe-0">
                                <span class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $i }}</span>
                            </div>
                            <div class="col-11 d-flex flex-column">
                                <h6>{{ $assessment['questions'][$i - 1]['question'] }}</h6>
                                <a href="{{ $assessment['questions'][$i - 1]['image_path'] ?? '#' }}" target="_blank"
                                    class="text-gawedata">{{ $assessment['questions'][$i - 1]['image_path'] ?? '' }}</a>
                                <h6 class="text-gray">Jawaban</h6>
                                @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $answer)
                                    <h6>{{ $answer['text'] }} ({{ $answer['points'] }} Poin) @if ($answer['is_right_answer'])<span class="text-success font-weight-bold">Benar</span>@endif
                                    </h6>
                                @endforeach
                                @if ($assessment['with_discussion'])
                                    <h6 class="text-gray">Pembahasan</h6>
                                    <h6 id="discussion"></h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($assessment['with_discussion'])
    @section('scripts')
        <script>
            function htmlDecode(input) {
                var e = document.createElement('div');
                e.innerHTML = input;
                return e.childNodes[0].nodeValue;
            }
            $('#discussion').append(htmlDecode("{{ $assessment['questions'][$i - 1]['discussion'] }}"))
        </script>
    @endsection
@endif
