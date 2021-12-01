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
                    <div class="d-flex ms-auto">
                        <a href="{{ config('services.api.url') . '/downloadAssessment/' . $assessment['id'] . '/' . $user['id'] }}"
                            class="btn btn-gawedata-3 font-lato font-weight-bold w-100">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
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
                                    @if ($assessment['with_discussion'])
                                        <h6 class="text-gray">Pembahasan</h6>
                                        <h6 id="discussion-{{ $loop->iteration }}"></h6>
                                    @endif
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
    @if ($assessment['with_discussion'])
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
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/3.0.3/main/clipboard-polyfill.js"
        integrity="sha512-0IaxYIj68pTzpOBGd7U3RFiF6sUPKefI5SRsYaZkGiJsM+U1/VuKnzT7dkDUxlIYcZ57gULzEk+PgtMfVAyFTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function copyToClipboard() {
            clipboard.writeText($('#survey-link').val());
        }
    </script>
    <script>
        var start = new Date().getUTCDate();
        var end = start + @json($assessment['duration'] * 60);
        var distance = end - start;

        function startAssessment(id) {
            $('#the-start-button').html('<span class="fa fa-fw fa-spin fa-circle-notch"></span>');
            $.ajax({
                    url: '{{ config('services.api.url') }}' + "/startStopAssessment/" + id + "?action=STARTED",
                    type: 'PATCH',
                    headers: {
                        "Authorization": "Bearer {{ session('token') }}",
                    },
                    success: function(res) {
                        console.log(res);
                        $('#start-button').removeClass('d-flex').addClass('d-none');
                        $('#stop-button').removeClass('d-none').addClass('d-flex');
                        startCountdown(distance);
                    }
                })
                .done(function(data) {
                    console.log(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function stopAssessment(id) {
            $('#the-stop-button').html('<span class="fa fa-fw fa-spin fa-circle-notch"></span>');
            $.ajax({
                    url: '{{ config('services.api.url') }}' + "/startStopAssessment/" + id + "?action=STOPPED",
                    type: 'PATCH',
                    headers: {
                        "Authorization": "Bearer {{ session('token') }}",
                    },
                    success: function(res) {
                        console.log(res);
                        $('#stop-button').removeClass('d-flex').addClass('d-none');
                        $('#done-button').removeClass('d-none').addClass('d-flex');
                    }
                })
                .done(function(data) {
                    console.log(data);
                })
                .fail(function(e) {
                    console.log(e);
                });
        }
    </script>
    <script>
        var negativeTrigger = false;

        function startCountdown(intervals) {
            var interval = intervals;
            setInterval(function() {
                if (interval < 0 || negativeTrigger) {
                    negativeTrigger = true;
                    interval = Math.abs(interval);
                }
                var hours = Math.floor((interval % (1000 * 60 * 60 * 24)) / 60 / 60);
                var minutes = Math.floor((interval % (1000 * 60 * 60)) / 60) - (parseInt(hours) * 60);
                var seconds = Math.floor((interval % (1000 * 60))) - (Math.floor((interval % (1000 * 60 * 60)) /
                    60) * 60);
                if (hours < 10 && hours > 0) {
                    hours = "0" + hours
                }
                if (minutes < 10 && minutes > 0) {
                    minutes = "0" + minutes
                }
                if (seconds < 10 && seconds > 0) {
                    seconds = "0" + seconds
                }
                if (!negativeTrigger) {
                    $('.assessment-countdown').html(hours + ":" + minutes + ":" + seconds);
                    interval--;
                }else{
                    $('.assessment-countdown').html("-"+hours + ":" + minutes + ":" + seconds);
                    interval++;
                }
            }, 1000);
        }
    </script>
    @if ($assessment['status_id'] == 9)
        <script>
            var startnew = @json(strtotime(Carbon\Carbon::now()->tz('utc')));
            var endnew = @json(strtotime($assessment['end_time']));
            var distancenew = endnew - startnew;
            console.log(startnew);
            console.log(endnew);
            console.log(distancenew);
            $(window).on('load', function() {
                startCountdown(distancenew);
            });
        </script>
    @endif
@endsection
