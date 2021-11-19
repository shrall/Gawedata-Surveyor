@extends('layouts.app')

@php
$assessment_type_id = $assessment['assessment_type_id'] ?? null;
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 text-start border-end" style="min-height: 90vh;">
                @include('assessment.inc.sidebar.draft_respondent')
            </div>
            @if (count($assessment['respondent_types']) > 0 || $new == 'true')
                <div class="col-7 my-4">
                    <h4 class="font-lato text-start ms-5">Buat Kategori</h4>
                    <div class="card card-survey-detail border-0 ms-4 p-4 font-lato">
                        @if ($assessment_type_id == 3)
                            <div id="sa-question" class="mb-3">
                                <h6 class="text-start row" id="sa-question-title">
                                    <div class="col-6">
                                        Kategori
                                    </div>
                                    <div class="col-3">
                                        Poin Minimal
                                    </div>
                                    <div class="col-3">
                                        Poin Maksimal
                                    </div>
                                </h6>
                                <div class="sa-answer-list">
                                    <div class="row mb-3">
                                        <div class="col-6 position-relative">
                                            <input type="text" name="answer" id="input-respondent-type-name"
                                                class="form-control input-text" placeholder="Tuliskan Jawaban Disini"
                                                value="{{ $assessment['respondent_types'][$i - 1]['name'] ?? '' }}"
                                                onkeyup="setRespondentTypeName();">
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="subtractPoints('min');">-</span>
                                                <input type="number" class="form-control input-text text-center"
                                                    value={{ $assessment['respondent_types'][$i - 1]['min_points'] ?? 0 }}
                                                    onkeyup="setPoints('min');" id="input-respondent-type-min-points">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="addPoints('min');">+</span>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="subtractPoints('max');">-</span>
                                                <input type="number" class="form-control input-text text-center"
                                                    value={{ $assessment['respondent_types'][$i - 1]['max_points'] ?? 100 }}
                                                    onkeyup="setPoints('max');" id="input-respondent-type-max-points">
                                                <span class="input-group-text assessment-point-buttons"
                                                    onclick="addPoints('max');">+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($assessment['with_discussion'])
                            <h6 class="text-start">Pembahasan</h6>
                            <div class="row">
                                <div class="col-12 position-relative">
                                    <textarea type="text" name="discussion" id="input-discussion"
                                        class="form-control input-text"
                                        style="resize: none; height:8rem;">{{ $assessment['respondent_types'][$i - 1]['discussion'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="text-start me-auto">
                                <button class="btn btn-gawedata-danger" @if ($new == 'true') disabled @endif
                                    onclick="event.preventDefault();
                                                                            document.getElementById('delete-respondent-form').submit();">
                                    <span class="fas fa-fw fa-trash-alt me-2"></span>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($new == 'false')
        <form action="{{ route('assessment.updaterespondenttype') }}" method="post" class="d-none"
            id="update-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="respondent_type_id"
                value="{{ $assessment['respondent_types'][$i - 1]['id'] ?? null }}">
            <input type="hidden" name="respondent_type_count" value={{ count($assessment['respondent_types']) }}>
            <input type="hidden" name="name" class="respondent-type-name"
                value="{{ $assessment['respondent_types'][$i - 1]['name'] ?? '' }}">
            <input type="hidden" name="new_bool" class="respondent-type-new-bool">
            <input type="hidden" name="change_tab_bool" class="respondent-type-change-tab-bool">
            <input type="hidden" name="next" class="respondent-type-next">
            <input type="hidden" name="min_points" class="respondent-type-min-points"
                value={{ $assessment['respondent_types'][$i - 1]['min_points'] ?? 0 }}>
            <input type="hidden" name="max_points" class="respondent-type-max-points"
                value={{ $assessment['respondent_types'][$i - 1]['max_points'] ?? 100 }}>
            <input type="hidden" name="discussion" class="respondent-type-discussion"
                value={{ $assessment['respondent_types'][$i - 1]['discussion'] ?? '' }}>
            <input type="hidden" name="submit_question" id="submit-question">
        </form>
        <form action="{{ route('assessment.deleterespondenttype') }}" method="post" class="d-none"
            id="delete-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="respondent_type_id"
                value="{{ $assessment['respondent_types'][$i - 1]['id'] ?? null }}">
            <input type="hidden" name="respondent_type_count" value={{ count($assessment['respondent_types']) }}>
        </form>
    @else
        <form action="{{ route('assessment.createrespondenttype') }}" method="post" class="d-none"
            id="create-respondent-form">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment['id'] }}">
            <input type="hidden" name="name" class="respondent-type-name">
            <input type="hidden" name="new_bool" class="respondent-type-new-bool">
            <input type="hidden" name="change_tab_bool" class="respondent-type-change-tab-bool">
            <input type="hidden" name="next" class="respondent-type-next">
            <input type="hidden" name="min_points" class="respondent-type-min-points" value=0>
            <input type="hidden" name="max_points" class="respondent-type-max-points" value=100>
            <input type="hidden" name="discussion" class="respondent-type-discussion" value="">
            <input type="hidden" name="submit_question" id="submit-question">
        </form>
    @endif
@endsection

@section('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var respondent_types = @json($assessment['respondent_types']);
        var respondent_type_index = @json($i - 1);
    </script>
    <script>
        $('#survey-setting-button').click(function() {
            console.log(questions)
        });
    </script>
    <script>
        function saveDraft(index, new_bool) {
            event.preventDefault();
            if (new_bool) {
                $('.respondent-type-new-bool').val(1)
            }
            $('.respondent-type-next').val(index)
            if ({{ $new }}) {
                document.getElementById('create-respondent-form').submit();
            } else {
                document.getElementById('update-respondent-form').submit();
            }
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
            var formData = new FormData();
            formData.append('image', $('#photo')[0].files[0]);
            $.ajax({
                url: "{{ config('services.api.url') }}" + "/image",
                type: 'POST',
                "mimeType": "multipart/form-data",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                headers: {
                    "Authorization": "Bearer {{ session('token') }}",
                },
                success: function(data) {
                    $('.survey-question-image-preview').attr('src', URL.createObjectURL(event.target.files[
                        0]));
                    questions[question_index]['image_path'] = @json(config('services.asset.url')) + '/' + JSON.parse(data)['data']['path']
                },
            }).fail(function(error) {
                console.log(error);
            });
        };
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @if ($assessment['with_discussion'])
        {{-- discussion --}}
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
                    if (respondent_types[respondent_type_index]['discussion']) {
                        editor.setData(respondent_types[respondent_type_index]['discussion']);
                    }
                    editor.model.document.on('change:data', () => {
                        $('.respondent-type-discussion').val(editor.getData());
                        console.log(editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endif
    <script>
        function setRespondentTypeName() {
            $('.respondent-type-name').val($('#input-respondent-type-name').val());
            console.log($('.respondent-type-name').val());
        }

        function setPoints(type) {
            $('.respondent-type-' + type + '-points').val($('#input-respondent-type-' + type + '-points').val());
            console.log($('.respondent-type-' + type + '-points').val());
        }

        function subtractPoints(type) {
            $('#input-respondent-type-' + type + '-points').val(parseInt($('#input-respondent-type-' + type + '-points')
                .val()) - 1);
            setPoints(type);
        }

        function addPoints(type) {
            $('#input-respondent-type-' + type + '-points').val(parseInt($('#input-respondent-type-' + type + '-points')
                .val()) + 1);
            setPoints(type);
        }
    </script>
    <script>
        function changeTab(type) {
            $('.respondent-type-change-tab-bool').val(1)
            saveDraft(1, false);
        }
    </script>
@endsection
