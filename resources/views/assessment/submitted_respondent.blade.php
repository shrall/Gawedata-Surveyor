@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.submitted_respondent')
            </div>
            <div class="col-7 text-start my-4">
                <div class="card card-survey-detail border-0 p-4 font-lato font-weight-bold">
                    <div class="card-body">
                        <div class="single-answer-question row">
                            <div class="col-11 d-flex flex-column">
                                <h5 class="flex align-items-center justify-content-center">
                                    {{ $assessment['respondent_types'][$i - 1]['name'] }}
                                    <span class="badge-pertanyaan-new font-weight-bold px-2 py-1"
                                        style="color: #3f60f5 !important;">
                                        Skor : {{ $assessment['respondent_types'][$i - 1]['min_points'] }} -
                                        {{ $assessment['respondent_types'][$i - 1]['max_points'] }}
                                    </span>
                                </h5>
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
            $('#discussion').append(htmlDecode("{{ $assessment['respondent_types'][$i - 1]['discussion'] }}"))
        </script>
    @endsection
@endif
