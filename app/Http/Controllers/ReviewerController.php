<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function profile()
    {
        return view('reviewer.partials.profile');
    }
    public function dashboard()
    {
        return view('reviewer.partials.dashboard');
    }
    public function documentsReview()
    {
        return view('reviewer.partials.documents');
    }
    public function assessment()
    {
        return view('reviewer.partials.assessment');
    }
    public function revieweddocuments()
    {
        return view('reviewer.partials.revieweddocuments');
    }
}
