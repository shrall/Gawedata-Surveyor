<ul class="list-unstyled my-4">
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        <div id="add-question-button" class="fas fa-plus-circle text-gawedata fs-2 me-3 cursor-pointer"onclick="event.preventDefault();
        document.getElementById('add-question-form').submit();"></div>
        <form id="add-question-form" action="{{ route('survey.addquestion', $survey['id']) }}" method="POST"
            style="display: none;">
            @csrf
        </form>
    </div>
    <div id="survey-detail-sidebar" class="mx-3">
        @foreach ($survey['questions'] as $question)
            <a href="{{route('survey.show', ['id' => $survey['id'], 'i' => $loop->iteration])}}" class="text-decoration-none">
                <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative">
                    <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if ($loop->iteration != $i) invisible @endif"> 
                    </div>
                    <span class="badge-pertanyaan font-weight-bold ms-4 p-2" style="color: #3f60f5 !important;">P{{ $loop->iteration }}</span>
                    <span class="text-gray text-decoration-none ms-4 fs-6" style="color: #000 !important;">
                        {{ $question['question'] }}
                    </span>
                </li>
            </a>
        @endforeach
    </div>
</ul>