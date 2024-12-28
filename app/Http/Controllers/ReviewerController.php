<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Livewire\Attributes\Validate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    public function profile()
    {
        return view('reviewer.partials.profile');
    }
    public function dashboard()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();

        $abstractCount = $submissions->count();
        $proposalCount = $researchSubmissions->count();
        
        return view('reviewer.partials.dashboard', compact('submissions', 'researchSubmissions', 'abstractCount', 'proposalCount'));
    }
    public function documentsReview()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();

        $abstractCount = $submissions->count();
        $proposalCount = $researchSubmissions->count();

        return view('reviewer.partials.documents', compact('submissions', 'researchSubmissions', 'abstractCount', 'proposalCount'));
    }
    public function assignedAbstracts()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submission = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();

        return view('reviewer.partials.dashboard', compact('submission'));
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
