<ul class="list-unstyled my-4">
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        <div id="add-question-button" class="fas fa-plus-circle text-gawedata fs-2 me-3 cursor-pointer" onclick="saveDraft({{$i}}, true);"></div>
    </div>
    <div id="survey-detail-sidebar" class="mx-3">
        @foreach ($survey['questions'] as $question)
            <a href="#" class="text-decoration-none cursor-pointer" onclick="saveDraft({{$loop->iteration}}, false);">
                <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                    <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if ($loop->iteration != $i) invisible @endif"> 
                    </div>
                    <span class="badge-pertanyaan font-weight-bold ms-4 p-2" style="color: #3f60f5 !important;">P{{ $loop->iteration }}</span>
                    <span class="sidebar-question text-gray text-decoration-none ms-4 fs-6" style="color: #000 !important;">
                        {{ (strlen($question['question']) > 25) ? substr($question['question'],0,23).'...' : $question['question'] }}
                    </span>
                </li>
            </a>
        @endforeach
    </div>
</ul>
