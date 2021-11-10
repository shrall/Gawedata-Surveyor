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
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.published')
            </div>
            <div class="col-7 text-center my-4">
                @if ($assessment['respondent_count'] != 0)
                    <div class="row">
                        <div class="row">
                            <div class="col-12">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                    <div id="survey-view-list">
                        <table class="table table-borderless table-hover text-start">
                            <tbody class="text-gray" id="survey-view-list-box">
                                <tr class="survey-row cursor-pointer">
                                    <td class="py-4 text-dark align-middle" width="10px">1</td>
                                    <th class="py-4 text-dark flex align-items-center justify-content-start" scope="row">
                                        <img src="{{ asset('images/logo.png') }}" class="rounded-circle me-2" width="30px"
                                            height="30px">
                                        {{-- <img src="{{ config('services.api.url') .'/'. $respondent['profile_picture_path'] }}"
                                                id="user-profile" class="rounded-circle" width="30px" height="30px"> --}}
                                        Andi
                                    </th>
                                    <td class="py-4 text-dark text-end align-middle">Skor: 123</td>
                                </tr>
                                <tr class="survey-row cursor-pointer border-top">
                                    <td class="py-4 text-dark align-middle" width="10px">2</td>
                                    <th class="py-4 text-dark flex align-items-center justify-content-start" scope="row">
                                        <img src="{{ asset('images/logo.png') }}" class="rounded-circle me-2" width="30px"
                                            height="30px">
                                        {{-- <img src="{{ config('services.api.url') .'/'. $respondent['profile_picture_path'] }}"
                                                id="user-profile" class="rounded-circle" width="30px" height="30px"> --}}
                                        Budi
                                    </th>
                                    <td class="py-4 text-dark text-end align-middle">Skor: 111</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%">
                        <div class="span fa fa-fw fa-list-ul text-gray mb-4" style="font-size: 12rem"></div>
                        <h3 class="text-gray">Ranking akan muncul setelah tes selesai.</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('scripts')
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
                var minutes = Math.floor((interval % (1000 * 60 * 60)) / 60);
                var seconds = Math.floor((interval % (1000 * 60))) - (parseInt(minutes) * 60);
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
