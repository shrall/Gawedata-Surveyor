<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Boostrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="app" class="font-nexa">
        @include('inc.navbar')

        <main class="py-5">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    @yield('scripts')

    @if (Route::current()->getName() == 'home')
        <!-- Modal -->
        <div class="modal fade font-nexa" id="start-modal" tabindex="-1" aria-labelledby="start-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content px-4 pt-2 pb-5" style="border-radius: 18px !important;">
                    <div class="modal-header border-0">
                        <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                            data-bs-dismiss="modal" aria-label="Close"></span>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('images/start-modal.png') }}" width="135px" height="145px">
                        <h3 class="font-weight-bold">Selamat datang di Gawedata</h3>
                        <p class="my-0 font-lato">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
                            molestie quam aenean eget mi sagittis eleifend iaculis. Quis tortor vitae augue eu, amet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(window).on('load', function() {
                if (!localStorage['start-modal']) {
                    $('#start-modal').modal('show');
                    localStorage["start-modal"] = true;
                }
            });
        </script>
    @endif

</body>

</html>
