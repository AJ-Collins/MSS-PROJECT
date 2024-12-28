<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::user();

        $totalReviewers = Role::find(2)->users()->count();
        $totalUsers = Role::find(3)->users()->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::all();
        $researchSubmissions = ResearchSubmission::all();

        return view('admin.partials.dashboard', compact('totalUsers', 'totalAbstracts',
                    'totalProposals', 'totalReviewers', 'submissions', 'researchSubmissions'));
    }
    public function users(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('reg_no', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
        })
        ->paginate(10);

        $roles = Role::all();
        return view('admin.partials.users', compact('users','roles'));
    }
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->reg_no . ',reg_no'
        ]);
     
        // Only validate email uniqueness if it's being changed
        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email' 
            ]);
        }
     
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
     
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function updateRole(Request $request, $reg_no)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::where('reg_no', $reg_no)->with('roles')->first();

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'User not found.']);
        }
    
        // Sync the role with the user
        $user->roles()->sync([$validated['role_id']]);
    
        return redirect()->route('admin.users')->with('success', 'Role updated successfully.');
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'reg_no' => 'required|string|unique:users,reg_no',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'reg_no' => $validated['reg_no'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), 
        ]);

        $user->roles()->attach($validated['role_id']);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully');
    }
    public function toggleStatus(User $user)
    {
        // Toggle the user's active status
    $user->update(['active' => !$user->active]);

    // Remove the user's role(s) and set it to blank
    $user->roles()->detach(); // This will remove all roles from the user

    return redirect()->route('admin.users')
        ->with('success', "User deactivated successfully and roles removed.");
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

        // Get submissions with their reviewer information
        $submissions = AbstractSubmission::leftJoin('users', 'users.reg_no', '=', 'abstract_submissions.reviewer_reg_no')
            ->select('abstract_submissions.*', 'users.name as reviewer_name')
            ->get();
        // Get submissions with their reviewer information
        $researchSubmissions = ResearchSubmission::leftJoin('users', 'users.reg_no', '=', 'research_submissions.reviewer_reg_no')
            ->select('research_submissions.*', 'users.name as reviewer_name')
            ->get();
            
        $reviewers = User::whereHas('roles', function ($query){
            $query->where('name', 'Reviewer');
        })->get();

        return view('admin.partials.documents', compact('submissions', 'researchSubmissions', 'reviewers'));
    }
    public function assignAbstractReviewer(Request $request, $serial_number)
    {
        // Validate the reviewer_reg_no
        $request->validate([
            'reg_no' => [
                'required',
                function ($attribute, $value, $fail) {
                    $reviewer = User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->first();

                    if (!$reviewer) {
                        $fail('The specified reviewer is not valid or does not have the reviewer role.');
                    }
                },
            ],
        ]);

        // Find the abstract submission by serial number
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Update the reviewer_reg_no field
        $submission->reviewer_reg_no = $request->reg_no;
        $submission->save();

        return redirect()->back()->with('success', 'Reviewer assigned successfully.');
    }
    public function removeAbstractReviewer(Request $request, $serial_number)
    {
        // Find the abstract submission by serial number
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Remove the reviewer assignment
        $submission->reviewer_reg_no = null;
        $submission->save();

        return redirect()->back()->with('success', 'Reviewer removed successfully.');
    }
    public function assignProposalReviewer(Request $request, $serial_number)
    {
        // Validate the reviewer_reg_no
        $request->validate([
            'reg_no' => [
                'required',
                function ($attribute, $value, $fail) {
                    $reviewer = User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->first();

                    if (!$reviewer) {
                        $fail('The specified reviewer is not valid or does not have the reviewer role.');
                    }
                },
            ],
        ]);

        // Find the abstract submission by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Update the reviewer_reg_no field
        $researchSubmission->reviewer_reg_no = $request->reg_no;
        $researchSubmission->save();

        return redirect()->back()->with('success', 'Reviewer assigned successfully.');
    }
    public function removeProposalReviewer(Request $request, $serial_number)
    {
        // Find the abstract submission by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Remove the reviewer assignment
        $researchSubmission->reviewer_reg_no = null;
        $researchSubmission->save();

        return redirect()->back()->with('success', 'Reviewer removed successfully.');
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
            // Reject the abstract by setting the 'approved' field to true
            $submission->final_status = "Rejected";
            $submission->admin_comments = $request->comments;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract rejected successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
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
    
            return redirect()->back()->with('success', 'Proposal approved successfully.');
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
    
            return redirect()->back()->with('success', 'Proposal rejected successfully.');
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
