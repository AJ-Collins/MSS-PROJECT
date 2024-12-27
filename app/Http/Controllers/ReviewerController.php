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
        $assignedAbstracts = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();
        $assignedProposals = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();
        
        return view('reviewer.partials.dashboard', compact('assignedAbstracts', 'assignedProposals'));
    }
    public function documentsReview()
    {
        return view('reviewer.partials.documents');
    }
    public function assignedAbstracts()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $assignedAbstracts = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();

        return view('reviewer.partials.dashboard', compact('assignedAbstracts'));
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
