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
        dd($request);
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
        // $provinces = array();
        // foreach ($survey['city_criteria'] as $city) {
        //     array_push($provinces, $city['city']['province']);
        // }
        // $provinces = array_unique($provinces, SORT_REGULAR);
        // $cities = array();
        // foreach ($survey['city_criteria'] as $city) {
        //     array_push($cities, $city['city']);
        // }
        if ($new == 'true' && count($assessment['questions']) > 0) {
            if ($i == count($assessment['questions'])) {
                $assessment['questions'][$i - 1]['question'] = "";
                $assessment['questions'][$i - 1]['answer_choices'][0]['text'] = "";
                $assessment['questions'][$i - 1]['answer_choices'][1]['text'] = "";
            }
        }
        if ($assessment['status_id'] == 6) {
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
                        "is_right_answer" => true
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
        //
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
        dd('hasil ' + $id);
    }

    public function submitted($id, $i)
    {
        dd('submitted ' + $id);
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
            'url' => asset('/uploads/images') . '/' . $photo
        ]);
    }
}
