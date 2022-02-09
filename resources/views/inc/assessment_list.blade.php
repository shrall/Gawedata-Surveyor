@if (count($assessments['data']) > 0)
    <div class="@if (isset($view) && $view == 'card') d-block @elseif(isset($view) && $view == 'list') d-none @else d-block @endif" id="survey-view-grid">
        <div class="row gy-4 mb-4" id="survey-view-grid-box">
            @foreach ($assessments['data'] as $assessment)
                <a href="{{ route('assessment.show', ['id' => $assessment['id'], 'i' => 1, 'new' => 'false']) }}"
                    class="col-3 text-decoration-none" title="{{$assessment['title']}}">
                    <div class="card card-survey-grid px-1 py-3 text-gray">
                        <div class="card-header d-flex align-items-center">
                            @if ($assessment['status_id'] == 4)
                                <div>
                                    <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                </div>
                            @elseif ($assessment['status_id'] == 5)
                                <div class="text-gawedata">
                                    <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                </div>
                            @elseif ($assessment['status_id'] == 6 || $assessment['status_id'] == 9)
                                <div class="text-green">
                                    <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                </div>
                            @elseif ($assessment['status_id'] == 7)
                                <div class="text-finished">
                                    <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                </div>
                            @elseif ($assessment['status_id'] == 8)
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                </div>
                            @endif
                            <div class="ms-auto">{{ date('d-m-y, H:i', strtotime($assessment['created_at'])) }}
                                WIB</div>
                        </div>
                        <div class="card-body mt-4 pb-0">
                            <h5 class="font-weight-bold text-dark">
                                {{ strlen($assessment['title']) > 25 ? substr($assessment['title'], 0, 20) . '...' : $assessment['title'] }}
                            </h5>
                        </div>
                        <div class="card-footer pt-0">
                            @if ($assessment['assessment_type_id'] == 1)
                                <span class="px-2 py-1 assessment-status-irt font-nexa">IRT</span>
                            @elseif ($assessment['assessment_type_id'] == 2)
                                <span class="px-2 py-1 assessment-status-rs font-nexa">Regular Scoring</span>
                            @elseif ($assessment['assessment_type_id'] == 3)
                                <span class="px-2 py-1 assessment-status-sa font-nexa">Self-Assessment</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="@if (isset($view) && $view == 'list') d-block @elseif(isset($view) && $view == 'card') d-none @else d-none @endif" id="survey-view-list">
        <table class="table table-borderless table-hover">
            <thead>
                <tr class="text-gray">
                    <th class="font-weight-regular" scope="col" width="45%">Nama Survei</th>
                    <th class="font-weight-regular" scope="col">Status</th>
                    <th class="font-weight-regular" scope="col">Tipe Tes</th>
                    <th class="font-weight-regular" scope="col">Tanggal Publish</th>
                    <th class="font-weight-regular" scope="col">Last Update</th>
                </tr>
            </thead>
            <tbody class="text-gray" id="survey-view-list-box">
                @foreach ($assessments['data'] as $assessment)
                    <tr class="survey-row cursor-pointer @if ($loop->iteration > 1) border-top @endif"
                        data-href="{{ route('assessment.show', ['id' => $assessment['id'], 'i' => 1, 'new' => 'false']) }}">
                        <th class="py-4 text-dark fs-5" scope="row">
                            {{ strlen($assessment['title']) > 25 ? substr($assessment['title'], 0, 33) . '...' : $assessment['title'] }}
                        </th>
                        @if ($assessment['status_id'] == 4)
                            <td class="py-4">
                                <div>
                                    <span class="fa fa-fw fa-circle text-yellow me-2"></span>Draft
                                </div>
                            </td>
                        @elseif ($assessment['status_id'] == 5)
                            <td class="py-4">
                                <div class="text-gawedata">
                                    <span class="fa fa-fw fa-circle text-gawedata me-2"></span>Submitted
                                </div>
                            </td>
                        @elseif ($assessment['status_id'] == 6 || $assessment['status_id'] == 9)
                            <td class="py-4">
                                <div class="text-green">
                                    <span class="fa fa-fw fa-circle text-green me-2"></span>Published
                                </div>
                            </td>
                        @elseif ($assessment['status_id'] == 7)
                            <td class="py-4">
                                <div class="text-finished">
                                    <span class="fa fa-fw fa-circle text-finished me-2"></span>Finished
                                </div>
                            </td>
                        @elseif ($assessment['status_id'] == 8)
                            <td class="py-4">
                                <div class="text-red">
                                    <span class="fa fa-fw fa-circle text-red me-2"></span>Stopped
                                </div>
                            </td>
                        @else
                            <td class="py-4"></td>
                        @endif
                        @if ($assessment['assessment_type_id'] == 1)
                            <td class="py-4">
                                <span class="px-2 py-1 assessment-status-irt font-nexa">IRT</span>
                            </td>
                        @elseif ($assessment['assessment_type_id'] == 2)
                            <td class="py-4">
                                <span class="px-2 py-1 assessment-status-rs font-nexa">Regular Scoring</span>
                            </td>
                        @elseif ($assessment['assessment_type_id'] == 3)
                            <td class="py-4">
                                <span class="px-2 py-1 assessment-status-sa font-nexa">Self-Assessment</span>
                            </td>
                        @endif
                        <td class="py-4">
                            <span class="fa fa-fw fa-calendar-day me-2"></span>
                            {{ date('d/m/y', strtotime($assessment['test_date'])) }}
                        </td>
                        <td class="py-4">{{ date('d-m-y, H:i', strtotime($assessment['updated_at'])) }} WIB
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
            <h5>Yuk, mulai buat assessment</h5>
        </div>
    </div>
@endif
@if ($assessments['total'] > 0)
    <nav id="assessment-pagination">
        <ul class="pagination justify-content-center">
            @foreach ($assessments['links'] as $page)
                <li class="cursor-pointer page-item @if (!$page['url'])disabled @endif @if ($page['active'])active @endif">
                    @if ($loop->iteration == 1)
                        <a onclick="changePage({{ $assessments['current_page'] - 1 }});" class="page-link">
                            Previous
                        </a>
                    @elseif ($loop->iteration == count($assessments['links']))
                        <a onclick="changePage({{ $assessments['current_page'] + 1 }});" class="page-link">
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

<script>
    $("a").click(function(event) {
        if ($(this).hasClass("disabled")) {
            event.preventDefault();
        }
        $(this).addClass("disabled");
    });
</script>
