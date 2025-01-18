<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use App\Models\ResearchAssessment;
use App\Models\ProposalAssessment;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Notifications\NewUserNotification;
use App\Traits\DynamicTitleTrait;


class AdminController extends Controller
{
    use DynamicTitleTrait;
    public function dashboard()
    {
        $admin = Auth::user();

        $totalReviewers = Role::find(2)->users()->count();
        $totalUsers = Role::find(3)->users()->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::where('reviewer_status', Null)
            ->where('final_status', '!=','accepted')
            ->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_status', Null)
            ->where('final_status', '!=','accepted')
            ->get();

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
        $submissions = AbstractSubmission::with('user')
            ->where('score', '!=', null)
            ->get();
        $researchSubmissions = ResearchSubmission::with('user')
            ->where('score', '!=', null)
            ->get();
        $researchAssessments = ResearchAssessment::all();

        return view('admin.partials.reports', compact('submissions', 'researchSubmissions', 'researchAssessments'));
    }

    public function showAssessments($serial_number)
    {
        $assessments = ResearchAssessment::where('abstract_submission_id', $serial_number)
            ->with('reviewer', 'user') // Load related reviewer and user
            ->get();

        return view('admin.partials.research_assessments', compact('assessments', 'serial_number'));
    }
    public function showProposalAssessments($serial_number)
    {
        $proposalAssessments = ProposalAssessment::where('abstract_submission_id', $serial_number)
            ->with('reviewer', 'user') // Load related reviewer and user
            ->get();

        return view('admin.partials.research_assessments', compact('proposalAssessments', 'serial_number'));
    }
    

