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
                    <div class="row justify-content-end">
                        <a href="{{ config('services.api.url') . '/downloadAssessment/' . $assessment['id'] . '/' . $user['id'] }}"
                            class="col-3 btn btn-gawedata-3 font-lato font-weight-bold">
                            <span class="fa fa-fw fa-file-download"></span>
                            Download Hasil (.csv)
                        </a>
                    </div>
                    <div class="card-body">
                        @foreach ($assessment['respondent_types'] as $type)
                            <div class="single-answer-question row">
                                <div class="col-11 d-flex flex-column">
                                    <h5 class="flex align-items-center justify-content-center">
                                        {{ $type['name'] }}
                                        <span class="badge-pertanyaan-new font-weight-bold px-2 py-1"
                                            style="color: #3f60f5 !important;">
                                            Skor : {{ $type['min_points'] }} -
                                            {{ $type['max_points'] }}
                                        </span>
                                    </h5>
                                    @if ($assessment['with_discussion'])
                                        <h6 class="text-gray">Pembahasan</h6>
                                        <h6 id="discussion"></h6>
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
            @foreach ($assessment['respondent_types'] as $type)
                $('#discussion-{{ $loop->iteration }}').append(htmlDecode("{{ $type['discussion'] }}"))
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
@endsection
