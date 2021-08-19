@if (count($questions) > 0)
    @foreach ($questions as $question)
        <div class="row mb-3" id="grid-question{{ $loop->iteration }}">
            <div class="col-10 position-relative">
                <span class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                    id="question-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                <input type="text" name="question{{ $loop->iteration }}" id="question{{ $loop->iteration }}"
                    class="form-control input-text" style="padding-left:3.5rem !important;"
                    placeholder="Tuliskan Jawaban Disini" value="{{ $question['question'] }}"
                    onkeyup="setNewGridQuestion({{ $loop->iteration }});">
            </div>
            <div class="col-1 text-start d-flex align-items-center ps-0">
                <label for="question_image{{ $loop->iteration }}" class="font-lato cursor-pointer"><span
                        class="fas fa-fw fa-image text-gray cursor-pointer fs-4"></span></label>
                <input type="file" name="photo_grid" id="question_image{{ $loop->iteration }}" class="d-none"
                    accept="image/*" onchange="gridLoadFile(event,{{ $loop->iteration }})">

            </div>
            <div class="col-1 text-start d-flex align-items-center ps-0">
                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-4"
                    id="question_delete{{ $loop->iteration }}"
                    onclick="deleteGridQuestion({{ $loop->iteration }});"></span>
            </div>
        </div>
    @endforeach
@else
@endif
