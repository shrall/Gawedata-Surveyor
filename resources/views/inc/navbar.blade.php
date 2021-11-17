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
                        <h4 class="font-lato font-weight-bold mb-0">
                            {{ strlen($survey['title']) > 25 ? substr($survey['title'], 0, 23) . '...' : $survey['title'] }}
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
                                                data-bs-toggle="modal" @if (isset($assessment) && $assessment['daily_date'])
                                                data-bs-target="#update-survey-modal-daily"
                                            @else
                                                data-bs-target="#update-survey-modal"
                                @endif
                                id="survey-setting-button">
                                Pengaturan Survei
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('survey-delete-form').submit();"
                                    class="text-red text-decoration-none font-weight-bold" id="survey-delete-button">
                                    Hapus Survei
                                </a>
                                @if(isset($assessment))
                                    <form id="survey-delete-form"
                                        action="{{ route('survey.destroy', $assessment['id']) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                    </form>
                                @endif
                            </div>
            </div>
        @endif
    </div>
    </h4>
    </ul>
    @endif
    @if (Route::current()->getName() == 'assessment.hasil' || Route::current()->getName() == 'assessment.ranking' || Route::current()->getName() == 'assessment.kategori' || Route::current()->getName() == 'assessment.pertanyaan' || Route::current()->getName() == 'assessment.analisa' || Route::current()->getName() == 'assessment.detail' || Route::current()->getName() == 'assessment.show' || Route::current()->getName() == 'assessment.showrespondent' || Route::current()->getName() == 'assessment.submitted')
        <ul class="navbar-nav position-absolute top-50 start-50 translate-middle" style="z-index: 100;">
            <h4 class="font-lato font-weight-bold d-flex align-items-center mb-0">
                {{ strlen($assessment['title']) > 25 ? substr($assessment['title'], 0, 23) . '...' : $assessment['title'] }}
                @if ($assessment['assessment_type_id'] == 1)
                    <span class="px-2 py-1 assessment-status-irt font-nexa font-weight-regular fs-6 ms-2">IRT</span>
                @elseif ($assessment['assessment_type_id'] == 2)
                    <span class="px-2 py-1 assessment-status-rs font-nexa font-weight-regular fs-6 ms-2">Regular
                        Scoring</span>
                @elseif ($assessment['assessment_type_id'] == 3)
                    <span
                        class="px-2 py-1 assessment-status-sa font-nexa font-weight-regular fs-6 ms-2">Self-Assessment</span>
                @endif
                <img src="{{ asset('images/survey-menu-button.svg') }}" width="21px"
                    class="far fa-fw fa-comment-dots text-gawedata cursor-pointer ms-2" id="survey-menu-button">
                <div class="fs-6" id="survey-menu-box">
                    @if (Route::current()->getName() == 'assessment.hasil' || Route::current()->getName() == 'assessment.analisa' || Route::current()->getName() == 'assessment.detail' || Route::current()->getName() == 'assessment.ranking' || Route::current()->getName() == 'assessment.kategori' || Route::current()->getName() == 'assessment.pertanyaan')
                        <div id="survey-menu" class="p-4">
                            <div>
                                @if ($assessment['status_id'] == 6)
                                    <span class="fa fa-fw fa-circle text-green me-2"></span>
                                    <span class="text-green">Published</span>
                                @elseif ($assessment['status_id'] == 7)
                                    <span class="fa fa-fw fa-circle text-finished me-2"></span>
                                    <span class="text-finished">Finished</span>
                                @elseif ($assessment['status_id'] == 8)
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>
                                    <span class="text-red">Stopped</span>
                                @endif
                            </div>
                            <hr>
                            <div class="mt-3">
                                <div class="text-red-disabled text-decoration-none font-weight-bold"
                                    id="survey-delete-button">
                                    Hapus Survei
                                </div>
                            </div>
                        </div>
                    @elseif (Route::current()->getName() == 'assessment.submitted')
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
                    @elseif (Route::current()->getName() == 'assessment.show' || Route::current()->getName() ==
                        'assessment.showrespondent')
                        <div id="survey-menu" class="p-4">
                            <div>
                                <span class="fa fa-fw fa-circle text-yellow me-2"></span>
                                <span class="text-gray">Draft</span>
                            </div>
                            <hr>
                            <div class="my-3">
                                <a href="#" class="text-dark text-decoration-none font-weight-bold"
                                    data-bs-toggle="modal" data-bs-target="#update-assessment-modal"
                                    id="survey-setting-button">
                                    Pengaturan Survei
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('assessment-delete-form').submit();"
                                    class="text-red text-decoration-none font-weight-bold" id="survey-delete-button">
                                    Hapus Survei
                                </a>
                                <form id="assessment-delete-form"
                                    action="{{ route('assessment.destroy', $assessment['id']) }}" method="POST"
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
                <a href="#" data-bs-toggle="modal" data-bs-target="#create-survey-modal" id="create-survey-general"
                    class="btn btn-gawedata font-lato d-block">
                    Buat Survei
                </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#create-survey-modal-daily" id="create-survey-daily"
                    class="btn btn-gawedata font-lato d-none">
                    Buat Survei
                </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#create-assessment-modal" id="create-assessment"
                    class="btn btn-gawedata font-lato d-none">
                    Buat Assessment
                </a>
            </li>
            @include('inc.modal.survey.create')
            @include('inc.modal.survey.create_daily')
            @include('inc.modal.assessment.create')
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
                <a href="#" class="btn btn-gawedata-2 font-lato" id="save-draft-button"
                    onclick="saveDraft({{ $i }}, false);">
                    Simpan (Draft)
                </a>
            </li>
            @if (isset($assessment) && $assessment['daily_date'])
                @include('inc.modal.survey.update_daily')
            @else
                @include('inc.modal.survey.update')
            @endif
            @include('inc.modal.survey.submit')
            <li class="nav-item mx-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#submit-modal"
                    class="btn btn-gawedata font-lato font-weight-bold">
                    Submit Survei
                </a>
            </li>
        @elseif (Route::current()->getName() == 'assessment.show' || Route::current()->getName() ==
            'assessment.showrespondent')
            <li class="nav-item mx-2">
                <a href="#" class="btn btn-gawedata-2 font-lato" id="save-draft-button"
                    onclick="saveDraft({{ $i }}, false);">
                    Simpan (Draft)
                </a>
            </li>
            {{-- @include('inc.modal.survey.update') --}}
            @include('inc.modal.assessment.submit')
            <li class="nav-item mx-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#submit-modal"
                    class="btn btn-gawedata font-lato font-weight-bold">
                    Submit
                </a>
            </li>
        @elseif (Route::current()->getName() == 'survey.hasil' || Route::current()->getName() ==
            'survey.analisa' || Route::current()->getName() == 'survey.detail')
            @include('inc.modal.survey.share')
            <li class="nav-item mx-4">
                <a href="#" class="btn btn-gawedata-2 font-lato font-weight-bold" data-bs-toggle="modal"
                    data-bs-target="#share-modal">
                    <span class="far fa-fw fa-paper-plane"></span>
                    Bagikan Survei
                </a>
            </li>
        @elseif (Route::current()->getName() == 'assessment.hasil' || Route::current()->getName() ==
            'assessment.analisa' || Route::current()->getName() == 'assessment.detail' || Route::current()->getName() ==
            'assessment.kategori' || Route::current()->getName() == 'assessment.pertanyaan' ||
            Route::current()->getName() ==
            'assessment.ranking')
            @if ($assessment['assessment_type_id'] == 3)
                @include('inc.modal.assessment.share')
                <li class="nav-item mx-4">
                    <a href="#" class="btn btn-gawedata-2 font-lato font-weight-bold" data-bs-toggle="modal"
                        data-bs-target="#share-modal">
                        <span class="far fa-fw fa-paper-plane"></span>
                        Bagikan Tes
                    </a>
                </li>
            @endif
            @if ($assessment['assessment_type_id'] != 3 && $assessment['is_simultaneously'] == 0)
                @include('inc.modal.assessment.share')
                <li class="nav-item mx-4">
                    <a href="#" class="btn btn-gawedata-2 font-lato font-weight-bold" data-bs-toggle="modal"
                        data-bs-target="#share-modal">
                        <span class="far fa-fw fa-paper-plane"></span>
                        Bagikan Tes
                    </a>
                </li>
            @endif
            @if ($assessment['assessment_type_id'] != 3 && $assessment['is_simultaneously'] == 1)
                @php
                    $time = Carbon\Carbon::now()->tz('utc');
                    $duration = $assessment['duration'];
                    $hour = 0;
                    $minute = 0;
                    while ($duration >= 60) {
                        $hour++;
                        $duration -= 60;
                    }
                    if ($duration < 60) {
                        $minute = $duration;
                    }
                    if ($hour < 10) {
                        $hour = '0' . $hour;
                    }
                    if ($minute < 10) {
                        $minute = '0' . $minute;
                    }
                @endphp
                @if ($assessment['status_id'] == 8)
                    <li class="nav-item d-flex align-items-center mx-4">
                        <h6 class="mx-2 my-0 text-gray">Tes Selesai</h6>
                        <h5 class="mx-2 my-0 text-gray">{{ $hour }}:{{ $minute }}:00</h5>
                    </li>
                @endif
                @if ($assessment['status_id'] == 6)
                    <li class="nav-item d-flex align-items-center mx-4" id="start-button">
                        <h6 class="mx-2 my-0 text-gray">Waktu</h6>
                        <h5 class="mx-2 my-0 assessment-countdown">{{ $hour }}:{{ $minute }}:00</h5>
                        <a onclick="startAssessment({{ $assessment['id'] }});" id="the-start-button"
                            class="mx-2 btn btn-gawedata font-lato font-weight-bold">
                            <span class="fas fa-fw fa-play"></span>
                            Mulai Tes
                        </a>
                    </li>
                    <li class="nav-item align-items-center mx-4 d-none" id="stop-button">
                        <h6 class="mx-2 my-0 text-gray">Waktu</h6>
                        <h5 class="mx-2 my-0 text-gawedata assessment-countdown">
                            {{ $hour }}:{{ $minute }}:00</h5>
                        <a onclick="stopAssessment({{ $assessment['id'] }});" id="the-stop-button"
                            class="mx-2 btn btn-gawedata-danger-2 font-lato font-weight-bold">
                            <span class="fas fa-fw fa-stop-circle"></span>
                            Stop Tes
                        </a>
                    </li>
                    <li class="nav-item align-items-center mx-4 d-none" id="done-button">
                        <h6 class="mx-2 my-0 text-gray">Tes Selesai</h6>
                        <h5 class="mx-2 my-0 text-gray">{{ $hour }}:{{ $minute }}:00</h5>
                    </li>
                @endif
                @if ($assessment['status_id'] == 9)
                    <li class="nav-item d-flex align-items-center mx-4" id="stop-button">
                        <h6 class="mx-2 my-0 text-gray">Waktu</h6>
                        <h5 class="mx-2 my-0 text-gawedata assessment-countdown">
                            {{ $hour }}:{{ $minute }}:00</h5>
                        <a onclick="stopAssessment({{ $assessment['id'] }});" id="the-stop-button"
                            class="mx-2 btn btn-gawedata-danger-2 font-lato font-weight-bold">
                            <span class="fas fa-fw fa-stop-circle"></span>
                            Stop Tes
                        </a>
                    </li>
                    <li class="nav-item align-items-center mx-4 d-none" id="done-button">
                        <h6 class="mx-2 my-0 text-gray">Tes Selesai</h6>
                        <h5 class="mx-2 my-0 text-gray">{{ $hour }}:{{ $minute }}:00</h5>
                    </li>
                @endif
            @endif
        @endif
        <li class="nav-item mx-4 position-relative">
            <img src="{{ asset('images/logo.png') }}" id="user-profile" class="rounded-circle" width="50px"
                height="50px">
            <div id="profile-menu-box">
                <div id="profile-menu" class="p-4">
                    <p class="mt-0 mb-2 font-weight-bold">Kuota Responden
                        <span class="fa fa-fw fa-info-circle text-secondary"></span>
                    </p>
                    <div class="profile-quota-box mb-1">
                        <div class="profile-quota" style="width: 30%;"></div>
                    </div>
                    <p class="my-0 text-secondary">Tersisa <span class="used-quota">0</span>/<span
                            class="user-quota">150</span> kuota
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
