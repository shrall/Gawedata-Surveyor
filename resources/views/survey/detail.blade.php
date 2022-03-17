@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('survey.inc.sidebar.published')
            </div>
            <div class="col-8 text-center my-4">
                <div class="card card-survey-detail border-0 p-4">
                    <table class="ms-4 px-4 py-2 font-lato">
                        <tr>
                            <td class="text-start text-gray" width="35%">ID Survei</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $survey['id'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Nama Survei</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $survey['title'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Status Survei</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $survey['status']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kategori Survei</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $survey['category']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jenis Survei</td>
                            @if ($survey['is_private'])
                                <td class="text-start me-4 font-weight-bold">: Private</td>
                            @else
                                <td class="text-start me-4 font-weight-bold">: Public</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Tgl Survei Dimulai</td>
                            <td class="text-start me-4 font-weight-bold">: {{ date('d-m-Y', strtotime($survey['created_at'])) }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Tgl Survei Selesai</td>
                            <td class="text-start me-4 font-weight-bold">: {{ date('d-m-Y', strtotime($survey['general_expired_date'])) }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Pertanyaan</td>
                            <td class="text-start me-4 font-weight-bold">: {{ count($survey['questions']) }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Responden yang Diminta</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $survey['respondent_quota'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Responden mengisi</td>
                            <td class="text-start me-4 font-weight-bold">: {{$result['total_respondent']}}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Jenis Kelamin</td>
                            <td class="text-start me-4 font-weight-bold">:
                                @foreach ($survey['gender_criteria'] as $gender)
                                    {{ $gender['gender']['name'] }}@if ($loop->iteration != count($survey['gender_criteria'])),@endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Umur</td>
                            <td class="text-start me-4 font-weight-bold">: {{$survey['min_age_criteria']}}-{{$survey['max_age_criteria']}} Tahun</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Kota</td>
                            <td class="text-start me-4 font-weight-bold">:
                                @foreach ($survey['city_criteria'] as $city)
                                    {{ $city['city']['city_name'] }}@if ($loop->iteration != count($survey['city_criteria'])),@endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Pendidikan</td>
                            <td class="text-start me-4 font-weight-bold">:
                                @foreach ($survey['education_criteria'] as $education)
                                    {{ $education['education']['name'] }}@if ($loop->iteration != count($survey['education_criteria'])),@endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Profesi</td>
                            <td class="text-start me-4 font-weight-bold">:
                                @foreach ($survey['profession_criteria'] as $profession)
                                    {{ $profession['profession']['name'] }}@if ($loop->iteration != count($survey['profession_criteria'])),@endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Kriteria Pengeluaran</td>
                            <td class="text-start me-4 font-weight-bold">:
                                @foreach ($survey['household_expense_criteria'] as $household_expense)
                                    {{ $household_expense['household_expense']['name'] }}@if ($loop->iteration != count($survey['household_expense_criteria'])),@endif
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
