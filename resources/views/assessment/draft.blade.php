@extends('layouts.app')

@php
$assessment_type_id = $assessment['assessment_type_id'] ?? null;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end" style="min-height: 90vh;">
                @include('assessment.inc.sidebar.draft')
            </div>
            <div class="col-7 text-center my-4">
                @if (count($assessment['questions']) > 0)
                    <h4 class="font-lato text-start ms-5">Buat Pertanyaan</h4>
                    <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                        <h6 class="text-start">Pertanyaan</h6>
                        <div class="row">
                            <div class="col-12 position-relative">
                                <span
                                    class="badge-pertanyaan position-absolute start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                    style="color: #3f60f5 !important; top:1.75rem;">P{{ $i }}</span>
                                <textarea type="text" name="question" id="input-question" class="form-control input-text"
                                    style="padding-left:3.5rem !important;resize: none; height:8rem;"
                                    placeholder="Tuliskan Pertanyaan Disini"
                                    onkeyup="setQuestion()">{{ $assessment['questions'][$i - 1]['question'] }}</textarea>
                            </div>
                        </div>
                        @if ($assessment_type_id == 1)
                            <div id="irt-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100 my-2">
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start" id="irt-question-title">Jawaban <span
                                        class="font-weight-bold">(Pilih
                                        satu yang benar)</span></h6>
                                <div class="irt-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-1 text-start d-flex align-items-center">
                                                @if ($answer['is_right_answer'])
                                                    <span
                                                        class="fas fa-fw fa-check-circle text-gawedata cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @else
                                                    <span
                                                        class="far fa-fw fa-circle text-gray cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @endif
                                            </div>
                                            <div class="col-10 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] ?? '' }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-1 text-start d-flex align-items-center">
                                                <span class="fas fa-fw fa-trash-alt text-gray cursor-pointer fs-3"
                                                    id="answer_delete{{ $loop->iteration }}"
                                                    onclick="deleteAnswer({{ $loop->iteration }});"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment_type_id == 2)
                            <div id="rs-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100 my-2">
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start row" id="rs-question-title">
                                    <div class="col-8">
                                        Jawaban <span class="font-weight-bold">(Pilih satu yang benar)</span>
                                    </div>
                                    <div class="col-4">
                                        Poin <span class="text-gray">(Positif (+) atau negatif (-))</span>
                                    </div>
                                </h6>
                                <div class="rs-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-1 text-start d-flex align-items-center">
                                                @if ($answer['is_right_answer'])
                                                    <span
                                                        class="fas fa-fw fa-check-circle text-gawedata cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @else
                                                    <span
                                                        class="far fa-fw fa-circle text-gray cursor-pointer fs-3 assessment-correct-radio"
                                                        onclick="changeCorrectAnswer({{ $loop->iteration }});"
                                                        id="answer-radio-{{ $loop->iteration }}"></span>
                                                @endif
                                            </div>
                                            <div class="col-7 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] ?? '' }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-3">
                                                <div class="input-group">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="subtractPoints({{ $loop->iteration }});">-</span>
                                                    <input type="text" class="form-control input-text text-center"
                                                        value={{ $answer['points'] }}
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
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment_type_id == 3)
                            <div id="sa-question" class="mb-3">
                                <div class="row">
                                    <div class="col-7">
                                        <img src="{{ $assessment['questions'][$i - 1]['image_path'] }}"
                                            class="survey-question-image-preview w-100 my-2">
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                                <h6 class="text-start row" id="sa-question-title">
                                    <div class="col-8">
                                        Jawaban
                                    </div>
                                    <div class="col-4">
                                        Poin <span class="text-gray">(Positif (+) atau negatif (-))</span>
                                    </div>
                                </h6>
                                <div class="sa-answer-list">
                                    @foreach ($assessment['questions'][$i - 1]['answer_choices'] as $key => $answer)
                                        <div class="row mb-3" id="question-answer{{ $loop->iteration }}">
                                            <div class="col-8 position-relative">
                                                <span
                                                    class="position-absolute top-50 start-0 translate-middle-y font-weight-bold ms-4 px-2 py-1"
                                                    id="answer-order{{ $loop->iteration }}">{{ $loop->iteration }}.</span>
                                                <input type="text" name="answer{{ $loop->iteration }}"
                                                    id="answer-{{ $loop->iteration }}" class="form-control input-text"
                                                    style="padding-left:3.5rem !important;"
                                                    placeholder="Tuliskan Jawaban Disini"
                                                    value="{{ $answer['text'] ?? '' }}"
                                                    onkeyup="setNewAnswer({{ $loop->iteration }});">
                                            </div>
                                            <div class="col-3">
                                                <div class="input-group">
                                                    <span class="input-group-text assessment-point-buttons"
                                                        onclick="subtractPoints({{ $loop->iteration }});">-</span>
                                                    <input type="text" class="form-control input-text text-center"
                                                        value={{ $answer['points'] }}
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
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-gawedata-2 font-lato w-100 py-2" onclick="addAnswer();">
                                            + Tambah Jawaban
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h6 class="text-start">Pembahasan</h6>
                        <div class="row">
                            <div class="col-12 position-relative">
                                <textarea type="text" name="discussion" id="input-discussion"
                                    class="form-control input-text"
                                    style="resize: none; height:8rem;">{{ $assessment['questions'][$i - 1]['discussion'] }}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="text-start me-auto">
                                <button class="btn btn-gawedata-danger" onclick="deleteQuestion({{ $i }});">
                                    <span class="fas fa-fw fa-trash-alt me-2"></span>Hapus
                                </button>
                            </div>
                            <div class="text-end me-2">
                                <button class="btn btn-gawedata-3" onclick="copyQuestion({{ $i }});">
                                    <label class="font-lato cursor-pointer">
                                        <span class="fas fa-fw fa-copy me-2"></span>Duplikat
                                    </label>
                                </button>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-gawedata-3">
                                    <label for="photo" class="font-lato cursor-pointer"><span
                                            class="fas fa-fw fa-image me-2"></span>Gambar</label>
                                    <input type="file" name="photo" id="photo" class="d-none" accept="image/*"
                                        onchange="loadFile(event)">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <form action="{{ route('assessment.update', $assessment['id']) }}" method="post" class="d-none"
        id="question-form">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <input type="text" name="questions" id="input-questions">
        <input type="text" name="question_index" id="input-question-index">
        <input type="text" name="new_question" id="new-question">
        <input type="text" name="submit_question" id="submit-question">
    </form>
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var questions = @json($assessment['questions']);
        var question_index = @json($i - 1);
    </script>
    <script>
        $('#survey-setting-button').click(function() {
            console.log(questions)
        });
    </script>
    <script>
        function getQuestionIndex(next_question_id) {
            var the_index = "";
            questions.forEach(function(question, index) {
                if (question['id'] == next_question_id) {
                    the_index = index;
                }
            })
            return the_index;
        }
    </script>
    <script>
        // main question
        function setQuestion() {
            questions[question_index]['question'] = $('#input-question').val();
        }
    </script>
    <script>
        // irt answer
        function addAnswer() {
            questions[question_index]['answer_choices'].push({
                "text": "Jawaban Baru",
                "points": 0,
                "is_right_answer": false
            });
            questions[question_index]['answer_choices'][questions[question_index]['answer_choices'].length - 1]['text'] =
                "";
            if ({{ $assessment_type_id }} == 1) {
                refreshIRTAnswer();
            } else if ({{ $assessment_type_id }} == 2) {
                refreshRSAnswer();
            } else if ({{ $assessment_type_id }} == 3) {
                refreshSAAnswer();
            }
        }

        function deleteAnswer(int) {
            questions[question_index]['answer_choices'].splice(int - 1, 1);
            if (questions[question_index]['answer_choices'].length > 0) {
                if ({{ $assessment_type_id }} == 1) {
                    refreshIRTAnswer();
                } else if ({{ $assessment_type_id }} == 2) {
                    refreshRSAnswer();
                } else if ({{ $assessment_type_id }} == 3) {
                    refreshSAAnswer();
                }
            } else {
                $('#question-answer' + int).remove();
            }
        }

        function refreshIRTAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshirtanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".irt-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshRSAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshrsanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".rs-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function refreshSAAnswer() {
            $.post("{{ config('app.url') }}" + "/assessment/refreshsaanswer", {
                    _token: CSRF_TOKEN,
                    answers: questions[question_index]['answer_choices']
                })
                .done(function(data) {
                    $(".sa-answer-list").html(data)
                })
                .fail(function(e) {
                    console.log(e);
                });
        }

        function setNewAnswer(index) {
            questions[question_index]['answer_choices'][index - 1]['text'] = $('#answer-' + index).val();
        }
    </script>
    <script>
        function saveDraft(index, new_bool) {
            event.preventDefault();
            if (new_bool) {
                $('#new-question').val(1);
            }
            $('#input-questions').val(JSON.stringify(questions));
            $('#input-question-index').val(index);
            document.getElementById('question-form').submit();
        }
    </script>
    <script>
        function deleteQuestion(index) {
            questions.splice(index - 1, 1);
            if (index == 1) {
                saveDraft(index, false);
            } else {
                saveDraft(index - 1, false);
            }
        }
    </script>
    <script>
        function copyQuestion(index) {
            var copied_question = questions[index - 1];
            questions.push(copied_question);
            saveDraft(questions.length, false);
        }
    </script>
    <script>
        function submitSurvey() {
            $('#submit-question').val(1);
            $('#submit-modal-content').removeClass('d-block').addClass('d-none');
            $('#submitted-modal-content').removeClass('d-none').addClass('d-block');
        }
    </script>
    <script>
        var loadFile = function(event) {
            $('.survey-question-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            var formData = new FormData();
            formData.append('_token', CSRF_TOKEN);
            formData.append('photo', $('#photo')[0].files[0]);
            $.ajax({
                url: "{{ config('app.url') }}" + "/assessment/" + @json($assessment['id']) + "/uploadphoto",
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    questions[question_index]['image_path'] = @json(asset('/uploads/images/')) + '/' + data
                },
            }).fail(function(error) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
            });
        };
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!-- Latest Sortable -->
    <script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
    <script>
        Sortable.create(simpleList, {
            handle: '.drag-handle',
            animation: 150,
            direction: 'vertical',
            onEnd: function(evt) {
                var element = questions[evt.oldIndex];
                questions.splice(evt.oldIndex, 1);
                questions.splice(evt.newIndex, 0, element);
                $('#save-draft-button').attr("onclick", "saveDraft(" + (evt.newIndex + 1) + ", false);");
                reorder_question_link();
            },
        });
    </script>
    <script>
        function reorder_question_link() {
            $(".survey-question-card").each(function(index) {
                $(this).attr("onclick", "saveDraft(" + (index + 1) + ", false);");
            });
        };
    </script>
    <script>
        function changeCorrectAnswer(order) {
            $('.assessment-correct-radio').removeClass('fas').removeClass('fa-check-circle').removeClass('text-gawedata');
            $('.assessment-correct-radio').addClass('far').addClass('fa-circle').addClass('text-gray');
            $('#answer-radio-' + order).removeClass('far').removeClass('fa-circle').removeClass('text-gray');
            $('#answer-radio-' + order).addClass('fas').addClass('fa-check-circle').addClass('text-gawedata');
            questions[question_index]['answer_choices'].forEach(element => {
                element.is_right_answer = false;
            });
            questions[question_index]['answer_choices'][order - 1]['is_right_answer'] = true;
        }
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                // The file loader instance to use during the upload. It sounds scary but do not
                // worry — the loader will be passed into the adapter later on in this guide.
                this.loader = loader;
            }
            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }
            // Aborts the upload process.
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }
            // Initializes the XMLHttpRequest object using the URL passed to the constructor.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open('POST', '{{ route('assessment.uploadphotodiscussion') }}', true);
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }
            // Initializes XMLHttpRequest listeners.
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }
                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve({
                        default: response.url
                    });
                });
                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }
            // Prepares the data and sends the request.
            _sendRequest(file) {
                // Prepare the form data.
                const data = new FormData();
                data.append('upload', file);
                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.
                // Send the request.
                this.xhr.send(data);
            }
            // ...
        }

        function SimpleUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };
        }
        ClassicEditor
            .create(document.querySelector('#input-discussion'), {
                extraPlugins: [SimpleUploadAdapterPlugin],
            })
            .then(editor => {
                console.log(editor);
                editor.setData(questions[question_index]['discussion']);
                editor.model.document.on('change:data', () => {
                    questions[question_index]['discussion'] = editor.getData();
                    console.log(editor.getData());
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function setAnswerPoints(index) {
            questions[question_index]['answer_choices'][index - 1]['points'] = $('#answer-points-' + index).val();
        }
    </script>
    <script>
        function addPoints(order) {
            $('#answer-points-' + order).val(parseInt($('#answer-points-' + order).val()) + 1);
            setAnswerPoints(order);
        }

        function subtractPoints(order) {
            $('#answer-points-' + order).val(parseInt($('#answer-points-' + order).val()) - 1);
            setAnswerPoints(order);
        }
    </script>
    <script>
        // function changeTab(type) {
        //     $('.tab-type').removeClass('tab-gawedata-active').addClass('tab-gawedata');
        //     $('#tab-' + type).removeClass('tab-gawedata').addClass('tab-gawedata-active');
        // }
    </script>
@endsection