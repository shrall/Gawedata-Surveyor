<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
