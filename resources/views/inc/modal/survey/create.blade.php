<!-- Modal -->
<div class="modal fade font-lato" id="create-survey-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ps-4 py-0" style="border-radius: 18px !important;">
            <div class="modal-body py-0">
                <form action="{{ route('survey.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-5 text-start border-end pt-5 pe-0">
                            <ul class="list-unstyled font-weight-bold my-5" id="create-survey-sidebar">
                                <li class="my-4 active position-relative">
                                    <span class="text-gray text-decoration-none fs-6">1. Pilih Nama dan Kategori</span>
                                    <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">2. Pilih Kriteria Responden</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                                <li class="my-4 position-relative">
                                    <span class="text-gray text-decoration-none fs-6">3. Pilih Deadline & Jumlah
                                        Responden</span>
                                    <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-7 text-center my-4 d-inline" id="first-step">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pilih Nama dan Kategori</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-10">
                                    <div class="mb-3">
                                        <input id="survey-title" type="text" class="form-control input-text"
                                            name="title" required placeholder="Judul Survei">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="survey-description" type="text" class="survey-description form-control input-text"
                                            style="resize: none; height:7rem;"
                                            name="description" required placeholder="Deskripsi Survei"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input id="survey-category" type="hidden" name="survey_category">
                                        <div class="dropdown" id="select-survey-category">
                                            <span class="form-control input-text d-flex align-items-center"
                                                type="button" data-bs-toggle="dropdown" id="selected-survey-category">
                                                Kategori Survei
                                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                            </span>
                                            <ul class="dropdown-menu w-100 px-2">
                                                <div class="overflow-auto ps-2 pe-5"
                                                    style="min-height:0;max-height: 30vh;">
                                                    @foreach ($categories as $category)
                                                        <li class="dropdown-item" data-id={{ $category['id'] }}>
                                                            {{ $category['name'] }}</li>
                                                    @endforeach
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input id="survey-type" type="hidden" name="survey_type">
                                        <div class="dropdown" id="select-survey-type">
                                            <span class="form-control input-text d-flex align-items-center text-start"
                                                type="button" data-bs-toggle="dropdown" id="selected-survey-type">
                                                Jenis Survei
                                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                            </span>
                                            <ul class="dropdown-menu w-100 px-2">
                                                <div class="overflow-auto ps-2 pe-5"
                                                    style="min-height:0;max-height: 30vh;">
                                                    <li class="dropdown-item" data-type="public">Public (Semua responden
                                                        dapat melihat dan
                                                        mengisi survei)</li>
                                                    <li class="dropdown-item text-start" data-type="private">Private
                                                        (Hanya
                                                        responden
                                                        terpilih dapat
                                                        melihat dan mengisi survei)</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end px-2 mb-2">
                                        <button type="submit" class="btn btn-gawedata col-4 py-2" disabled
                                            id="create-survey-next-button-1" onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="second-step-public">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pilih Kriteria Responden</h5>
                            <div class="row justify-content-center my-5">
                                <div class="col-10">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-4 text-start">Jenis Kelamin</div>
                                        <div class="col-6 text-end">
                                            <input type="checkbox" class="btn-check" id="check-pria" name="check-pria"
                                                autocomplete="off">
                                            <label class="btn btn-checkbox-gawedata px-4 me-2"
                                                for="check-pria">Pria</label>
                                            <input type="checkbox" class="btn-check" id="check-wanita"
                                                name="check-wanita" autocomplete="off">
                                            <label class="btn btn-checkbox-gawedata px-4 ms-2"
                                                for="check-wanita">Wanita</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-4 text-start">Rentang Umur</div>
                                        <div class="col-5 text-end">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <input type="number" name="age_start" id="age-start"
                                                    class="form-control input-text text-center" min="0">
                                                <span class="mx-2">sampai</span>
                                                <input type="number" name="age_end" id="age-end"
                                                    class="form-control input-text text-center" max="1000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-control input-text" id="survey-province" name="province[]"
                                            multiple="multiple">
                                            <option value="all">Semua Provinsi</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location['id'] }}">
                                                    {{ $location['province_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="cities[]" id="survey-city-all">
                                        <select class="form-control input-text" id="survey-city" name="city[]"
                                            multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="educations[]" id="survey-education-all">
                                        <select class="form-control input-text" id="survey-education" name="education[]"
                                            multiple="multiple">
                                            <option value="all">Semua Pendidikan</option>
                                            @foreach ($educations as $education)
                                                <option value="{{ $education['id'] }}">{{ $education['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="professions[]" id="survey-profession-all">
                                        <select class="form-control input-text" id="survey-profession"
                                            name="profession[]" multiple="multiple">
                                            <option value="all">Semua Profesi</option>
                                            @foreach ($professions as $profession)
                                                <option value="{{ $profession['id'] }}">{{ $profession['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="expenses[]" id="survey-expense-all">
                                        <select class="form-control input-text" id="survey-expense" name="expense[]"
                                            multiple="multiple">
                                            <option value="all">Semua Pengeluaran</option>
                                            @foreach ($expenses as $expense)
                                                <option value="{{ $expense['id'] }}">{{ $expense['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-survey-back-button-2-public">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2"
                                            id="create-survey-next-button-2-public" disabled
                                            onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="second-step-private">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pilih Kriteria Responden</h5>
                            <div class="row justify-content-center my-5 text-start">
                                <div class="col-10">
                                    <p>Kamu telah memilih <b>jenis survei private</b>, admin Gawedata akan segera
                                        menghubungimu untuk meminta daftar undangan responden survei.</p>
                                    <p>Silahkan pilih jumlah responden untuk melanjutkan pembuatan survei.</p>
                                </div>
                                <div class="col-10">
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-survey-back-button-2-private">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2"
                                            id="create-survey-next-button-2-private" onclick="event.preventDefault()">
                                            Selanjutnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 text-center my-4 d-none" id="third-step">
                            <div class="d-flex">
                                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                    data-bs-dismiss="modal" aria-label="Close"></span>
                            </div>
                            <h5 class="my-1">Pilih Jumlah Responden</h5>
                            <div class="row justify-content-center my-5 text-start">
                                <div class="col-10">
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-5 text-start">Estimasi Waktu Pengerjaan</div>
                                        <div class="col-3 text-end">
                                            <div class="input-group mb-3">
                                              <input type="number" class="form-control input-text" name="estimate_time">
                                              <span class="input-group-text input-text text-gray" style="padding-left: 0.65rem !important; padding-right: 0.65rem !important;">Menit</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-5 text-start">Deadline Pengisian Survei</div>
                                        <div class="col-7 text-end">
                                            <div
                                                class="d-flex justify-content-between align-items-center position-relative">
                                                <input type="text" name="survey_deadline" id="survey-deadline"
                                                    class="form-control input-text" required>
                                                <span
                                                    class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-6 text-gawedata"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-0 mb-2 font-weight-bold">Kuota Responden
                                        <span class="fa fa-fw fa-info-circle text-secondary"></span>
                                    </p>
                                    <div class="profile-quota-box mb-1">
                                        <div class="profile-quota" style="width: 30%;"></div>
                                    </div>
                                    <p class="my-0 text-secondary">Tersisa <span class="used-quota">0</span>/<span class="user-quota">150</span> kuota
                                        responden</p>
                                    <div class="my-3">
                                        <a href="#" class="text-gawedata text-decoration-none font-weight-bold">
                                            <span class="fa fa-fw fa-phone-alt me-2"></span>Hubungi Admin Via Whatsapp
                                        </a>
                                    </div>
                                    <div class="row justify-content-between align-items-center mb-3">
                                        <div class="col-12">
                                            <input type="number" name="survey_respondent" id="survey-respondent"
                                                class="form-control input-text" placeholder="Jumlah Responden" min="0"
                                                required>
                                            <span class="invalid-feedback text-end">
                                                <strong>Kuota anda tidak mencukupi, silahkan hubungi admin.</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="row justify-content-between align-items-center px-2 mb-2">
                                        <span class="col-4 text-gawedata text-start cursor-pointer ps-0"
                                            id="create-survey-back-button-3">
                                            <span class="fa fa-fw fa-arrow-left me-2"></span>Sebelumnya
                                        </span>
                                        <button type="submit" class="btn btn-gawedata col-4 py-2" disabled
                                            id="create-survey-next-button-3">
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
