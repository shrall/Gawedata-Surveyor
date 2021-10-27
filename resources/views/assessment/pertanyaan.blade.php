@extends('layouts.app')
@php
$user = Http::withHeaders([
    'Authorization' => 'Bearer ' . session('token'),
])
    ->get(config('services.api.url') . '/details')
    ->json()['data'];
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.published')
            </div>
            <div class="col-7 text-start my-4">
                <div class="card card-survey-detail border-0 p-4 font-lato font-weight-bold">
                    <div class="card-body">
                        @foreach ($assessment['questions'] as $question)
                            <div class="single-answer-question row">
                                <div class="col-1 pe-0">
                                    <span
                                        class="badge-pertanyaan text-gawedata font-weight-bold p-2">P{{ $loop->iteration }}</span>
                                </div>
                                <div class="col-11 d-flex flex-column">
                                    <h6>{{ $question['question'] }}</h6>
                                    <a href="{{ $question['image_path'] ?? '#' }}" target="_blank"
                                        class="text-gawedata">{{ $question['image_path'] ?? '' }}</a>
                                    <h6 class="text-gray">Jawaban</h6>
                                    @foreach ($question['answer_choices'] as $answer)
                                        <h6>{{ $answer['text'] }} ({{ $answer['points'] }} Poin)
                                            @if ($answer['is_right_answer'])<span class="text-success font-weight-bold">Benar</span>@endif
                                        </h6>
                                    @endforeach
                                    <h6 class="text-gray">Pembahasan</h6>
                                    <h6 id="discussion-{{ $loop->iteration }}"></h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function htmlDecode(input) {
            var e = document.createElement('div');
            e.innerHTML = input;
            return e.childNodes[0].nodeValue;
        }
        @foreach ($assessment['questions'] as $question)
            $('#discussion-{{ $loop->iteration }}').append(htmlDecode("{{ $question['discussion'] }}"))
        @endforeach
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/3.0.3/main/clipboard-polyfill.js"
        integrity="sha512-0IaxYIj68pTzpOBGd7U3RFiF6sUPKefI5SRsYaZkGiJsM+U1/VuKnzT7dkDUxlIYcZ57gULzEk+PgtMfVAyFTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function copyToClipboard() {
            clipboard.writeText($('#survey-link').val());
        }
    </script>
@endsection
