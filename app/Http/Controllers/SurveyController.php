<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SurveyController extends Controller
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
        if ($request->cities[0] == null) {
            $city_criteria = $request->city;
        } else {
            $city_criteria = explode(",", $request->cities[0]);
        }
        if ($request->educations[0] == null) {
            $education_criteria = $request->education;
        } else {
            $education_criteria = explode(",", $request->educations[0]);
        }
        if ($request->professions[0] == null) {
            $profession_criteria = $request->profession;
        } else {
            $profession_criteria = explode(",", $request->professions[0]);
        }
        if ($request->expenses[0] == null) {
            $expense_criteria = $request->expense;
        } else {
            $expense_criteria = explode(",", $request->expenses[0]);
        }

        if ($request->survey_type == 'Public') {
            $is_private = false;
        } else {
            $is_private = true;
        }

        $gender = array();
        if ($request->has('check-pria')) {
            array_push($gender, 1);
        }
        if ($request->has('check-wanita')) {
            array_push($gender, 2);
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(config('services.api.url') . '/survey', [
            'title' => $request->title,
            'description' => $request->description,
            'survey_category_id' => $request->survey_category,
            'respondent_quota' => $request->survey_respondent,
            'is_private' => $is_private,
            'survey_type' => 'General',
            'general_expired_date' => date('Y-m-d', strtotime($request->survey_deadline)),
            'min_age_criteria' => $request->age_start,
            'max_age_criteria' => $request->age_end,
            'estimate_time' => $request->estimate_time,
            'gender_id' => $gender,
            'city_id' => $city_criteria,
            'education_id' => $education_criteria,
            'profession_id' => $profession_criteria,
            'household_expense_id' => $expense_criteria
        ])->json();
        if ($response['success']) {
            return redirect()->route('survey.show', ['id' => $response['data']['id'], 'i' => 1, 'new' => 'false']);
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
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
            ->json()['data'];
        if ($new == 'true' && count($survey['questions']) > 0) {
            $survey['questions'][count($survey['questions']) - 1]['question'] = "";
            $survey['questions'][count($survey['questions']) - 1]['answer_choices'][0] = "";
        }
        $provinces = array();
        foreach ($survey['city_criteria'] as $city) {
            array_push($provinces, $city['city']['province']);
        }
        $provinces = array_unique($provinces, SORT_REGULAR);
        $cities = array();
        foreach ($survey['city_criteria'] as $city) {
            array_push($cities, $city['city']);
        }
        if ($survey['status_id'] == 6) {
            return redirect()->route('survey.hasil', $id);
        } else if ($survey['status_id'] == 5) {
            return redirect()->route('survey.submitted', ['id' => $survey['id'], 'i' => 1]);
        } else {
            return view('survey.draft', compact('survey', 'i', 'categories', 'locations', 'educations', 'professions', 'expenses', 'provinces', 'cities'));
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
                "survey_question_type_id" => 1,
                'is_mandatory' => true,
                "is_other_option_enabled" => false,
                "is_no_answer_enabled" => false,
                "answer_choices" => [
                    "Jawaban",
                ]
            ];
            array_push($questions, $new_question);
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(config('services.api.url') . '/surveyQuestion', [
            'survey_id' => $id,
            'questions' => $questions
        ])->json();
        if ($request->submit_question) {
            return redirect()->route('survey.submit', ['id' => $id]);
        } else if ($request->new_question) {
            return redirect()->route('survey.show', ['id' => $id, 'i' => count($questions), 'new' => 'true']);
        } else {
            return redirect()->route('survey.show', ['id' => $id, 'i' => $request->question_index, 'new' => 'false']);
        }
    }

    public function change_settings(Request $request, $id)
    {
        if ($request->cities[0] == null) {
            $city_criteria = $request->city;
        } else {
            $city_criteria = explode(",", $request->cities[0]);
        }
        if ($request->educations[0] == null) {
            $education_criteria = $request->education;
        } else {
            $education_criteria = explode(",", $request->educations[0]);
        }
        if ($request->professions[0] == null) {
            $profession_criteria = $request->profession;
        } else {
            $profession_criteria = explode(",", $request->professions[0]);
        }
        if ($request->expenses[0] == null) {
            $expense_criteria = $request->expense;
        } else {
            $expense_criteria = explode(",", $request->expenses[0]);
        }
        if ($request->survey_type == 'Public') {
            $is_private = false;
        } else {
            $is_private = true;
        }
        $genders = array();
        if ($request->has('check-pria')) {
            array_push($genders, 1);
        }
        if ($request->has('check-wanita')) {
            array_push($genders, 2);
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post(config('services.api.url') . '/survey/' . $id, [
            'title' => $request->title,
            'description' => $request->description,
            'survey_category_id' => $request->survey_category,
            'respondent_quota' => $request->survey_respondent,
            'is_private' => $is_private,
            'min_age_criteria' => $request->age_start,
            'max_age_criteria' => $request->age_end,
            'estimate_time' => $request->estimate_time,
            'gender_id' => $genders,
            'city_id' => $city_criteria,
            'education_id' => $education_criteria,
            'profession_id' => $profession_criteria,
            'household_expense_id' => $expense_criteria
        ])->json();
        return redirect()->route('survey.show', ['id' => $id, 'i' => 1, 'new' => 'false']);
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
        ])->delete(config('services.api.url') . '/survey/' . $id)->json();
        return redirect()->route('home');
    }

    public function filter_sort(Request $request)
    {
        $surveys = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey?filter=' . $request->filter . '&sort=' . $request->sort)
            ->json()['data']['data'];
        $surveys = collect($surveys)->where('survey_type_id', $request->type);
        return view('inc.survey_list', compact('surveys'));
    }

    public function get_city(Request $request)
    {
        $locations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/location')
            ->json()['data'];
        if ($request->has('data')) {
            return collect($locations)->whereIn('id', $request->data)->all();
        } else {
            return collect($locations)->all();
        }
    }

    public function hasil($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/surveyResult/' . $id)
            ->json()['data'];
        return view('survey.hasil', compact('survey'));
    }

    public function analisa($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
            ->json()['data'];
        return view('survey.analisa', compact('survey'));
    }

    public function detail($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
            ->json()['data'];
        return view('survey.detail', compact('survey'));
    }

    public function submitted($id, $i)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
            ->json()['data'];
        return view('survey.submitted', compact('survey', 'i'));
    }

    public function refresh_single_answer(Request $request)
    {
        if (count($request->answers) > 0) {
            $answers = $request->answers;
        } else {
            $answers = null;
        }
        return view('survey.inc.draft.single_answer', compact('answers'));
    }

    public function refresh_grid_question(Request $request)
    {
        if (count($request->questions) > 0) {
            $questions = $request->questions;
        } else {
            $questions = null;
        }
        return view('survey.inc.draft.grid_question', compact('questions'));
    }

    public function refresh_grid_answer(Request $request)
    {
        if (count($request->answers) > 0) {
            $answers = $request->answers;
        } else {
            $answers = null;
        }
        return view('survey.inc.draft.grid_answer', compact('answers'));
    }

    public function submit($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->patch(config('services.api.url') . '/submitSurvey/' . $id)->json();
        return redirect()->route('survey.submitted', ['id' => $id, 'i' => 1]);
    }

    public function upload_photo(Request $request, $id)
    {
        if ($request->has('photo')) {
            $photo = 'survey-' . $id . '-' . time() . '-' . $request['photo']->getClientOriginalName();
            $request->photo->move(public_path('uploads/images'), $photo);
        } else {
            $photo = null;
        }
        return $photo;
    }

    public function grid_upload_photo(Request $request, $id)
    {
        if ($request->has('photo')) {
            $photo = 'survey-' . $id . '-' . time() . '-' . $request['photo']->getClientOriginalName();
            $request->photo->move(public_path('uploads/grid'), $photo);
        } else {
            $photo = null;
        }
        return $photo;
    }
}
