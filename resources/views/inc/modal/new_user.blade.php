<!-- Modal -->
<div class="modal fade font-nexa" id="start-modal" tabindex="-1" aria-labelledby="start-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 pt-2 pb-5" style="border-radius: 18px !important;">
            <div class="modal-header border-0">
                <span class="fa fa-fw fa-times-circle fs-5 text-gray cursor-pointer ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></span>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/start-modal.png') }}" width="135px" height="145px">
                <h3 class="font-weight-bold">Selamat datang di Gawedata</h3>
                <p class="my-0 font-lato">Buat survei lebih cepat, mudah dan efektif sesuai kriteria respondenmu.
                </p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).on('load', function() {
        @if ($user['is_first_login'] == true)
            $('#start-modal').modal('show');
            $.ajax({
            url: '{{ config('services.api.url') }}' + "/turnOffIsFirstLogin",
            headers: {
            "Authorization":"Bearer {{ session('token') }}",
            },
            success: function(data) {
            }
            });
        @endif
    });
</script>
