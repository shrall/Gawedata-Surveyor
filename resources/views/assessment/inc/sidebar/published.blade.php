<ul class="list-unstyled my-4">
    @if ($assessment['assessment_type_id'] != 3 && $assessment['is_simultaneously'] == 1)
        <li class="my-4">
            <div class="card card-responden mx-3 p-4">
                <h6 class="mb-4">Bagikan Link Tes kepada Responden</h6>
                <div class="card card-link-assessment d-flex flex-row align-items-center justify-content-between p-3">
                    <div id="survey-link">{{ $assessment['shareable_link'] ?? 'Link Belum Ada' }}</div>
                    @if ($assessment['shareable_link'])
                        <span class="far fa-fw fa-copy cursor-pointer" onclick="copyToClipboard();"></span>
                    @endif
                </div>
            </div>
        </li>
    @endif
    <div id="survey-detail-sidebar" class="mx-3">
        <a href="{{ route('assessment.hasil', $assessment['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.hasil') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.hasil') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Hasil Tes</span>
            </li>
        </a>
        @if ($assessment['assessment_type_id'] != 3)
            <a href="{{ route('assessment.ranking', $assessment['id']) }}" class="text-decoration-none">
                <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.ranking') active @endif position-relative">
                    <div
                        class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.ranking') invisible @endif ">

                    </div>
                    <span class="text-gray text-decoration-none ms-4 fs-6">
                        Ranking</span>
                </li>
            </a>
        @endif
        @if ($assessment['assessment_type_id'] == 3)
            <a href="{{ route('assessment.analisa', $assessment['id']) }}" class="text-decoration-none">
                <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.analisa') active @endif position-relative">
                    <div
                        class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.analisa') invisible @endif ">

                    </div>
                    <span class="text-gray text-decoration-none ms-4 fs-6">
                        Analisa Responden</span>
                </li>
            </a>
        @endif
        <a href="{{ route('assessment.pertanyaan', $assessment['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.pertanyaan') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.pertanyaan') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Pertanyaan</span>
            </li>
        </a>
        @if ($assessment['assessment_type_id'] == 3)
            <a href="{{ route('assessment.kategori', $assessment['id']) }}" class="text-decoration-none">
                <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.kategori') active @endif position-relative">
                    <div
                        class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.kategori') invisible @endif ">

                    </div>
                    <span class="text-gray text-decoration-none ms-4 fs-6">
                        Kategori</span>
                </li>
            </a>
        @endif
        <a href="{{ route('assessment.detail', $assessment['id']) }}" class="text-decoration-none">
            <li class="my-4 pe-4 py-3 @if (Route::current()->getName() == 'assessment.detail') active @endif position-relative">
                <div class="active-border py-1 top-50 start-0 translate-middle-y d-inline @if (Route::current()->getName() != 'assessment.detail') invisible @endif "> 
                </div>
                <span class="text-gray text-decoration-none ms-4 fs-6">
                    Detail Tes</span>
            </li>
        </a>
    </div>
</ul>
