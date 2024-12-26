<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::user();

        $totalReviewers = DB::table('role_user')
            ->whereIn('role_id', [2])
            ->count();
        $totalUsers = DB::table('role_user')
            ->whereIn('role_id', [3])
            ->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();

        return view('admin.partials.dashboard', compact('totalUsers', 'totalAbstracts',
                    'totalProposals', 'totalReviewers', 'submissions', 'researchSubmissions'));
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
        $admin = Auth::user();

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();
        return view('admin.partials.documents', compact('submissions', 'researchSubmissions'));
    }
    public function approveAbstract(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Approve the abstract by setting the 'approved' field to true
            $submission->final_status = "Approved";
            $submission->admin_comments = null;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract approved successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function rejectAbstract(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
            'comments' => 'required|string|max:1000',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Approve the abstract by setting the 'approved' field to true
            $submission->final_status = "Rejected";
            $submission->admin_comments = $request->comments;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract rejected successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function approveProposal(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the abstract by setting the 'approved' field to true
            $researchSubmission->final_status = "Approved";
            $researchSubmission->admin_comments = null;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Abstract approved successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function rejectProposal(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
            'comments' => 'required|string|max:1000',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the abstract by setting the 'approved' field to true
            $researchSubmission->final_status = "Rejected";
            $researchSubmission->admin_comments = $request->comments;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Abstract rejected successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
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
