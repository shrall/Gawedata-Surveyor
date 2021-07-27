<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container justify-content-center">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-with-text.png') }}" alt="" class="d-inline-block align-text-top">
        </a>
        @if (Route::current()->getName() != 'login')
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @if (Route::current()->getName() == 'survey.show')
                    <ul class="navbar-nav position-absolute top-50 start-50 translate-middle">
                        <h4 class="font-lato font-weight-bold mb-0">{{ $survey['title'] }}
                            <span class="far fa-fw fa-comment-dots text-gawedata cursor-pointer ms-2"></span>
                        </h4>
                    </ul>
                @endif
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto align-items-center">
                    @if (Route::current()->getName() == 'home')
                        <li class="nav-item mx-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#create-survey-modal"
                                class="btn btn-gawedata font-lato">
                                Buat Survei
                            </a>
                        </li>
                        @include('inc.modal.survey.create')
                        <li class="nav-item mx-2 ">
                            <a href="#" class="text-gawedata text-decoration-none font-weight-bold cursor-pointer"
                                id="survey-button-grid" onclick="toggleSurveyViewGrid()">
                                <span class="fa fa-fw fa-th-large"></span>
                            </a>
                        </li>
                        <li class="nav-item mx-2 ">
                            <a href="#" class="text-secondary text-decoration-none font-weight-bold cursor-pointer"
                                id="survey-button-list" onclick="toggleSurveyViewList()">
                                <span class="fa fa-fw fa-bars"></span>
                            </a>
                        </li>
                    @elseif (Route::current()->getName() == 'survey.show')
                    <li class="nav-item mx-4">
                        <a href="#"
                            class="btn btn-gawedata-2 font-lato font-weight-bold">
                            <span class="far fa-fw fa-paper-plane"></span>
                            Bagikan Survei
                        </a>
                    </li>
                    @endif
                    <li class="nav-item mx-4 position-relative">
                        <img src="{{ asset('images/logo-with-text.png') }}" id="user-profile" class="rounded-circle"
                            width="50px" height="50px">
                        <div id="profile-menu-box">
                            <div id="profile-menu" class="p-4">
                                <p class="mt-0 mb-2 font-weight-bold">Kuota Responden
                                    <span class="fa fa-fw fa-info-circle text-secondary"></span>
                                </p>
                                <div class="profile-quota-box mb-1">
                                    <div class="profile-quota" style="width: 30%;"></div>
                                </div>
                                <p class="my-0 text-secondary">Tersisa <span class="user-quota">40</span>/150 kuota
                                    responden</p>
                                <div class="my-3">
                                    <a href="#" class="text-gawedata text-decoration-none font-weight-bold">
                                        <span class="fa fa-fw fa-phone-alt me-2"></span>Hubungi Admin Via Whatsapp
                                    </a>
                                </div>
                                <hr>
                                <div class="my-3">
                                    <a href="{{ route('user.editprofile') }}"
                                        class="text-dark text-decoration-none font-weight-bold">
                                        Account
                                    </a>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                        class="text-dark text-decoration-none font-weight-bold">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
