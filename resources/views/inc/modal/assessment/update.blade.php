<!-- Modal -->
<div class="modal fade font-lato" id="update-assessment-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ps-4 py-0" style="border-radius: 18px !important;">
            <div class="modal-body py-0">
                <form action="{{ route('assessment.changesettings', $assessment['id']) }}" method="post"
                    id="create-assessment-form">
                    @csrf
                    @method('PUT')
                    @if ($assessment['assessment_type_id'] == 1)
                        <input type="hidden" id="assessment-method" name="assessment_method" value="irt">
                    @elseif ($assessment['assessment_type_id'] == 2)
                        <input type="hidden" id="assessment-method" name="assessment_method" value="rs">
                    @elseif ($assessment['assessment_type_id'] == 3)
                        <input type="hidden" id="assessment-method" name="assessment_method" value="sa">
                    @endif
                    @if ($assessment['with_ranking'] || $assessment['is_simultaneously'] == 1)
                        <input type="hidden" id="assessment-serentak" name="assessment_serentak" value="true">
                    @else
                        <input type="hidden" id="assessment-serentak" name="assessment_serentak" value="false">
                    @endif
                    <div class="row">
                        <div class="col-5 text-start border-end pt-5 pe-0">
                            <ul @if ($assessment['assessment_type_id'] == 1)
                                class="list-unstyled font-weight-bold my-5 create-assessment-sidebar assessment-rs assessment-sa d-none"
                            @else
                                class="list-unstyled font-weight-bold my-5 create-assessment-sidebar assessment-rs assessment-sa"
                                @endif>
                                <li class="my-4 active position-relative">
                                    <span class="text-gray text-decoration-none fs-6">1. Pilih Jenis Tes</span>
                                    <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">2. Detail Tes</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                            </ul>
                            <ul @if ($assessment['assessment_type_id'] == 1)
                                class="list-unstyled font-weight-bold my-5 create-assessment-sidebar assessment-irt"
                            @else
                                class="list-unstyled font-weight-bold my-5 create-assessment-sidebar assessment-irt d-none"
                                @endif>
                                <li class="my-4 active position-relative">
                                    <span class="text-gray text-decoration-none fs-6">1. Pilih Jenis Tes</span>
                                    <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">2. Detail Tes</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">3. Tingkat Kesulitan</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">4. Pemberian Bobot Nilai</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-7 text-center my-4 d-inline" id="assessment-first-step">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pilih Jenis Tes</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-10">
                                    <div class="mb-3">
                                        <div class="form-check d-flex-col">
                                            <div class="mb-3">
                                                <input class="form-check-input d-none" type="radio"
                                                    name="assessment_type_id" value=1 id="radio-assessment-irt"
                                                    @if ($assessment['assessment_type_id'] == 1)
                                                checked
                                                @endif>
                                                <label id="radio-label-assessment-irt"
                                                    onclick="changeAssessmentType('irt');" @if ($assessment['assessment_type_id'] == 1)
                                                    class="form-check-label card radio-card-assessment cursor-pointer active p-2"
                                                @else
                                                    class="form-check-label card radio-card-assessment cursor-pointer p-2"
                                                    @endif
                                                    for="radio-assessment-irt">
                                                    <div
                                                        class="card-header d-flex align-items-center justify-content-between">
                                                        <h5 class="font-weight-bold">IRT Scoring</h5>
                                                        @if ($assessment['assessment_type_id'] == 1)
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-irt"></span>
                                                        @else
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-irt d-none"></span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body py-0">
                                                        <span class="font-weight-regular">
                                                            Mengutamakan karakteristik dari setiap soal.
                                                            <a href="#" class="irt-info">Baca selengkapnya</a>
                                                        </span>
                                                    </div>
                                                    <div @if ($assessment['assessment_type_id'] == 1)
                                                        class="card-footer d-flex align-items-center assessment-irt"
                                                    @else
                                                        class="card-footer d-flex align-items-center assessment-irt d-none"
                                                        @endif>
                                                        <div
                                                            class="form-check d-flex align-items-center form-switch mb-0 ps-0">
                                                            <label for="with_discussion_irt">Dengan pembahasan</label>
                                                            <input name="with_discussion" id="with_discussion_irt"
                                                                class="form-check-input form-check-input-switch form-check-assessment
                                                                cursor-pointer ms-3"
                                                                @if ($assessment['with_discussion'] && $assessment['assessment_type_id'] == 1)
                                                            checked
                                                            @endif
                                                            type="checkbox">
                                                        </div>
                                                        <div
                                                            class="form-check d-flex align-items-center form-switch mb-0 ms-2 ps-0">
                                                            <label for="with_ranking">Serentak (dengan ranking)</label>
                                                            <input name="with_ranking_irt" id="with_ranking_irt"
                                                                class="form-check-input form-check-input-switch  form-check-assessment
                                                                cursor-pointer ms-3"
                                                                @if ($assessment['assessment_type_id'] == 1)
                                                            @if ($assessment['with_ranking'] || $assessment['is_simultaneously'] == 1)
                                                                checked
                                                            @endif
                                                            @endif
                                                            onclick="toggleSerentak();" type="checkbox">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <input class="form-check-input d-none" type="radio"
                                                    name="assessment_type_id" value=2 id="radio-assessment-rs"
                                                    @if ($assessment['assessment_type_id'] == 2)
                                                checked
                                                @endif>
                                                <label id="radio-label-assessment-rs"
                                                    onclick="changeAssessmentType('rs');" @if ($assessment['assessment_type_id'] == 2)
                                                    class="form-check-label card radio-card-assessment cursor-pointer active p-2"
                                                @else
                                                    class="form-check-label card radio-card-assessment cursor-pointer p-2"
                                                    @endif
                                                    for="radio-assessment-rs">
                                                    <div
                                                        class="card-header d-flex align-items-center justify-content-between">
                                                        <h5 class="font-weight-bold">Regular Scoring</h5>
                                                        @if ($assessment['assessment_type_id'] == 2)
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-rs"></span>
                                                        @else
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-rs d-none"></span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body py-0">
                                                        <span class="font-weight-regular">
                                                            Berbasis poin angka yang dapat ditetapkan di setiap jawaban
                                                            benar dan salah.
                                                        </span>
                                                    </div>
                                                    <div @if ($assessment['assessment_type_id'] == 2)
                                                        class="card-footer d-flex align-items-center assessment-rs"
                                                    @else
                                                        class="card-footer d-flex align-items-center assessment-rs d-none"
                                                        @endif>
                                                        <div
                                                            class="form-check d-flex align-items-center form-switch mb-0 ps-0">
                                                            <label for="with_discussion_rs">Dengan pembahasan</label>
                                                            <input name="with_discussion" id="with_discussion_rs"
                                                                class="form-check-input form-check-input-switch form-check-assessment
                                                                cursor-pointer ms-3"
                                                                @if ($assessment['with_discussion'] && $assessment['assessment_type_id'] == 2)
                                                            checked
                                                            @endif
                                                            type="checkbox">
                                                        </div>
                                                        <div
                                                            class="form-check d-flex align-items-center form-switch mb-0 ms-2 ps-0">
                                                            <label for="with_ranking_rs">Serentak (dengan
                                                                ranking)</label>
                                                            <input name="with_ranking" id="with_ranking_rs"
                                                                class="form-check-input form-check-input-switch form-check-assessment
                                                                cursor-pointer ms-3"
                                                                @if ($assessment['assessment_type_id'] == 2)
                                                            @if ($assessment['with_ranking'] || $assessment['is_simultaneously'] == 1)
                                                                checked
                                                            @endif
                                                            @endif
                                                            onclick="toggleSerentak();" type="checkbox">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <input class="form-check-input d-none" type="radio"
                                                    name="assessment_type_id" value=3 id="radio-assessment-sa"
                                                    @if ($assessment['assessment_type_id'] == 3)
                                                checked
                                                @endif>
                                                <label id="radio-label-assessment-sa"
                                                    onclick="changeAssessmentType('sa');" @if ($assessment['assessment_type_id'] == 3)
                                                    class="form-check-label card radio-card-assessment cursor-pointer active p-2"
                                                @else
                                                    class="form-check-label card radio-card-assessment cursor-pointer p-2"
                                                    @endif
                                                    for="radio-assessment-sa">
                                                    <div
                                                        class="card-header d-flex align-items-center justify-content-between">
                                                        <h5 class="font-weight-bold">Self-assessment</h5>
                                                        @if ($assessment['assessment_type_id'] == 3)
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-sa"></span>
                                                        @else
                                                            <span
                                                                class="far fa-fw fa-check-square fs-4 assessment-sa d-none"></span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body py-0">
                                                        <span class="font-weight-regular">
                                                            Survei penilaian diri untuk kebutuhan seperti psikologi,
                                                            dll.
                                                        </span>
                                                    </div>
                                                    <div @if ($assessment['assessment_type_id'] == 3)
                                                        class="card-footer d-flex align-items-center assessment-sa"
                                                    @else
                                                        class="card-footer d-flex align-items-center assessment-sa d-none"
                                                        @endif>
                                                        <div
                                                            class="form-check d-flex align-items-center form-switch mb-0 ps-0">
                                                            <label for="with_discussion_sa">Dengan pembahasan</label>
                                                            <input name="with_discussion" id="with_discussion_sa"
                                                                class="form-check-input form-check-input-switch form-check-assessment
                                                                cursor-pointer ms-3"
                                                                @if ($assessment['with_discussion'] && $assessment['assessment_type_id'] == 3)
                                                            checked
                                                            @endif
                                                            type="checkbox">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end px-2 mb-2">
                                        <button type="submit" class="btn btn-gawedata col-4 py-2"
                                            id="create-assessment-next-button-1" onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="assessment-second-step">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Detail Tes</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-10">
                                    <div class="mb-3">
                                        <input id="assessment-title" type="text" class="form-control input-text"
                                            name="title" required placeholder="Judul Assessment"
                                            value="{{ $assessment['title'] }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="assessment-description" type="text"
                                            class="assessment-description form-control input-text"
                                            style="resize: none; height:7rem;" name="description" required
                                            placeholder="Deskripsi Assessment">{{ $assessment['description'] }}</textarea>
                                    </div>
                                    <div class="mb-3 assessment-irt assessment-rs">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="number" name="duration" id="assessment-duration"
                                                value="{{ $assessment['duration'] }}" placeholder="Durasi tes"
                                                class="form-control input-text" required>
                                            <span
                                                class="position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gray">menit</span>
                                        </div>
                                    </div>
                                    <div class="mb-3 assessment-irt assessment-rs non-serentak">
                                        <div class="row">
                                            <div class="col-6">
                                                <div
                                                    class="d-flex justify-content-between align-items-center position-relative">
                                                    <input type="text" name="start_time_ns"
                                                        id="assessment-start-time-non-serentak"
                                                        value="{{ $assessment['start_time'] }}"
                                                        class="form-control input-text"
                                                        placeholder="Tanggal/Waktu Mulai Tes" required>
                                                    <span
                                                        class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gawedata"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div
                                                    class="d-flex justify-content-between align-items-center position-relative">
                                                    <input type="text" name="end_time_ns"
                                                        id="assessment-end-time-non-serentak"
                                                        value="{{ $assessment['end_time'] }}"
                                                        class="form-control input-text"
                                                        placeholder="Tanggal/Waktu Berakhir Tes" required>
                                                    <span
                                                        class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gawedata"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 assessment-irt assessment-rs serentak d-none">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="text" name="start_time" id="assessment-start-time"
                                                value="{{ $assessment['start_time'] }}"
                                                class="form-control input-text" placeholder="Tanggal/Waktu Mulai Tes"
                                                required>
                                            <span
                                                class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gawedata"></span>
                                        </div>
                                    </div>
                                    <div class="mb-3 assessment-sa d-none">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="text" name="end_time" id="assessment-end-time"
                                                class="form-control input-text" value="{{ $assessment['end_time'] }}"
                                                placeholder="Tanggal Berakhir Pengisian" required>
                                            <span
                                                class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gawedata"></span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input id="assessment-type" type="hidden" name="assessment_type"
                                            @if ($assessment['is_private']) value="Private" @else value="Public" @endif>
                                        <div class="dropdown" id="select-assessment-type">
                                            <span class="form-control input-text d-flex align-items-center text-start"
                                                type="button" data-bs-toggle="dropdown" id="selected-assessment-type">
                                                @if ($assessment['is_private'])
                                                    Private (Hanya responden terpilih dapat melihat dan mengisi survei)
                                                @else
                                                    Public (Semua responden dapat melihat dan mengisi survei)
                                                @endif
                                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                            </span>
                                            <ul class="dropdown-menu w-100 px-2">
                                                <div class="overflow-auto ps-2 pe-5"
                                                    style="min-height:0;max-height: 30vh;">
                                                    <li class="dropdown-item" data-type="public">Public (Semua
                                                        responden
                                                        dapat melihat dan
                                                        mengisi tes)</li>
                                                    <li class="dropdown-item text-start" data-type="private">Private
                                                        (Hanya
                                                        responden
                                                        terpilih dapat
                                                        melihat dan mengisi tes)</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-assessment-back-button-2">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2" disabled
                                            id="create-assessment-next-button-2" onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="assessment-third-step-irt">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Tingkat Kesulitan</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-11 text-center text-gray">
                                    <p>Tingkat kesulitan dalam IRT dapat membantu menentukan
                                        kemampuan para peserta
                                        secara keseluruhan dalam menjawab soal - soal dalam ujian yang dilaksanakan.
                                        Terdapat 3 Kategori, Sulit, sedang dan Mudah</p>
                                </div>
                                <div class="col-11 row justify-content-center align-items-center mb-3">
                                    <div class="col-5 text-end">Soal dikatakan <span
                                            class="text-danger">SULIT</span> apabila</div>
                                    <div class="col-3">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="number" name="hard_in_percent" id="assessment-hard-in-percent"
                                                value="{{ $assessment['hard_in_percent'] ?? 25 }}"
                                                class="form-control input-text" min="0" max="100" value=25 required>
                                            <span
                                                class="fa fa-fw fa-percent position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6"></span>
                                        </div>
                                    </div>
                                    <div class="col-4 text-start">peserta menjawab benar</div>
                                </div>
                                <div class="col-11 row justify-content-center align-items-center mb-3">
                                    <div class="col-5 text-end">Soal dikatakan <span
                                            class="text-warning">SEDANG</span> apabila minimal</div>
                                    <div class="col-3">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="number" name="medium_in_percent"
                                                value="{{ $assessment['medium_in_percent'] ?? 50 }}"
                                                id="assessment-medium-in-percent" class="form-control input-text"
                                                min="0" max="100" value=50 required>
                                            <span
                                                class="fa fa-fw fa-percent position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6"></span>
                                        </div>
                                    </div>
                                    <div class="col-4 text-start">peserta menjawab benar</div>
                                </div>
                                <div class="col-11 row justify-content-center align-items-center mb-3">
                                    <div class="col-5 text-end">Soal dikatakan <span
                                            class="text-success">MUDAH</span> apabila minimal</div>
                                    <div class="col-3">
                                        <div
                                            class="d-flex justify-content-between align-items-center position-relative">
                                            <input type="number" name="easy_in_percent" id="assessment-easy-in-percent"
                                                value="{{ $assessment['easy_in_percent'] ?? 75 }}"
                                                class="form-control input-text" min="0" max="100" value=75 required>
                                            <span
                                                class="fa fa-fw fa-percent position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6"></span>
                                        </div>
                                    </div>
                                    <div class="col-4 text-start">peserta menjawab benar</div>
                                </div>
                                <div class="col-11">
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-assessment-back-button-3-irt">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2"
                                            id="create-assessment-next-button-3-irt" onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="assessment-fourth-step-irt">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pemberian Bobot Nilai</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-10 text-center text-gray">
                                    <p>Salah satu kelebihan IRT dan Regular Scoring, skor atau nilai akan ditentukan
                                        berdasarkan tingkat kemampuan peserta menjawab soal dengan tingkatan yang
                                        berbeda beda, sehingga cukup adil. Di Gawedata, hal tersebut didapatkan dari
                                        penambahan nilai bonus. </p>
                                </div>
                                <div class="col-10 row justify-content-center align-items-center mb-3">
                                    <div class="col-6 text-end">Soal <span class="text-danger">SULIT</span>
                                        mendapatkan bobot</div>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="subtractPoints('hard');">-</span>
                                            <input type="text" class="form-control input-text text-center"
                                                value="{{ $assessment['hard_in_points'] ?? 0 }}"
                                                id="assessment-hard-in-points" name="hard_in_points">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="addPoints('hard');">+</span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-start">poin</div>
                                </div>
                                <div class="col-10 row justify-content-center align-items-center mb-3">
                                    <div class="col-6 text-end">Soal <span class="text-warning">SEDANG</span>
                                        mendapatkan bobot</div>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="subtractPoints('medium');">-</span>
                                            <input type="text" class="form-control input-text text-center"
                                                value="{{ $assessment['medium_in_points'] ?? 0 }}"
                                                id="assessment-medium-in-points" name="medium_in_points">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="addPoints('medium');">+</span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-start">poin</div>
                                </div>
                                <div class="col-10 row justify-content-center align-items-center mb-3">
                                    <div class="col-6 text-end">Soal <span class="text-success">MUDAH</span>
                                        mendapatkan bobot</div>
                                    <div class="col-4">
                                        <div class="input-group">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="subtractPoints('easy');">-</span>
                                            <input type="text" class="form-control input-text text-center"
                                                value="{{ $assessment['easy_in_points'] ?? 0 }}"
                                                id="assessment-easy-in-points" name="easy_in_points">
                                            <span class="input-group-text assessment-point-buttons"
                                                onclick="addPoints('easy');">+</span>
                                        </div>
                                    </div>
                                    <div class="col-2 text-start">poin</div>
                                </div>
                                <div class="col-10">
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-assessment-back-button-4-irt">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2"
                                            id="create-assessment-next-button-4-irt">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
