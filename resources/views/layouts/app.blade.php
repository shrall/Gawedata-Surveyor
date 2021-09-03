<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Boostrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/42820ed233.js" crossorigin="anonymous"></script>

    {{-- Select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.rtl.min.css" />

    {{-- jQuery UI --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @yield('head')
</head>

@if (Route::current()->getName() != 'login')
    @php
        $user = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/details')
            ->json()['data'];
    @endphp
@endif

<body>
    <div id="app" class="font-nexa">
        @include('inc.navbar')
        <main>
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

    @yield('scripts')
    @if (Route::current()->getName() == 'home')
        @include('inc.modal.new_user')
    @endif

    @if (Route::current()->getName() != 'login')
        <script>
            $(window).on('load', function() {
                console.log(@json($user));
                var total_quota = @json($user['respondent_quota'])+@json($user['quota_of_respondent_used']);
                $(".used-quota").html(@json($user['respondent_quota']))
                $(".user-quota").html(total_quota)
                var quota_percentage = @json($user['respondent_quota']) / total_quota * 100
                $(".profile-quota").css('width', quota_percentage)
                console.log(quota_percentage);
                if (quota_percentage > 75) {
                    $(".profile-quota").css('background-color', '#49d479')
                } else if (quota_percentage > 30) {
                    $(".profile-quota").css('background-color', '#ffd54f')
                } else {
                    $(".profile-quota").css('background-color', '#ff525d')
                }
            });
        </script>
    @endif
</body>

</html>
