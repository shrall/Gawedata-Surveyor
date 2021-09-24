@if ($result['total_respondent'] > 0)
    <div class="row">
        <div class="text-start">
            <h4 class="font-weight-bold">Provinsi</h4>
            <h6 class="text-gray">{{ $result['total_respondent'] }} Jawaban</h6>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="province-chart"></div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="text-start">
            <h4 class="font-weight-bold">Provinsi</h4>
            <h6 class="text-gray">Belum ada respon</h6>
        </div>
        <div class="row">
            <div class="col-12">
                <h6 class="text-gray">Grafik akan muncul setelah ada respon</h6>
            </div>
        </div>
    </div>
@endif
