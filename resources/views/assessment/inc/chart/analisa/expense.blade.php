@if ($result['total_respondent'] > 0)
    <div class="row">
        <div class="text-start">
            <h4 class="font-weight-bold">Pengeluaran</h4>
            <h6 class="text-gray">{{ $result['total_respondent'] }} Jawaban</h6>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="expense-chart"></div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="text-start">
            <h4 class="font-weight-bold">Pengeluaran</h4>
            <h6 class="text-gray">Belum ada respon</h6>
        </div>
        <div class="row">
            <div class="col-12">
                <h6 class="text-gray">Grafik akan muncul setelah ada respon</h6>
            </div>
        </div>
    </div>
@endif
