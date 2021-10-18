<ul class="list-unstyled my-4">
    <div class="d-flex align-items-center justify-content-center gx-3 mb-5 px-2 font-nexa">
        <a class="tab-gawedata tab-type text-decoration-none px-2 py-1 me-auto fs-5" id="tab-pertanyaan"
            onclick="changeTab('pertanyaan');">Pertanyaan
        </a>
        <span class="text-gray font-weight-bold fs-4">|</span>
        <a class="tab-gawedata-active tab-type text-decoration-none px-2 py-1 ms-auto fs-5" id="tab-responden"
            onclick="changeTab('responden');">Tipe Responden
        </a>
    </div>
    <div class="d-flex align-items-center justify-content-between ms-3">
        <h4 class="font-lato ms-3">Tipe Responden</h4>
        <div id="add-question-button" class="fas fa-plus-circle text-gawedata fs-2 me-3 cursor-pointer"
        @if (count($assessment['respondent_types']) > 0 && $new == 'false')
            {{-- if udah ada pertanyaan, dia bikin new di index + 1 --}}
            onclick="saveDraft({{ count($assessment['respondent_types']) + 1 }}, true);"
        @elseif ($new == 'true')
            onclick="saveDraft({{ $i + 1 }}, true);"
        @else
            {{-- if belum ada pertanyaan, dia bikin new di pertama --}}
            onclick="saveDraft({{ $i }}, true);"
            @endif
            ></div>
    </div>
    <div id="survey-detail-sidebar" class="ms-4 me-3">
        <div class="list-group">
            @if (count($assessment['respondent_types']) > 0)
                @foreach ($assessment['respondent_types'] as $respondent)
                    <a href="#" class="text-decoration-none cursor-pointer survey-question-card"
                        onclick="saveDraft({{ $loop->iteration }}, false);">
                        <li class="font-lato my-2 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                            <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline position-absolute @if ($loop->iteration != $i) invisible @endif"> 
                            </div>
                            <div class="d-flex align-items-center justify-content-between ms-4">
                                <span class="sidebar-question text-gray text-decoration-none ms-1 fs-6"
                                    style="color: #000 !important;">
                                    @if ($respondent['name'] != '')
                                        {{ strlen($respondent['name']) > 25 ? substr($respondent['name'], 0, 23) . '...' : $respondent['name'] }}
                                    @else
                                        Responden Baru
                                    @endif
                                </span>
                                <span class="badge-pertanyaan-new font-weight-bold px-2 py-1" style="color: #3f60f5 !important;">
                                    Skor : {{$respondent['min_points']}} - {{$respondent['max_points']}}
                                </span>
                            </div>
                        </li>
                    </a>
                @endforeach
            @endif
            @if ($new == 'true')
                <a href="#" class="text-decoration-none cursor-pointer survey-question-card">
                    <li class="font-lato my-2 pe-4 py-3 active position-relative">
                        <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline position-absolute"> 
                        </div>
                        <div class="d-flex align-items-center justify-content-between ms-4">
                            <span class="sidebar-question text-gray text-decoration-none ms-1 fs-6"
                                style="color: #000 !important;">
                                Responden Baru
                            </span>
                            <span class="badge-pertanyaan-new font-weight-bold px-2 py-1" style="color: #3f60f5 !important;">
                                Skor : 0 - 100
                            </span>
                        </div>
                    </li>
                </a>
            @endif
        </div>
    </div>
</ul>
