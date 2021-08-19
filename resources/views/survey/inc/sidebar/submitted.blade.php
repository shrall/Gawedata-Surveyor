<ul class="list-unstyled my-4">
    <li class="my-4">
        <div class="card card-submitted mx-3 p-4">
            <h5 class="font-lato font-weight-bold mb-4">Surveimu Sudah Tersubmit 🎉</h5>
            <span class="text-gray">Tim gawedata sedang mereview surveimu dalam waktu 1x24 Jam</span>
        </div>
    </li>
    <div id="survey-detail-sidebar" class="mx-3">
        <h4 class="font-lato ms-3">Pertanyaan</h4>
        @foreach ($survey['questions'] as $question)
            <a href="{{route('survey.submitted', ['id' => $survey['id'], 'i' => $loop->iteration])}}" class="text-decoration-none">
                <li class="font-lato my-4 pe-4 py-3 @if ($loop->iteration == $i) active @endif position-relative" style="padding-left: 4rem !important;">
                    <div class="active-border position-absolute py-1 start-0 translate-middle-y d-inline @if ($loop->iteration != $i) invisible @endif" style="top: 2.25rem;"> 
                    </div>
                    <span class="badge-pertanyaan position-absolute font-weight-bold p-2" style="color: #3f60f5 !important; left:1rem;">P{{ $loop->iteration }}</span>
                    <span class="text-start text-gray text-decoration-none fs-6" style="color: #000 !important;">{{ $question['question'] }}</span>
                </li>
            </a>
        @endforeach
    </div>
</ul>
