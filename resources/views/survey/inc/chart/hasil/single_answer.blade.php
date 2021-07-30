<div class="row">
    <div class="text-start">
        <h4 class="font-weight-bold">{{$loop->iteration}}. {{$question['question']}}</h4>
        <h6 class="text-gray">{{$question['question_type']['name']}} - 100 Jawaban</h6>
    </div>
    <div class="row">
        <div class="col-6">
            <div id="chart-{{$loop->iteration}}"></div>
        </div>
        <div class="col-6 d-flex align-items-center" style="overflow: auto; white-space: nowrap;">
            <div class="d-flex flex-row">
                <div class="col-12 d-flex flex-column h-100 justify-content-start">
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($question['answer_choices'] as $answer)
                    <div class="row my-2 justify-content-start">
                        <div class="col-12 text-start">
                            <span class="fa fa-fw fa-circle me-2 fs-6"
                            @if ($counter == 1)
                            style="color:#3F60F5;"
                            @elseif ($counter == 2)
                            style="color:#46cb5a;"
                            @elseif ($counter == 3)
                            style="color:#b0744a;"
                            @elseif ($counter == 4)
                            style="color:#d5c64b;"
                            @elseif ($counter == 5)
                            style="color:#6bd5cf;"
                            @elseif ($counter == 6)
                            style="color:#d56bcb;"
                            @php
                                $counter = 1;
                            @endphp
                            @endif
                            @php
                                $counter += 1;
                            @endphp
                            ></span>{{$answer['text']}}: 75%
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
