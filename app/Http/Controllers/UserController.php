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
    public function confirm()
    {
        return view('user.partials.confirm');
    }
    public function step1_research()
    {
        return view('user.partials.step1_research');
    }
    public function step2_research()
    {
        return view('user.partials.step2_research');
    }
    public function preview_research()
    {
        return view('user.partials.preview_research');
    }
    public function confirm_research()
    {
        return view('user.partials.confirm_research');
    }
    public function confirmSubmission(Request $request)
    {
        // Handle your form submission logic

        // Add success message to the session
        session()->flash('success', 'Your submission was successful!');

        // Redirect to dashboard
        return redirect()->route('user.dashboard');
    }
}