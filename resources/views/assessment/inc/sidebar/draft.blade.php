<ul class="list-unstyled my-4">
    <div class="d-flex align-items-center justify-content-center gx-3 mb-5 px-2 font-nexa">
        <a href="{{ route('assessment.show', ['id' => $assessment['id'], 'i' => 1, 'new' => 'false']) }}"
            class="tab-gawedata-active tab-type text-decoration-none px-2 py-1 me-auto fs-5" id="tab-pertanyaan"
            onclick="changeTab('pertanyaan');">Pertanyaan
        </a>
        <span class="text-gray font-weight-bold fs-4">|</span>
        <a href="{{ route('assessment.showrespondent', ['id' => $assessment['id'], 'i' => 1, 'new' => 'false']) }}"
            class="tab-gawedata tab-type text-decoration-none px-2 py-1 ms-auto fs-5" id="tab-responden"
            onclick="changeTab('responden');">Tipe Responden
        </a>
    </div>
    <div class="d-flex align-items-center justify-content-between ms-3">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        <div id="add-question-button" class="fas fa-plus-circle text-gawedata fs-2 me-3 cursor-pointer"
            onclick="saveDraft({{ $i }}, true);"></div>
    </div>
    <div id="survey-detail-sidebar" class="ms-4 me-3">
        @if (count($assessment['questions']) > 0)
            <div id="simpleList" class="list-group">
                @foreach ($assessment['questions'] as $question)
                    <a href="#" class="text-decoration-none cursor-pointer survey-question-card"
                        onclick="saveDraft({{ $loop->iteration }}, false);">
                        <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                            <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline position-absolute @if ($loop->iteration != $i) invisible @endif"> 
                            </div>
                            <div class="d-flex align-items-center justify-content-end ms-4">
                                <div class="d-flex flex-column me-auto">
                                    <span class="align-self-start badge-pertanyaan-new font-weight-bold px-2 py-1" style="color: #3f60f5 !important;">
                                        P{{ $loop->iteration }}
                                    </span>
                                    <span class="sidebar-question text-gray text-decoration-none ms-1 fs-6"
                                        style="color: #000 !important;">
                                        @if ($question['question'] != '')
                                            {{ strlen($question['question']) > 25 ? substr($question['question'], 0, 23) . '...' : $question['question'] }}
                                        @else
                                            Pertanyaan Baru
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex cursor-grab drag-handle">
                                    <span class="fas  fa-ellipsis-v" style="color: #adb3bc !important;"></span>
                                    <span class="fas  fa-ellipsis-v" style="color: #adb3bc !important;"></span>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</ul>
