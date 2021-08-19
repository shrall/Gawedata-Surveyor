@if (count($answers) > 0)
    @foreach ($answers as $answer)
        <div class="row mb-3" id="grid-answer{{ $loop->iteration }}">
            <div class="col-10 position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                <input type="text" name="answer{{ $loop->iteration }}" id="answer-grid{{ $loop->iteration }}"
                    class="form-control input-text" style="padding-left:3.5rem !important;"
                    placeholder="Tuliskan Jawaban Disini" value="{{ $answer }}"
                    onkeyup="setNewGridAnswer({{ $loop->iteration }});">
            </div>
            <div class="col-1 text-start d-flex align-items-center ps-0">
                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-4"
                    id="answer_delete{{ $loop->iteration }}"
                    onclick="deleteGridAnswer({{ $loop->iteration }});"></span>
            </div>
        </div>
    @endforeach
@else

@endif
