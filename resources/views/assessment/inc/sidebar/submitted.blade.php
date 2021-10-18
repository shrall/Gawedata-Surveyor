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
            class="tab-gawedata-active tab-type text-decoration-none px-2 py-1 me-auto fs-5" id="tab-pertanyaan"
            onclick="changeTab('pertanyaan');">Pertanyaan
        </a>
        <span class="text-gray font-weight-bold fs-4">|</span>
        <a href="{{ route('assessment.submitted.respondent', ['id' => $assessment['id'], 'i' => 1]) }}"
            class="tab-gawedata tab-type text-decoration-none px-2 py-1 ms-auto fs-5" id="tab-responden"
            onclick="changeTab('responden');">Tipe Responden
        </a>
    </div>
    @endif
    <div id="survey-detail-sidebar" class="mx-3">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        @foreach ($assessment['questions'] as $question)
            <a href="{{route('assessment.submitted', ['id' => $assessment['id'], 'i' => $loop->iteration])}}" class="text-decoration-none">
                <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative" style="padding-left: 4rem !important;">
                    <div class="active-border position-absolute py-1  top-50 start-0 translate-middle-y d-inline @if ($loop->iteration != $i) invisible @endif"> 
                    </div>
                    <span class="badge-pertanyaan position-absolute top-50 translate-middle-y font-weight-bold p-2" style="color: #3f60f5 !important; left:1rem;">P{{ $loop->iteration }}</span>
                    <span class="text-start text-gray text-decoration-none fs-6" style="color: #000 !important;">{{ $question['question'] }}</span>
                </li>
            </a>
        @endforeach
    </div>
</ul>
