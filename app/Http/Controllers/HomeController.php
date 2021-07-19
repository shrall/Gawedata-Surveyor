<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('surveyor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $surveys = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])
            ->get(config('services.api.url') . '/survey')
            ->json()['data']['data'];
        return view('home', compact('surveys'));
    }
}
