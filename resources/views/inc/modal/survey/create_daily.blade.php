<!-- Modal -->
<form action="" method="post"></form>
<div class="modal fade font-lato" id="create-survey-modal-daily" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-4 d-block" style="border-radius: 18px !important;">
            <form action="{{ route('survey.store') }}" method="post">
                @csrf
                <div class="d-flex">
                    <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto" data-bs-dismiss="modal"
                        aria-label="Close"></span>
                </div>
                <div class="modal-header border-0 pt-0 justify-content-center">
                    <h5>Daily Survei Baru</h5>
                </div>
                <div class="modal-body text-left">
                    <div class="mb-3">
                        <input id="survey-title-daily" type="text" class="form-control input-text" name="title" required
                            placeholder="Judul Survei">
                    </div>
                    <div class="mb-3">
                        <textarea id="survey-description-daily" type="text" class="survey-description form-control input-text"
                            style="resize: none; height:7rem;" name="description" required
                            placeholder="Deskripsi Survei"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="row justify-content-between align-items-center position-relative">
                            <input type="hidden" name="daily_date" id="input-daily-date" value="{{date('Y-m-d')}}">
                            <input type="hidden" name="start_time" id="input-daily-start" value="00:00">
                            <input type="hidden" name="end_time" id="input-daily-end" value="23:59">
                            <div class="col-8 d-flex justify-content-between align-items-center position-relative">
                                <input type="text" name="daily_datepicker" id="survey-daily-date"
                                    class="form-control input-text" required>
                                <span
                                    class="fa fa-fw fa-calendar-day position-absolute top-50 end-0 translate-middle-y pe-4 me-3 fs-6 text-gawedata"></span>
                            </div>
                            <div class="col-4 d-flex justify-content-between align-items-center position-relative">
                                <input type="text" name="daily_timepicker" id="survey-daily-time"
                                    class="form-control input-text" required>
                                <span
                                    class="fa fa-fw fa-clock position-absolute top-50 end-0 translate-middle-y pe-4 me-3 fs-6 text-gawedata"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center position-relative">
                            <span
                                class="fa fa-fw fa-minus-square position-absolute top-50 start-0 translate-middle-y ps-2 ms-2 fs-5 text-gawedata cursor-pointer"
                                onclick="changePointValue('-');"></span>
                            <input type="number" name="survey_points" id="survey-points-daily"
                                class="form-control input-text text-center px-5" required value=0>
                            <span
                                class="fa fa-fw fa-plus-square position-absolute top-50 end-0 translate-middle-y pe-4 me-2 fs-5 text-gawedata cursor-pointer"
                                onclick="changePointValue('+');"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right border-0">
                    <a href="#" class="btn btn-gawedata-2" data-bs-dismiss="modal">
                        Tidak Jadi
                    </a>
                    <button type="submit" class="btn btn-gawedata font-weight-bold">
                        Submit Survei
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
