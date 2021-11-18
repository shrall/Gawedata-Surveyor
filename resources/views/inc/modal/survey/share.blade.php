<!-- Modal -->
<div class="modal fade font-lato" id="share-modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-0" style="border-radius: 18px !important;">
            <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bold mb-0">Bagikan Survei</h5>
                <span class="fas fa-fw fa-times text-gray" data-bs-dismiss="modal"></span>
            </div>
            <div class="modal-body py-0">
                @if ($survey['type']['id'] == 1)
                <input type="text" name="link" id="survey-link" class="form-control input-text w-100"
                    value="{{ 'https://gawedata.com/survey/' . $survey['slug'] }}"
                    disabled>
                @elseif ($survey['type']['id'] == 2)
                <input type="text" name="link" id="survey-link" class="form-control input-text w-100"
                    value="{{ 'https://gawedata.com/survey/' . str_replace("-", " ", strtolower($survey['category']['name'])) . '/' . $survey['slug'] }}"
                    disabled>
                @endif
            </div>
            <div class="modal-footer border-0">
                <div class="btn btn-gawedata w-100" id="copy-survey-link-button" onclick="copyToClipboard();">Copy Link
                </div>
            </div>
        </div>
    </div>
</div>
