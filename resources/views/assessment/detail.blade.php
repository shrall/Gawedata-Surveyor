@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="height:90vh;">
            <div class="col-4 text-start border-end">
                @include('assessment.inc.sidebar.published')
            </div>
            <div class="col-8 text-center my-4">
                <div class="card card-survey-detail border-0 p-4">
                    <table class="ms-4 px-4 py-2 font-lato">
                        <tr>
                            <td class="text-start text-gray" width="35%">ID Tes</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $assessment['id'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Judul Tes</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $assessment['title'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Deskripsi Tes</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $assessment['description'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Status Survei</td>
                            <td class="text-start me-4 font-weight-bold">:
                                {{ $assessment['status']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Tgl Survei Dimulai</td>
                            <td class="text-start me-4 font-weight-bold">:
                                {{ date('d-m-y', strtotime($assessment['test_date'])) }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Pertanyaan</td>
                            <td class="text-start me-4 font-weight-bold">: {{ count($assessment['questions']) }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Responden yang Diminta</td>
                            <td class="text-start me-4 font-weight-bold">: {{ $assessment['respondent_quota'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-start text-gray" width="35%">Jumlah Responden mengisi</td>
                            <td class="text-start me-4 font-weight-bold">:
                                {{ $assessment['respondent_count'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/3.0.3/main/clipboard-polyfill.js"
        integrity="sha512-0IaxYIj68pTzpOBGd7U3RFiF6sUPKefI5SRsYaZkGiJsM+U1/VuKnzT7dkDUxlIYcZ57gULzEk+PgtMfVAyFTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function copyToClipboard() {
            clipboard.writeText($('#survey-link').val());
        }
    </script>
@endsection
