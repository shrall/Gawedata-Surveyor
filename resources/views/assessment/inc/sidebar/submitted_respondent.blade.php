<ul class="list-unstyled my-4">
    <li class="my-4">
        <div class="card card-submitted mx-3 p-4">
            <h5 class="font-lato font-weight-bold mb-4">Tes Telah Tersubmit 🎉</h5>
            <span class="text-gray">Mohon menunggu untuk Verifikasi dari tim Gawedata. Setelah disetujui, kamu akan mendapatkan Link tes ini.</span>
        </div>
    </li>
    @if ($assessment['assessment_type_id'] == 3)
    <div class="d-flex align-items-center justify-content-center gx-3 mb-5 px-2 font-nexa">
        <a href="{{ route('assessment.submitted', ['id' => $assessment['id'], 'i' => 1]) }}"
            class="tab-gawedata tab-type text-decoration-none px-2 py-1 me-auto fs-5" id="tab-pertanyaan"
            onclick="changeTab('pertanyaan');">Pertanyaan
        </a>
        <span class="text-gray font-weight-bold fs-4">|</span>
        <a href="{{ route('assessment.submitted.respondent', ['id' => $assessment['id'], 'i' => 1]) }}"
            class="tab-gawedata-active tab-type text-decoration-none px-2 py-1 ms-auto fs-5" id="tab-responden"
            onclick="changeTab('responden');">Tipe Responden
        </a>
    </div>
    @endif
    <div id="survey-detail-sidebar" class="mx-3">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        <div class="position-relative pe-2" style="height: 60vh!important; overflow-y: auto:">
        @if (count($assessment['respondent_types']) > 0)
            @foreach ($assessment['respondent_types'] as $respondent)
                <a href="{{route('assessment.submitted.respondent', ['id' => $assessment['id'], 'i' => $loop->iteration])}}"
                    class="text-decoration-none cursor-pointer survey-question-card">
                    <li class="font-lato my-2 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                        <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline position-absolute @if ($loop->iteration != $i) invisible @endif">
                        </div>
                        <div class="d-flex align-items-center justify-content-between ms-4">
                            <span class="sidebar-question text-gray text-decoration-none ms-1 fs-6"
                                style="color: #000 !important;">
                                {{ strlen($respondent['name']) > 25 ? substr($respondent['name'], 0, 23) . '...' : $respondent['name'] }}
                            </span>
                            <span class="badge-pertanyaan-new font-weight-bold px-2 py-1" style="color: #3f60f5 !important;">
                                Skor : {{$respondent['min_points']}} - {{$respondent['max_points']}}
                            </span>
                        </div>
                    </li>
                </a>
            @endforeach
        @endif
        </div>
    </div>
</ul>
