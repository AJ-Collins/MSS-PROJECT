<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.partials.profile');
    }
    public function dashboard()
    {
        return view('user.partials.dashboard');
    }
    public function submit()
    {
        return view('user.partials.submit');
    }
}