<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container justify-content-center">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-with-text.png') }}" width="125px" alt=""
                class="d-inline-block align-text-top">
        </a>
        @if (Route::current()->getName() != 'login')
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @if (Route::current()->getName() == 'survey.hasil' || Route::current()->getName() == 'survey.analisa' || Route::current()->getName() == 'survey.detail' || Route::current()->getName() == 'survey.show' || Route::current()->getName() == 'survey.submitted')
                    <ul class="navbar-nav position-absolute top-50 start-50 translate-middle" style="z-index: 100;">
                        <h4 class="font-lato font-weight-bold mb-0">{{ $survey['title'] }}
                            <img src="{{ asset('images/survey-menu-button.svg') }}" width="21px"
                                class="far fa-fw fa-comment-dots text-gawedata cursor-pointer ms-2"
                                id="survey-menu-button">
                            <div class="fs-6" id="survey-menu-box">
                                @if (Route::current()->getName() == 'survey.hasil' || Route::current()->getName() == 'survey.analisa' || Route::current()->getName() == 'survey.detail')
                                    <div id="survey-menu" class="p-4">
                                        <div>
                                            <span class="fa fa-fw fa-circle text-green me-2"></span>
                                            <span class="text-green">Published</span>
                                        </div>
                                        <hr>
                                        <div class="mt-3">
                                            <div class="text-red-disabled text-decoration-none font-weight-bold"
                                                id="survey-delete-button">
                                                Hapus Survei
                                            </div>
                                        </div>
                                    </div>
                                @elseif (Route::current()->getName() == 'survey.submitted')
                                    <div id="survey-menu" class="p-4">
                                        <div>
                                            <span class="fa fa-fw fa-circle text-gawedata me-2"></span>
                                            <span class="text-gawedata">Submitted</span>
                                        </div>
                                        <hr>
                                        <div class="mt-3">
                                            <div class="text-red-disabled text-decoration-none font-weight-bold"
                                                id="survey-delete-button">
                                                Hapus Survei
                                            </div>
                                        </div>
                                    </div>
                                @elseif (Route::current()->getName() == 'survey.show')
                                    <div id="survey-menu" class="p-4">
                                        <div>
                                            <span class="fa fa-fw fa-circle text-yellow me-2"></span>
                                            <span class="text-gray">Draft</span>
                                        </div>
                                        <hr>
                                        <div class="my-3">
                                            <a href="#" class="text-dark text-decoration-none font-weight-bold"
                                                id="survey-setting-button">
                                                Pengaturan Survei
                                            </a>
                                        </div>
                                        <div class="mt-3">
                                            <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('survey-delete-form').submit();"
                                                class="text-red text-decoration-none font-weight-bold"
                                                id="survey-delete-button">
                                                Hapus Survei
                                            </a>
                                            <form id="survey-delete-form"
                                                action="{{ route('survey.destroy', $survey['id']) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
                        <li class="nav-item mx-2">
                            <a href="#" class="btn btn-gawedata-2 font-lato" onclick="saveDraft({{$i}});">
                                Simpan (Draft)
                            </a>
                        </li>
                        @include('inc.modal.survey.submit')
                        <li class="nav-item mx-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#submit-modal" class="btn btn-gawedata font-lato font-weight-bold">
                                Submit Survei
                            </a>
                        </li>
                    @elseif (Route::current()->getName() == 'survey.hasil' || Route::current()->getName() ==
                        'survey.analisa' || Route::current()->getName() == 'survey.detail')
                        <li class="nav-item mx-4">
                            <a href="#" class="btn btn-gawedata-2 font-lato font-weight-bold">
                                <span class="far fa-fw fa-paper-plane"></span>
                                Bagikan Survei
                            </a>
                        </li>
                    @endif
                    <li class="nav-item mx-4 position-relative">
                        <img src="{{ asset('images/logo.png') }}" id="user-profile" class="rounded-circle"
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
