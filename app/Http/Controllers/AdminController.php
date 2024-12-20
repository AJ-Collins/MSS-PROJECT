<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.partials.dashboard');
    }
    public function users()
    {
        return view('admin.partials.users');
    }

    public function submissions()
    {
        return view('admin.partials.submissions');
    }

    public function reports()
    {
        return view('admin.partials.reports');
    }

    public function documents()
    {
        return view('admin.partials.documents');
    }

    public function profile()
    {
        return view('admin.partials.profile');
    }

    public function settings()
    {
        return view('admin.partials.settings');
    }
}
