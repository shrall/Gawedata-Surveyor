@if (count($answers) > 0)
    @foreach ($answers as $key => $answer)
        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
            <div class="col-7 position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                <input type="text" name="answer{{ $loop->iteration }}" id="answer-single{{ $loop->iteration }}"
                    class="form-control input-text" onfocus="focusSkipMenu({{ $loop->iteration }});"
                    style="padding-left:3.5rem !important;" placeholder="Tuliskan Jawaban Disini"
                    value="{{ $answer['answer'] ?? '' }}"
                    onkeyup="setNewSingleAnswerSkipLogic({{ $loop->iteration }});">
                @if ($answer['next_question'] != '')
                    <span
                        class="position-absolute top-50 end-0 translate-middle-y font-weight-bold me-4 px-2 py-1 d-block skip-info-{{ $loop->iteration }}"
                        id="skip-info-{{ $key }}">Skip ke P{{ $answer['next_question'] + 1 }} Aktif</span>
                @else
                    <span
                        class="position-absolute top-50 end-0 translate-middle-y font-weight-bold me-4 px-2 py-1 d-none skip-info-{{ $loop->iteration }}"
                        id="skip-info-{{ $key }}">Skip ke P1 Aktif</span>
                @endif
            </div>
            <div class="col-5 text-start d-flex align-items-center">
                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                    id="answer_delete{{ $loop->iteration }}"
                    onclick="deleteSingleAnswer({{ $loop->iteration }});"></span>
            </div>
            @if ($answer['next_question'] != '')
                <div id="input-skip-container-{{ $loop->iteration }}"
                    class="col-12 mt-1 mb-2 d-none input-skip-container">
                    <div class="d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-skip" onchange="triggerSkipCheckbox({{ $loop->iteration }});" type="checkbox" value=""
                                data-id="{{ $loop->iteration }}" id="input-skip-{{ $loop->iteration }}" checked>
                            <label class="form-check-label" for="input-skip-{{ $loop->iteration }}">
                                Skip ke pertanyaan tertentu jika memilih jawaban ini
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <div id="input-skip-container-{{ $loop->iteration }}"
                    class="col-12 mt-1 mb-2 d-none input-skip-container">
                    <div class="d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-skip" onchange="triggerSkipCheckbox({{ $loop->iteration }});" type="checkbox" value=""
                                data-id="{{ $loop->iteration }}" id="input-skip-{{ $loop->iteration }}">
                            <label class="form-check-label" for="input-skip-{{ $loop->iteration }}">
                                Skip ke pertanyaan tertentu jika memilih jawaban ini
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="input-skip-dropdown-container col-7 mt-1 d-none"
                id="input-skip-dropdown-container-{{ $loop->iteration }}">
                <div class="d-flex align-items-center">
                    <label class="form-check-label font-weight-bold me-2" style="width: 100px;">
                        Lompat ke
                    </label>
                    <div class="dropdown w-100 position-relative" id="select-survey-skip-{{ $loop->iteration }}">
                        @if ($answer['next_question'] != '')
                            <span class="form-control input-text d-flex align-items-center"
                                style="padding-left: 4rem !important;" type="button" data-bs-toggle="dropdown"
                                id="selected-survey-skip-{{ $key }}">
                                {{ strlen($questions[$answer['next_question']]['question']) > 25 ? substr($questions[$answer['next_question']]['question'], 0, 23) . '...' : $questions[$answer['next_question']]['question'] }}
                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                            </span>
                            <span
                                class="badge-pertanyaan position-absolute top-50 translate-middle-y font-weight-bold p-2"
                                id="skip-badge-{{ $key }}"
                                style="color: #3f60f5 !important; left:1rem;">P{{ $answer['next_question'] + 1 }}</span>
                        @else
                            <span class="form-control input-text d-flex align-items-center"
                                style="padding-left: 4rem !important;" type="button" data-bs-toggle="dropdown"
                                id="selected-survey-skip-{{ $key }}">
                                {{ strlen($questions[0]['question']) > 25 ? substr($questions[0]['question'], 0, 23) . '...' : $questions[0]['question'] }}
                                <span class="fa fa-fw fa-chevron-down ms-auto"></span>
                            </span>
                            <span
                                class="badge-pertanyaan position-absolute top-50 translate-middle-y font-weight-bold p-2"
                                id="skip-badge-{{ $key }}"
                                style="color: #3f60f5 !important; left:1rem;">P1</span>
                        @endif
                        <ul class="dropdown-menu w-100 px-2">
                            <div class="overflow-auto px-1" style="min-height:0;max-height: 30vh;">
                                @foreach ($questions as $question)
                                    <li class="dropdown-item cursor-pointer"
                                        onclick="changeSkipDropdown({{ $loop->iteration }}, {{ $key }}, {{ $question['id'] }});">
                                        P{{ $loop->iteration }} |
                                        {{ strlen($question['question']) > 25 ? substr($question['question'], 0, 23) . '...' : $question['question'] }}
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else

@endif
