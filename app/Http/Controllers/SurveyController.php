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
            'survey_category_id' => 1,
            'respondent_quota' => $request->survey_respondent,
            'is_private' => $is_private,
            'survey_type' => 'General',
            'general_expired_date' => date('y-m-d', strtotime($request->survey_deadline)),
            'min_age_criteria' => $request->age_start,
            'max_age_criteria' => $request->age_end,
            'estimate_time' => '5 menit',
            'gender_id' => $gender,
            'city_id' => $request->city,
            'education_id' => $request->education,
            'profession_id' => $request->profession,
            'household_expense_id' => $request->expense
        ])->json();

        if ($response['success']){
            return redirect()->route('survey.show', $response['data']['id']);
        }else {
            dd($response);
        }
        // if ($response['data'] != null) {
        //     return redirect()->route('home');
        // } else {
        //     return redirect()->route('login')->withErrors(['msg', 'Error']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
            ->json()['data'];
        return view('survey.draft', compact('survey'));
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
        //
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
        ])->delete(config('services.api.url') . '/survey/'. $id)->json();
        return redirect()->route('home');
    }

    public function get_city(Request $request)
    {
        $locations = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/location')
            ->json()['data'];
        collect($locations)->whereIn('id', $request->data)->all();
        return collect($locations)->whereIn('id', $request->data)->all();
    }

    public function hasil($id)
    {
        $survey = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey/' . $id)
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
}
