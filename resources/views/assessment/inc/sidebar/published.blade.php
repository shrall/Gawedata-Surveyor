<ul class="list-unstyled my-4">
    <li class="my-4">
        <div class="card card-responden mx-3 p-4">
            <h5 class="mb-4">Responden</h5>
            <div class="responden-quota-box mb-1">
                <div class="responden-quota" style="width: 30%;"></div>
            </div>
            <div class="d-flex justify-content-between font-nexa font-weight-regular">
                <span>{{$result['total_respondent']}} Mengisi</span>
                <span>{{$survey['respondent_quota']}}</span>
            </div>
        </div>
    </li>
    <div id="survey-detail-sidebar" class="mx-3">
        <a href="{{ route('survey.hasil', $survey['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'survey.hasil') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'survey.hasil') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Hasil Survei</span>
            </li>
        </a>
        <a href="{{ route('survey.analisa', $survey['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'survey.analisa') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'survey.analisa') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Analisa Kriteria Responden</span>
            </li>
        </a>
        <a href="{{ route('survey.detail', $survey['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'survey.detail') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'survey.detail') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Detail Survei</span>
            </li>
        </a>
    </div>
</ul>
