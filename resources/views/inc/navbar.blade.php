<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container justify-content-center">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-with-text.png') }}" alt="" class="d-inline-block align-text-top">
        </a>
        @auth
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer">
                            Argan Oil
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer">
                            Argan Shampoo
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer">
                            Kleanse
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer">
                            Contact Us
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer">
                            <span class="fa fa-fw fa-user me-2"></span>My Account
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="text-argavell text-decoration-none font-proxima-nova font-weight-bold cursor-pointer"
                            data-bs-toggle="modal" data-bs-target="#cartModal">
                            <span class="fa fa-fw fa-shopping-cart"></span>
                        </a>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
