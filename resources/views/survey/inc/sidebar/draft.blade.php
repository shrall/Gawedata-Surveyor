<ul class="list-unstyled my-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        <div id="add-question-button" class="fas fa-plus-circle text-gawedata fs-2 me-3 cursor-pointer"
            onclick="saveDraft({{ $i }}, true);"></div>
    </div>
    <div id="survey-detail-sidebar" class="mx-3">
        @if (count($survey['questions']) > 0)
        <div id="simpleList" class="list-group position-relative pe-2" style="height: 80vh!important; overflow: scroll;">
            @foreach ($survey['questions'] as $question)
                <a href="#" class="text-decoration-none cursor-pointer survey-question-card"
                    onclick="saveDraft({{ $loop->iteration }}, false);">
                    <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                        <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline position-absolute @if ($loop->iteration != $i) invisible @endif"> 
                        </div>
                        <div class="d-flex align-items-center justify-content-end ms-4">
                            <div class="d-flex flex-column me-auto">
                                <span class="badge-pertanyaan-new font-weight-bold px-2 py-1" style="color: #3f60f5 !important;">
                                    P{{ $loop->iteration }} | @if ($question['survey_question_type_id'] == 1)
                                    Single Answer
                                @elseif ($question['survey_question_type_id'] == 2)
                                    Multiple Answer
                                @elseif ($question['survey_question_type_id'] == 3)
                                    Scale Question
                                @elseif ($question['survey_question_type_id'] == 4)
                                    Grid Question
                                @elseif ($question['survey_question_type_id'] == 5)
                                    Priority Question
                                @elseif ($question['survey_question_type_id'] == 6)
                                    Open Ended Question
                                @else
                                    Action
                                @endif
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
