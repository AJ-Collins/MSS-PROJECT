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
    public function step1()
    {
        return view('user.partials.step1');
    }
    public function step2()
    {
        return view('user.partials.step2');
    }
    public function preview()
    {
        return view('user.partials.preview');
    }
}