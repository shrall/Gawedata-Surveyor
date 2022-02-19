<!-- Modal -->
<div class="modal fade font-nexa" id="reject-grid-modal-{{$survey['id']}}" tabindex="-1" aria-labelledby="reject-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 pt-2 pb-5" style="border-radius: 18px !important;">
            <div class="modal-header border-0">
                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></span>
            </div>
            <div class="modal-body text-center">
                <h3 class="font-weight-bold">Alasan Ditolak</h3>
                <p class="my-0 font-lato">{{$survey['reject_reason']}}
                </p>
            </div>
        </div>
    </div>
</div>