    public function documents()
    {   
        $admin = Auth::user();

        // Get submissions with their reviewer information
        $submissions = AbstractSubmission::leftJoin('users', 'users.reg_no', '=', 'abstract_submissions.reviewer_reg_no')
            ->select('abstract_submissions.*', 'users.first_name as reviewer_name')
            ->where('approved', '!=', true)
            ->get();
        // Get submissions with their reviewer information
        $researchSubmissions = ResearchSubmission::leftJoin('users', 'users.reg_no', '=', 'research_submissions.reviewer_reg_no')
            ->select('research_submissions.*', 'users.first_name as reviewer_name')
            ->where('approved', '!=', true)
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

        $user = User::where('reg_no', $submission->user_reg_no)->first();

        $reviewer = User::where('reg_no', $request->reg_no)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'reviewer');
                    })->first();

        $dataForUser = [
            'message' => 'Abstract ' . $submission['serial_number'] . ' is under review',
            'link' => '/some-link',
        ];
        
        $user->notify(new NewUserNotification($dataForUser));

        $dataForReviewer = [
            'message' => 'You have been assigned to review Abstract ' . $submission['serial_number'],
            'link' => '/some-link',
        ];

        $reviewer->notify(new NewUserNotification($dataForReviewer));


        return redirect()->back()->with('success', 'Reviewer assigned successfully.');
    }
    public function removeAbstractReviewer(Request $request, $serial_number)
    {
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();
        
        $oldReviewerRegNo = $submission->reviewer_reg_no;
        
        // Remove the reviewer assignment
        $submission->reviewer_reg_no = null;
        $submission->reviewer_status = '';
        $submission->save();
        
        // Only attempt to notify if there was a reviewer assigned
        if ($oldReviewerRegNo) {
            $reviewer = User::where('reg_no', $oldReviewerRegNo)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->first();
            
            if ($reviewer) {
                $dataForReviewer = [
                    'message' => 'You have lost ' . $submission['serial_number'],
                    'link' => '/some-link',
                ];
                
                $reviewer->notify(new NewUserNotification($dataForReviewer));
            }
        }
        
        return redirect()->back()->with('success', 'Reviewer removed successfully.');
    }
    public function assignAbstractMassReviewer(Request $request)
    {
        $request->validate([
            'submissions' => 'required|array|min:1',
            'reviewer' => [
                'required',
                'string',
                'exists:users,reg_no', // Ensure the reviewer exists in the users table
                function ($attribute, $value, $fail) {
                    $reviewer = User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->first();

                    if (!$reviewer) {
                        $fail('The specified reviewer does not have the reviewer role.');
                    }
                },
            ],
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Get the list of serial numbers before updating
                $submissions = AbstractSubmission::whereIn('serial_number', $request->submissions)->get();

                // Update all abstract submissions with the assigned reviewer's reg_no
                AbstractSubmission::whereIn('serial_number', $request->submissions)
                    ->update(['reviewer_reg_no' => $request->reviewer]);

                // Fetch the reviewer user
                $reviewer = User::where('reg_no', $request->reviewer)->first();

                // Prepare the list of serial numbers for notification
                $serialNumbersList = $submissions->pluck('serial_number')->implode(', ');

                // Notification data
                $dataForReviewer = [
                    'message' => 'You have been assigned the following abstracts for review: ' . $serialNumbersList,
                    'link' => '/some-link', // Add the actual link where the reviewer can see the abstracts
                ];
                foreach ($submissions as $submission) {
                    $user = User::where('reg_no', $submission->user_reg_no)->first();
    
                    if ($user) {
                        // Notification data for user
                        $dataForUser = [
                            'message' => 'Abstracts ' . $serialNumbersList . ' are under review',
                            'link' => '/some-link', // Add the link where the user can track review status
                        ];
    
                        // Notify the user
                        $user->notify(new NewUserNotification($dataForUser));
                    }
                }

                // Notify the reviewer
                $reviewer->notify(new NewUserNotification($dataForReviewer));
            });

            return response()->json(['message' => 'Reviewers assigned and notified successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while assigning reviewers.'], 500);
        }
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
    public function assignProposalMassReviewer(Request $request)
    {
        $request->validate([
            'submissions' => 'required|array|min:1',
            'reviewer' => [
                'required',
                'string',
                'exists:users,reg_no', // Ensure the reviewer exists in the users table
                function ($attribute, $value, $fail) {
                    $reviewer = User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->first();

                    if (!$reviewer) {
                        $fail('The specified reviewer does not have the reviewer role.');
                    }
                },
            ],
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->submissions as $serialNumber) {
                    ResearchSubmission::where('serial_number', $serialNumber)
                        ->update(['reviewer_reg_no' => $request->reviewer]);
                }
            });

            return response()->json(['message' => 'Reviewers assigned successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while assigning reviewers.'], 500);
        }
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
        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
            'rejection_comment' => 'required|string|max:1000',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Reject the abstract
            $submission->final_status = "rejected";
            $submission->admin_comments = $request->rejection_comment;
            $submission->save();

            $user = User::where('reg_no', $submission->user_reg_no)->first();

            $data = [
                'message' => 'Abstract ' . $submission['serial_number'] . ' Rejected. ' . 'Reason: ' . $submission->admin_comments = $request->comments,
                'link' => '/some-link',
            ];
            
            $user->notify(new NewUserNotification($data));

            return redirect()->back()->with('success', 'Abstract rejected successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function acceptAbstract(Request $request)
    {

        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Approve the abstract by setting the 'approved' field to true
            $submission->final_status = "accepted";
            $submission->admin_comments = null;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract accepted successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function acceptProposal(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the abstract by setting the 'approved' field to true
            $researchSubmission->final_status = "accepted";
            $researchSubmission->admin_comments = null;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Proposal accepted successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function rejectProposal(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
            'rejection_comment' => 'required|string|max:1000',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the abstract by setting the 'approved' field to true
            $researchSubmission->final_status = "rejected";
            $researchSubmission->admin_comments = $request->rejection_comment;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Proposal rejected successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function approveAbstract(Request $request)
    {

        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Approve the abstract by setting the 'approved' field to true
            $submission->approved = true;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract approved successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function unapproveAbstract(Request $request)
    {

        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Approve the abstract by setting the 'approved' field to true
            $submission->approved = false;
            $submission->save();
    
            return redirect()->back()->with('success', 'Abstract declined successfully.');
        }
        return redirect()->back()->with('error', 'Abstract not found.');
    }
    public function approveProposal(Request $request)
    {

        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the proposal by setting the 'approved' field to true
            $researchSubmission->approved = true;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Proposal approved successfully.');
        }
        return redirect()->back()->with('error', 'Proposal not found.');
    }
    public function unapproveProposal(Request $request)
    {

        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
        ]);
        // Find the abstract by serial number
        $researchSubmission = ResearchSubmission::where('serial_number', $request->serial_number)->first();

        if ($researchSubmission) {
            // Approve the abstract by setting the 'approved' field to false
            $researchSubmission->approved = false;
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Proposal declined successfully.');
        }
        return redirect()->back()->with('error', 'Proposal not found.');
    }
    public function profile()
    {
        return view('admin.partials.profile');
    }
    public function requestArticleUpload (Request $request, $serial_number)
    {
        // Find the abstract submission by serial number
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Find the user associated with the submission
        $user = User::where('reg_no', $submission->user_reg_no)->first();

        // Prepare data for the notification
        $dataForUser = [
            'message' => 'Your abstract ' . $submission->serial_number . ' was reviewed. Please upload your article.',
            'link' => route('user.submit.article', ['serial_number' => $submission->serial_number]),
        ];
        
        $user->notify(new NewUserNotification($dataForUser));

        return redirect()->back()->with('success', 'User has been notified to upload article.');
    }

    public function acceptRevision(Request $request)
    {
        try {
            $serial_number = $request->serial_number;
            
            // Find the submission and the associated user
            $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();
            $user = User::where('reg_no', $submission->reviewer_reg_no)->firstOrFail();

            // Update submission status to 'under_review'
            $submission->final_status = 'under_review';
            $submission->save();

            // Notify the user about the accepted revision
            $notificationData = [
                'message' => 'Revision for Abstract ' . $submission->serial_number . ' has been accepted.',
                'link' => '/some-link',  // Update with the actual link
            ];
            $user->notify(new NewUserNotification($notificationData));

            return redirect()->back()->with('success', 'Revision accepted and user notified successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while accepting the revision.');
        }
    }
    public function rejectRevision(Request $request)
    {
        try {
            $serial_number = $request->serial_number;
            
            // Find the submission and the associated user
            $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();
            $user = User::where('reg_no', $submission->reviewer_reg_no)->firstOrFail();

            // Update submission status to 'rejected'
            $submission->final_status = 'submitted';  // Mark as rejected
            $submission->reviewer_status = '';       // Clear reviewer status
            $submission->reviewer_reg_no = '';       // Clear reviewer assignment
            $submission->save();

            // Notify the reviewer about the rejection
            $notificationDataForReviewer = [
                'message' => 'Revision for Abstract ' . $submission->serial_number . ' rejected.',
                'link' => '/some-link',  // Update with the actual link to where the reviewer can view more details
            ];
            $user->notify(new NewUserNotification($notificationDataForReviewer));

            return redirect()->back()->with('success', 'Revision rejected and users notified successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while rejecting the revision.');
        }
    }

    public function rejectAssessment($serial_number)
    {
    try {
        // Retrieve the submission by serial number
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Store old reviewer reg no before updating
        $oldReviewerRegNo = $submission->reviewer_reg_no;

        // Update submission data
        $submission->update([
            'reviewer_reg_no' => null,
            'reviewer_status' => null,
            'final_status' => 'submitted',
        ]);
        $submission->score = null;
        $submission->save();

        // Notify reviewer
        if ($oldReviewerRegNo) {
            $reviewer = User::where('reg_no', $oldReviewerRegNo)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'reviewer');
                })
                ->first();
            
            if ($reviewer) {
                $notificationData = [
                    'message' => 'Assessment of ' . $submission->serial_number . ' lost.',
                    'link' => '/some-link',
                ];

                $reviewer->notify(new NewUserNotification($notificationData));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Score rejected successfully'
        ]);
            
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to reject score. Please try again later.'
        ], 500);
    }
    }

    public function returnRevision($serial_number)
    {
        try {
            // Find the submission
            $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

            // Ensure submission has a reviewer
            if (!$submission->reviewer_reg_no) {
                return response()->json([
                    'success' => false,
                    'message' => 'No reviewer assigned to this submission.',
                ], 400);
            }

            // Find the associated user
            $user = User::where('reg_no', $submission->reviewer_reg_no)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reviewer not found.',
                ], 404);
            }

            // Update submission status
            $submission->update([
                'final_status' => 'under_review',
            ]);
            $submission->score = null;
            $submission->save();

            // Send notification to the reviewer
            $notificationData = [
                'message' => 'You have a revision for ' . $submission->serial_number,
                'link' => '/some-link', // Replace with actual link
            ];
            $user->notify(new NewUserNotification($notificationData));

            return response()->json([
                'success' => true,
                'message' => 'Revision requested successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to request revision. Please try again later.',
            ], 500);
        }
    }
}
