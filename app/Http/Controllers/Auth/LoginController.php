<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $response = Http::post(config('services.api.url') . '/login', [
            'email' => $request->email,
            'password' => $request->password,
        ])->json();
        if ($response['data'] != null) {
            Session::put('token', $response['data']['token']);
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . Session::get('token'),
        ])->post(config('services.api.url') . '/logout')->json();
        Session::flush();
        return redirect()->route('login');
    }
}
