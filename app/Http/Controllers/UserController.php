<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function edit_profile()
    {
        return view('user.edit_profile');
    }

    public function reset_password()
    {
        return view('user.reset_password');
    }

    public function update_password(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'min:8'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);
        Http::withHeaders([
            'Authorization' => 'Bearer ' . Session::get('token'),
        ])->post(config('services.api.url') . '/changePassword', [
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ])->json();
        return redirect()->route('user.resetpassword');
    }
}
