@if (count($surveys['data']) > 0)
    <div class="@if (isset($view) && $view == 'card') d-block @elseif(isset($view) && $view == 'list') d-none @else d-block @endif"
        id="survey-view-grid">
        <div class="row gy-4 mb-4" id="survey-view-grid-box">
            @foreach ($surveys['data'] as $survey)
                @include('inc.modal.survey.rejected_grid')
                <a @if ($survey['status_id'] == 3) onclick="$('#reject-grid-modal-'+{{ $survey['id'] }}).modal('show');" @else href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}" @endif
                    class="col-3 text-decoration-none" title="{{ $survey['title'] }}">
                    <div class="card card-survey-grid px-1 py-3 text-gray">
                        <div class="card-header d-flex align-items-center">
                            @if ($survey['status_id'] == 4)
                                <div>
                                    <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                </div>
                            @elseif ($survey['status_id'] == 5)
                                <div class="text-gawedata">
                                    <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                </div>
                            @elseif ($survey['status_id'] == 6)
                                <div class="text-green">
                                    <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                </div>
                            @elseif ($survey['status_id'] == 7)
                                <div class="text-finished">
                                    <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                </div>
                            @elseif ($survey['status_id'] == 8)
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                </div>
                            @elseif ($survey['status_id'] == 3)
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Rejected
                                </div>
                            @endif
                            @if ($survey['survey_type_id'] == 1)
                                <div class="ms-auto flex align-items-center" style="font-size: 0.85em;">
                                    {{ date('d-m-y', strtotime($survey['daily_date'])) }},
                                    {{ date('H:i', strtotime($survey['start_time'])) }}
                                    - {{ date('H:i', strtotime($survey['end_time'])) }}
                                    WIB</div>
                            @else
                                <div class="ms-auto">{{ date('d-m-y, H:i', strtotime($survey['created_at'])) }}
                                    WIB</div>
                            @endif
                        </div>
                        <div class="card-body mt-4 pb-0">
                            <h5 class="font-weight-bold text-dark">
                                {{ strlen($survey['title']) > 25 ? substr($survey['title'], 0, 20) . '...' : $survey['title'] }}
                            </h5>
                        </div>
                        <div class="card-footer pt-0">
                            <span class="fa fa-fw fa-users me-2"></span>
                            {{ $survey['respondents_answered_question_count'] }}/{{ $survey['respondent_quota'] }}
                            Responden
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="@if (isset($view) && $view == 'list') d-block @elseif(isset($view) && $view == 'card') d-none @else d-none @endif"
        id="survey-view-list">
        <table class="table table-borderless table-hover">
            <thead>
                <tr class="text-gray">
                    <th class="font-weight-regular" scope="col" width="45%">Nama Survei</th>
                    <th class="font-weight-regular" scope="col">Status</th>
                    <th class="font-weight-regular" scope="col">Jenis</th>
                    @if ($survey['survey_type_id'] == 1)
                        <th class="font-weight-regular" scope="col">Waktu Survei</th>
                    @endif
                    <th class="font-weight-regular" scope="col">Jumlah Responden</th>
                    <th class="font-weight-regular" scope="col">Last Update</th>
                </tr>
            </thead>
            <tbody class="text-gray" id="survey-view-list-box">
                @foreach ($surveys['data'] as $survey)
                    @include('inc.modal.survey.rejected_list')
                    <tr class="survey-row cursor-pointer @if ($loop->iteration > 1) border-top @endif"
                        data-href="{{ route('survey.show', ['id' => $survey['id'], 'i' => 1, 'new' => 'false']) }}"
                        data-status={{$survey['status_id']}} data-id={{ $survey['id'] }}>
                        <th class="py-4 text-dark fs-5" scope="row">
                            {{ strlen($survey['title']) > 25 ? substr($survey['title'], 0, 33) . '...' : $survey['title'] }}
                        </th>
                        @if ($survey['status_id'] == 4)
                            <td class="py-4">
                                <div>
                                    <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                </div>
                            </td>
                        @elseif ($survey['status_id'] == 5)
                            <td class="py-4">
                                <div class="text-gawedata">
                                    <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                </div>
                            </td>
                        @elseif ($survey['status_id'] == 6)
                            <td class="py-4">
                                <div class="text-green">
                                    <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                </div>
                            </td>
                        @elseif ($survey['status_id'] == 7)
                            <td class="py-4">
                                <div class="text-finished">
                                    <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                </div>
                            </td>
                        @elseif ($survey['status_id'] == 8)
                            <td class="py-4">
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                </div>
                            </td>
                        @elseif ($survey['status_id'] == 3)
                            <td class="py-4">
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Rejected
                                </div>
                            </td>
                        @else
                            <td class="py-4"></td>
                        @endif
                        @if ($survey['is_private'])
                            <td class="py-4">
                                <div class="text-gray">
                                    <span class="fa fa-fw fa-lock me-2"></span>Private
                                </div>
                            </td>
                        @else
                            <td class="py-4">
                                <div class="text-gawedata">
                                    <span class="fa fa-fw fa-globe me-2"></span>Public
                                </div>
                            </td>
                        @endif
                        @if ($survey['survey_type_id'] == 1)
                            <td class="py-4">
                                <div class="text-gray">
                                    <span
                                        class="fa fa-fw fa-clock me-2"></span>{{ date('H:i', strtotime($survey['start_time'])) }}
                                    - {{ date('H:i', strtotime($survey['end_time'])) }} WIB
                                </div>
                            </td>
                        @endif
                        <td class="py-4"><span class="fa fa-fw fa-users me-2"></span>
                            {{ $survey['respondents_answered_question_count'] }}/{{ $survey['respondent_quota'] }}
                            Responden</td>
                        <td class="py-4">{{ date('d-m-y, H:i', strtotime($survey['updated_at'])) }} WIB
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="row justify-content-center" id="survey-view-empty">
        <div class="col-4 text-center font-nexa my-5 pt-5">
            <img src="{{ asset('images/survey-empty.png') }}" alt="" srcset="">
            <h5>Yuk, mulai buat survey</h5>
        </div>
    </div>
@endif
@if ($surveys['total'] > 0)
    <nav id="survey-pagination">
        <ul class="pagination justify-content-center">
            @foreach ($surveys['links'] as $page)
                <li
                    class="cursor-pointer page-item @if (!$page['url']) disabled @endif @if ($page['active']) active @endif">
                    @if ($loop->iteration == 1)
                        <a onclick="changePage({{ $surveys['current_page'] - 1 }});" class="page-link">
                            Previous
                        </a>
                    @elseif ($loop->iteration == count($surveys['links']))
                        <a onclick="changePage({{ $surveys['current_page'] + 1 }});" class="page-link">
                            Next
                        </a>
                    @else
                        <a onclick="changePage({{ $page['label'] }});" class="page-link">
                            {{ $page['label'] }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
@endif

<script>
    $(".survey-row").click(function() {
        window.location = $(this).data("href");
    });
</script>
