<!-- Modal -->
<div class="modal fade font-lato" id="create-survey-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ps-4 py-0" style="border-radius: 18px !important;">
            <div class="modal-body py-0">
                <div class="row">
                    <div class="col-5 text-start border-end pt-5 pe-0">
                        <ul class="list-unstyled font-weight-bold my-5" id="create-survey-sidebar">
                            <li class="my-4 active
                                position-relative">
                                <span href="{{ route('user.editprofile') }}"
                                    class="text-gray text-decoration-none fs-6">1. Pilih Nama dan Kategori</span>
                                <div class="active-border py-1 position-absolute end-0 d-inline"> </div>
                            </li>
                            <li class="my-4 position-relative">
                                <span class="text-gray text-decoration-none fs-6">2. Pilih Kriteria Responden</span>
                                <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                            </li>
                            <li class="my-4 position-relative">
                                <span class="text-gray text-decoration-none fs-6">3. Pilih Jumlah Responden</span>
                                <div class="active-border py-1 position-absolute end-0 d-none"> </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-7 text-center my-4" id="first-step">
                        <div class="d-flex">
                            <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                data-bs-dismiss="modal" aria-label="Close"></span>
                        </div>
                        <h5 class="my-1">Pilih Nama dan Kategori</h5>
                        <div class="row justify-content-center my-5">
                            <div class="col-10">
                                <div class="mb-3">
                                    <input id="survey-title" type="text" class="form-control input-text" name="title"
                                        required placeholder="Judul Survei">
                                </div>
                                <div class="mb-3">
                                    <input id="survey-description" type="text" class="form-control input-text"
                                        name="description" required placeholder="Deskripsi Survei">
                                </div>
                                <div class="mb-3">
                                    <input id="survey-category" type="hidden" name="survey-category">
                                    <div class="dropdown" id="select-survey-category">
                                        <span class="form-control input-text d-flex align-items-center" type="button"
                                            data-bs-toggle="dropdown" id="selected-survey-category">
                                            Kategori Survei
                                            <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                        </span>
                                        <ul class="dropdown-menu w-100 px-2">
                                            <div class="overflow-auto ps-2 pe-5" style="min-height:0;max-height: 30vh;">
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                                <li class="dropdown-item">Action</li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input id="survey-type" type="hidden" name="survey-type">
                                    <div class="dropdown" id="select-survey-type">
                                        <span class="form-control input-text d-flex align-items-center" type="button"
                                            data-bs-toggle="dropdown" id="selected-survey-type">
                                            Jenis Survei
                                            <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                                        </span>
                                        <ul class="dropdown-menu w-100 px-2">
                                            <div class="overflow-auto ps-2 pe-5" style="min-height:0;max-height: 30vh;">
                                                <li class="dropdown-item">Public (Semua responden dapat melihat dan
                                                    mengisi survei)</li>
                                                <li class="dropdown-item">Private (Hanya responden terpilih dapat
                                                    melihat dan mengisi survei)</li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row justify-content-end px-2 mb-2">
                                    <button type="submit" class="btn btn-gawedata col-4 py-2" disabled
                                        id="create-survey-next-button-1">
                                        {{ __('Selanjutnya') }}
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
                    </div>
                    <div class="col-7 text-center my-4 d-none" id="second-step-private">
                        <div class="d-flex">
                            <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto"
                                data-bs-dismiss="modal" aria-label="Close"></span>
                        </div>
                        <h5 class="my-1">Pilih Kriteria Responden</h5>
                        <div class="row justify-content-center my-5 text-start">
                            <div class="col-9">
                                <p>Kamu telah memilih <b>jenis survei private</b>, admin Gawedata akan segera
                                    menghubungimu untuk meminta daftar undangan responden survei.</p>
                                <p>Silahkan pilih jumlah responden untuk melanjutkan pembuatan survei.</p>
                            </div>
                            <div class="col-10">
                                <div class="row justify-content-end px-2 my-2">
                                    <button type="submit" class="btn btn-gawedata col-4 py-2"
                                        id="create-survey-next-button-2">
                                        {{ __('Selanjutnya') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
