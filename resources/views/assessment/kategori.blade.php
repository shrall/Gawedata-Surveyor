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
                                    <h6 class="text-gray">Pembahasan</h6>
                                    <h6 id="discussion"></h6>
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
        @foreach ($assessment['respondent_types'] as $type)
            $('#discussion-{{ $loop->iteration }}').append(htmlDecode("{{ $type['discussion'] }}"))
        @endforeach
    </script>
@endsection
