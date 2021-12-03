<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->assessment_method == 'irt') {
            $method = 1;
            $test_date = $request->start_time;
        } else if ($request->assessment_method == 'rs') {
            $method = 2;
            $test_date = $request->start_time;
        } else {
            $method = 3;
            $test_date = $request->end_time;
        }
        if (!$request->start_time_ns) {
            $start_time = $request->start_time;
        } else {
            $start_time = $request->start_time_ns;
        }
        if (!$request->end_time_ns) {
            $end_time = $request->end_time;
        } else {
            $end_time = $request->end_time_ns;
        }
        if ($request->assessment_serentak == 'true') {
            $serentak = true;
        } else {
            $serentak = false;
        }
        if ($request->assessment_type == 'Public') {
            $private = false;
        } else {
            $private = true;
        }
        if ($request->with_discussion) {
            $discussion = true;
        } else {
            $discussion = false;
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(config('services.api.url') . '/assessment', [
            'assessment_type_id' => $method,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'test_date' => $test_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'is_simultaneously' => $serentak,
            'is_private' => $private,
            'with_discussion' => $discussion,
            'with_ranking' => $serentak,
            'easy_in_percent' => $request->easy_in_percent,
            'medium_in_percent' => $request->medium_in_percent,
            'hard_in_percent' => $request->hard_in_percent,
            'easy_in_points' => $request->easy_in_points,
            'medium_in_points' => $request->medium_in_points,
            'hard_in_points' => $request->hard_in_points,
        ])->json();
        if ($response['success']) {
            return redirect()->route('assessment.show', ['id' => $response['data']['id'], 'i' => 1, 'new' => 'false']);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $i, $new)
    {
        $locations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/location')
            ->json()['data'];
        $educations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/education')
            ->json()['data'];
        $professions = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/profession')
            ->json()['data'];
        $expenses = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/householdExpensesPerMonth')
            ->json()['data'];
        $categories = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/surveyCategory')
            ->json()['data'];

        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($new == 'true' && count($assessment['questions']) > 0) {
            if ($i == count($assessment['questions'])) {
                $assessment['questions'][$i - 1]['question'] = "";
                $assessment['questions'][$i - 1]['answer_choices'][0]['text'] = "";
                $assessment['questions'][$i - 1]['answer_choices'][1]['text'] = "";
            }
        }
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return redirect()->route('assessment.hasil', $id);
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submitted', ['id' => $assessment['id'], 'i' => 1]);
        } else {
            return view('assessment.draft', compact('assessment', 'i', 'categories', 'locations', 'educations', 'professions', 'expenses'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $questions = json_decode($request->questions);
        if ($request->new_question != null) {
            $new_question = [
                "question" => "Pertanyaan Baru",
                "image_path" => "",
                "discussion" => "",
                "discussion_image_path" => "",
                "answer_choices" => [
                    [
                        "text" => "Answer Choice 1",
                        "points" => 0,
                        "is_right_answer" => false
                    ],
                    [
                        "text" => "Answer Choice 2",
                        "points" => 0,
                        "is_right_answer" => false
                    ]
                ]
            ];
            array_push($questions, $new_question);
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(
            config('services.api.url') . '/assessmentQuestion/' . $id,
            $questions
        )->json();
        if ($request->change_tab) {
            return redirect()->route('assessment.showrespondent', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
        if ($request->submit_question) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else if ($request->new_question) {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => count($questions), 'new' => 'true']);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => $request->question_index, 'new' => 'false']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->delete(config('services.api.url') . '/assessment/' . $id)->json();
        return redirect()->route('home');
    }

    public function filter_sort(Request $request)
    {
        $assessments = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment?paginate=16&sort=' . $request->sort . '&page=' . $request->page . '&filter=' . $request->filter)
            ->json()['data'];
            $view = $request->view;
        return view('inc.assessment_list', compact('assessments', 'view'));
    }

    public function get_assessment(Request $request)
    {
        $assessments = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment?paginate=16&page=' . $request->page)
            ->json()['data'];
        return view('inc.assessment_list', compact('assessments'));
    }

    public function hasil($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessmentTestResult/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.hasil', compact('assessment', 'result'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function analisa($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessmentRespondentAnalysis/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.analisa', compact('assessment', 'result'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function pertanyaan($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.pertanyaan', compact('assessment'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function kategori($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.kategori', compact('assessment'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function ranking($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessmentRespondentAnalysis/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.ranking', compact('assessment', 'result'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function detail($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessmentTestResult/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.detail', compact('assessment', 'result'));
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submit', ['id' => $id]);
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function submitted($id, $i)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return redirect()->route('assessment.hasil', $id);
        }
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.hasil', compact('assessment', 'i'));
        } else if ($assessment['status_id'] == 5) {
            return view('assessment.submitted', compact('assessment', 'i'));
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }
    public function submitted_respondent($id, $i)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6 || $assessment['status_id'] == 7 || $assessment['status_id'] == 8 || $assessment['status_id'] == 9) {
            return view('assessment.submitted_respondent', compact('assessment', 'i'));
        } else {
            return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
        }
    }

    public function refresh_irt_answer(Request $request)
    {
        if (count($request->answers) > 0) {
            $answers = $request->answers;
        } else {
            $answers = null;
        }
        return view('assessment.inc.draft.irt_answer', compact('answers'));
    }

    public function refresh_rs_answer(Request $request)
    {
        if (count($request->answers) > 0) {
            $answers = $request->answers;
        } else {
            $answers = null;
        }
        return view('assessment.inc.draft.rs_answer', compact('answers'));
    }

    public function refresh_sa_answer(Request $request)
    {
        if (count($request->answers) > 0) {
            $answers = $request->answers;
        } else {
            $answers = null;
        }
        return view('assessment.inc.draft.sa_answer', compact('answers'));
    }

    public function upload_photo(Request $request, $id)
    {
        if ($request->has('photo')) {
            $photo = 'assessment-' . $id . '-' . time() . '-' . $request['photo']->getClientOriginalName();
            $request->photo->move(public_path('uploads/images'), $photo);
        } else {
            $photo = null;
        }
        return $photo;
    }

    public function upload_photo_discussion(Request $request)
    {
        if ($request->has('upload')) {
            $photo = 'assessment-discussion-' . time() . '-' . $request['upload']->getClientOriginalName();
            $request->upload->move(public_path('uploads/images'), $photo);
        } else {
            $photo = null;
        }
        return response()->json([
            "uploaded" => true,
            'url' => asset('/uploads/images') . '/' . $photo
        ]);
    }
    public function show_respondent($id, $i, $new)
    {
        $locations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/location')
            ->json()['data'];
        $educations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/education')
            ->json()['data'];
        $professions = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/profession')
            ->json()['data'];
        $expenses = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/householdExpensesPerMonth')
            ->json()['data'];
        $categories = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/surveyCategory')
            ->json()['data'];

        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/assessment/' . $id)
            ->json()['data'];
        if ($assessment['status_id'] == 6) {
            return redirect()->route('assessment.hasil', $id);
        } else if ($assessment['status_id'] == 5) {
            return redirect()->route('assessment.submitted', ['id' => $assessment['id'], 'i' => 1]);
        } else {
            return view('assessment.draft_respondent', compact('assessment', 'i', 'categories', 'locations', 'educations', 'professions', 'expenses', 'new'));
        }
    }

    public function store_respondent_type(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(config('services.api.url') . '/respondentType/' . $request->assessment_id, [
            'name' => $request->name,
            'min_points' => $request->min_points,
            'max_points' => $request->max_points,
            'discussion' => $request->discussion,
        ])->json();
        if ($request->new_bool) {
            $new = 'true';
        } else {
            $new = 'false';
        }
        if ($request->submit_question) {
            return redirect()->route('assessment.submit', ['id' => $request->assessment_id]);
        }
        if ($request->change_tab_bool) {
            return redirect()->route('assessment.show', ['id' => $request->assessment_id, 'i' => 1, 'new' => 'false']);
        } else {
            return redirect()->route('assessment.showrespondent', ['id' => $request->assessment_id, 'i' => $request->next, 'new' => $new]);
        }
    }

    public function update_respondent_type(Request $request)
    {
        $path = $request->respondent_type_id . "?name=" . $request->name . "&min_points=" . $request->min_points . "&max_points=" . $request->max_points . "&discussion=" . $request->discussion;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->patch(config('services.api.url') . '/respondentType/' . $path)->json();
        if ($request->new_bool || $request->respondent_type_count == 0) {
            $new = 'true';
        } else {
            $new = 'false';
        }
        if ($request->submit_question) {
            return redirect()->route('assessment.submit', ['id' => $request->assessment_id]);
        }
        if ($request->change_tab_bool) {
            return redirect()->route('assessment.show', ['id' => $request->assessment_id, 'i' => 1, 'new' => 'false']);
        } else {
            return redirect()->route('assessment.showrespondent', ['id' => $request->assessment_id, 'i' => $request->next, 'new' => $new]);
        }
    }

    public function delete_respondent_type(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->delete(config('services.api.url') . '/respondentType/' . $request->respondent_type_id)->json();
        if ($request->respondent_type_count == 1) {
            $new = 'true';
        } else {
            $new = 'false';
        }
        if ($request->change_tab_bool) {
            return redirect()->route('assessment.show', ['id' => $request->assessment_id, 'i' => 1, 'new' => 'false']);
        } else {
            return redirect()->route('assessment.showrespondent', ['id' => $request->assessment_id, 'i' => $request->next, 'new' => $new]);
        }
    }

    public function submit($id)
    {
        $assessment = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->patch(config('services.api.url') . '/submitAssessment/' . $id)->json();
        return redirect()->route('assessment.submitted', ['id' => $id, 'i' => 1]);
    }
    public function change_settings(Request $request, $id)
    {
        if ($request->assessment_method == 'irt') {
            $method = 1;
            $test_date = $request->start_time;
        } else if ($request->assessment_method == 'rs') {
            $method = 2;
            $test_date = $request->start_time;
        } else {
            $method = 3;
            $test_date = $request->end_time;
        }
        if (!$request->start_time_ns) {
            $start_time = $request->start_time;
        } else {
            $start_time = $request->start_time_ns;
        }
        if (!$request->end_time_ns) {
            $end_time = $request->end_time;
        } else {
            $end_time = $request->end_time_ns;
        }
        if ($request->assessment_serentak == 'true') {
            $serentak = "true";
        } else {
            $serentak = "false";
        }
        if ($request->assessment_type == 'Public') {
            $private = "false";
        } else {
            $private = "true";
        }
        if ($request->with_discussion) {
            $discussion = "true";
        } else {
            $discussion = "false";
        }
        $path = $id . "?assessment_type_id=" . $method . "&is_private=" . $private . "&with_discussion=" . $discussion . "&title=" . $request->title . "&description=" . $request->description . "&test_date=" . $test_date . "&is_simultaneously=" . $serentak . "&duration=" . $request->duration . "&with_ranking=" . $serentak . "&hard_in_percent=" . $request->hard_in_percent . "&medium_in_percent=" . $request->medium_in_percent . "&easy_in_percent=" . $request->easy_in_percent . "&hard_in_points=" . $request->hard_in_points . "&medium_in_points=" . $request->medium_in_points . "&easy_in_points=" . $request->easy_in_points . "&start_time=" . $start_time . "&end_time=" . $end_time;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->patch(config('services.api.url') . '/assessment/' . $path)->json();
        return redirect()->route('assessment.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
    }
}
