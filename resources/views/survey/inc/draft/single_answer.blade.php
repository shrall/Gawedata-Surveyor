@foreach ($answers as $answer)
    <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
        <div class="col-7 position-relative">
            <span class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
            <input type="text" name="answer{{ $loop->iteration }}" id="answer{{ $loop->iteration }}"
                class="form-control input-text" style="padding-left:3.5rem !important;"
                placeholder="Tuliskan Jawaban Disini" value="{{ $answer['text'] }}">
        </div>
        <div class="col-5 text-start d-flex align-items-center">
            <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                id="answer_delete{{ $loop->iteration }}" onclick="deleteAnswer({{ $loop->iteration }});"></span>
        </div>
    </div>
@endforeach
