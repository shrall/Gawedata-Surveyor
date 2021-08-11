<!-- Modal -->
<div class="modal fade font-nexa" id="submit-modal" tabindex="-1" aria-labelledby="submit-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-4 d-block" style="border-radius: 18px !important;" id="submit-modal-content">
            <div class="modal-header border-0 font-nexa">
                <h3 class="font-weight-bold">Submit Survei?</h3>
            </div>
            <div class="modal-body text-left">
                <p class="my-0 font-lato">Setelah submit, semua pengaturan dan pertanyaan survey tidak bisa diubah lagi.
                    Pastikan surveimu sesuai yah 😊
                </p>
            </div>
            <div class="modal-footer text-right border-0">
                <a href="#" class="btn btn-gawedata-2 font-lato" data-bs-dismiss="modal">
                    Tidak Jadi
                </a>
                <a href="#" class="btn btn-gawedata font-lato font-weight-bold" onclick="submitSurvey();">
                    Submit Survei
                </a>
            </div>
        </div>
        <div class="modal-content px-4 py-4 d-none" style="border-radius: 18px !important;" id="submitted-modal-content">
            <div class="modal-header border-0 font-nexa">
                <h3 class="font-weight-bold">Berhasil disubmit 🎉</h3>
            </div>
            <div class="modal-body text-left">
                <p class="my-0 font-lato">Setelah di submit, tim Gawedata akan mereview surveimu dalam waktu 1x24 Jam
                </p>
            </div>
            <div class="modal-footer text-right border-0">
                <a href="{{ route('survey.submit', ['id' => $survey['id'], 'i' => 1]) }}" class="btn btn-gawedata font-lato font-weight-bold">
                    Oke
                </a>
            </div>
        </div>
    </div>
</div>
