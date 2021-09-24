@if (count($answers) > 0)
    @foreach ($answers as $key => $answer)
        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
            <div class="col-1 text-start d-flex align-items-center">
                @if ($answer['is_right_answer'] == 'true')
                    <span class="fas fa-fw fa-check-circle text-gawedata cursor-pointer fs-3 assessment-correct-radio"
                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                        id="answer-radio-{{ $loop->iteration }}"></span>
                @else
                    <span class="far fa-fw fa-circle text-gray cursor-pointer fs-3 assessment-correct-radio"
                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                        id="answer-radio-{{ $loop->iteration }}"></span>
                @endif
            </div>
            <div class="col-7 position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                <input type="text" name="answer{{ $loop->iteration }}" id="answer-{{ $loop->iteration }}"
                    class="form-control input-text" style="padding-left:3.5rem !important;"
                    placeholder="Tuliskan Jawaban Disini" value="{{ $answer['text'] ?? '' }}"
                    onkeyup="setNewAnswer({{ $loop->iteration }});">
            </div>
            <div class="col-3">
                <div class="input-group">
                    <span class="input-group-text assessment-point-buttons"
                        onclick="subtractPoints({{ $loop->iteration }});">-</span>
                    <input type="text" class="form-control input-text text-center" value={{ $answer['points'] }}
                        onkeyup="setAnswerPoints({{ $loop->iteration }});"
                        id="answer-points-{{ $loop->iteration }}">
                    <span class="input-group-text assessment-point-buttons"
                        onclick="addPoints({{ $loop->iteration }});">+</span>
                </div>
            </div>
            <div class="col-1 text-start d-flex align-items-center">
                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                    id="answer_delete{{ $loop->iteration }}"
                    onclick="deleteAnswer({{ $loop->iteration }});"></span>
            </div>
        </div>
    @endforeach
@else

@endif
