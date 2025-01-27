<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use App\Models\ResearchAssessment;
use App\Models\ProposalAssessment;
use App\Models\SubmissionType;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Dompdf\Dompdf;
use App\Jobs\SendNotificationJob;
use App\Notifications\NewUserNotification;
use App\Traits\DynamicTitleTrait;


class AdminController extends Controller
{
    use DynamicTitleTrait;
    public function dashboard(Request $request)
    {
        $admin = Auth::user();
        $searchQuery = $request->input('search', '');
        
        $perPage = request()->input('per_page', 10);
        $totalReviewers = Role::find(2)->users()->count();
        $totalUsers = Role::find(3)->users()->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::where('reviewer_status', Null)
            ->where('final_status', '!=','accepted')
            ->where('final_status', '!=','rejected')
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate($perPage);
        $researchSubmissions = ResearchSubmission::where('reviewer_status', Null)
            ->where('final_status', '!=','accepted')
            ->where('final_status', '!=','rejected')
            ->where(function ($query) use ($searchQuery) {
                $query->where('article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate($perPage);

        return view('admin.partials.dashboard', compact(
            'totalUsers',
             'totalAbstracts',
                    'totalProposals', 
                    'totalReviewers', 
                    'submissions', 
                    'researchSubmissions',
                    'searchQuery'));
    }
    public function users(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('reg_no', 'like', "%$search%")
                        ->orWhere('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
        })
        ->paginate(10);

        $roles = Role::all();
        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
            ]);
        }

        return view('admin.partials.users', compact('users','roles'));
    }
    public function documentsSearch(Request $request)
    {
        $search = $request->input('search');
        $submissions = AbstractSubmission::leftJoin('users', 'users.reg_no', '=', 'abstract_submissions.user_reg_no')
            ->select('abstract_submissions.*', 'users.first_name as user_name')
            ->where('approved', '!=', true)
            ->where(function ($query) use ($search) {
                $query->where('abstract_submissions.serial_number', 'like', "%$search%")
                    ->orWhere('abstract_submissions.title', 'like', "%$search%")
                    ->orWhere('users.first_name', 'like', "%$search%")
                    ->orWhere('users.last_name', 'like', "%$search%")
                    ->orWhere('users.reg_no', 'like', "%$search%");
            })
            ->paginate(10);
        $researchSubmissions = ResearchSubmission::leftJoin('users', 'users.reg_no', '=', 'research_submissions.user_reg_no')
            ->select('research_submissions.*', 'users.first_name as user_name')
            ->where('approved', '!=', true)
            ->where(function ($query) use ($search) {
                $query->where('research_submissions.serial_number', 'like', "%$search%")
                    ->orWhere('research_submissions.article_title', 'like', "%$search%")
                    ->orWhere('users.first_name', 'like', "%$search%")
                    ->orWhere('users.last_name', 'like', "%$search%")
                    ->orWhere('users.reg_no', 'like', "%$search%");
            })
            ->paginate(10);
        
        $reviewers = User::whereHas('roles', function ($query){
            $query->where('name', 'Reviewer');
        })->get();

        return view('admin.partials.documents', compact('submissions', 'researchSubmissions', 'reviewers'));
    }
    public function deleteDocuments($serial_number)
    {
        try {
            // Attempt to delete the abstract submission
            $submissions = AbstractSubmission::where('serial_number', $serial_number)->delete();

            // Attempt to delete the research submission, if it exists
            $researchSumissions = ResearchSubmission::where('serial_number', $serial_number)->delete();

            if ($submissions || $researchSumissions) {
                return response()->json([
                    'message' => 'Document deleted successfully.'
                ], 200);
            }

            return response()->json([
                'error' => 'No document found with the given serial number.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the document. Please try again later.'
            ], 500);
        }
    }
    public function deleteAssessment($serial_number)
    {
        try {
            // Attempt to delete the abstract submission
            $submissions = AbstractSubmission::where('serial_number', $serial_number)->delete();
            $assessments = ResearchAssessment::where('abstract_submission_id', $serial_number)->delete();

            // Attempt to delete the research submission, if it exists
            $researchSumissions = ResearchSubmission::where('serial_number', $serial_number)->delete();
            $proposalAssessments = ProposalAssessment::where('abstract_submission_id', $serial_number)->delete();

            if ($submissions || $researchSumissions || $assessments || $proposalAssessments) {
                return response()->json([
                    'message' => 'Document deleted successfully.'
                ], 200);
            }

            return response()->json([
                'error' => 'No document found with the given serial number.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the document. Please try again later.'
            ], 500);
        }
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
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id'
        ]);
        $user = User::where('reg_no', $reg_no)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'User not found.']);
        }
    
        // Sync the role with the user
        $user->roles()->sync($validated['roles'] ?? []);

    
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
        try {
            // Toggle the user's active status
            $user->active = !$user->active;
            $user->save();

            // Remove the user's role(s) and set it to blank
            $user->roles()->detach(); // This will remove all roles from the user

            return response()->json([
                'status' => $user->active ? 'activated' : 'deactivated',
                'active' => $user->active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to toggle user status',
                'message' => $e->getMessage(),
            ], 500); // Return 500 status code if there is an error
        }
    }
    public function activateUser(User $user)
    {
        // Toggle the user's active status
        $user->active = false;
        $user->save();

        // Remove the user's role(s) and set it to blank
        $user->roles()->detach(); // This will remove all roles from the user

        return response()->json([
            'status' => $user->active ? 'activated' : 'deactivated',
            'active' => $user->active,
        ]);

    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully!',
        ]);
    }

    public function submissions()
    {
        return view('admin.partials.submissions');
    }

    public function reports(Request $request)
    {
    $searchQuery = $request->input('search', '');
    $perPage = request()->input('per_page', 10);
    $data = [
        'submissions' => AbstractSubmission::with('user')
            ->whereNotNull('score')
            ->where('score', '!=', '')
            ->whereNotNull('admin_comments')
            ->where('admin_comments', '!=', '')
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate($perPage),
        'researchSubmissions' => ResearchSubmission::with('user')
            ->whereNotNull('score')
            ->where('score', '!=', '')
            ->where(function ($query) use ($searchQuery) {
                $query->where('article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate($perPage),
        'researchAssessments' => ResearchAssessment::with('abstractSubmission')->get(),
        'proposalAssessments' => ProposalAssessment::with('proposalSubmission')->get(),
        'searchQuery' => $searchQuery
    ];

    return view('admin.partials.reports', $data);
    }

    public function showAssessments($serial_number)
    {
        $perPage = request()->input('per_page', 10);
        $assessments = ResearchAssessment::where('abstract_submission_id', $serial_number)
            ->with('reviewer', 'user') // Load related reviewer and user
            ->paginate($perPage);  // Paginate the results

        return view('admin.partials.research_assessments', compact('assessments', 'serial_number'));
    }
    public function showProposalAssessments($serial_number)
    {
        $perPage = request()->input('per_page', 10);
        $proposalAssessments = ProposalAssessment::where('abstract_submission_id', $serial_number)
            ->with('reviewer', 'user') // Load related reviewer and user
            ->paginate($perPage);  // Paginate the results 

        return view('admin.partials.research_assessments', compact('proposalAssessments', 'serial_number'));
    }
    

    public function abstracts() {

        $perPage = request()->input('per_page', 10);

        // Get research submissions with their reviewer information using the relationship
        $submissions = AbstractSubmission::with('reviewers')         
            ->paginate($perPage);
            
        // Get all users with the 'Reviewer' role
        $reviewers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Reviewer');
        })->get();

        return view('admin.partials.abstracts', compact('submissions', 'reviewers'));
    }
    public function proposals() {

        $perPage = request()->input('per_page', 10);

        // Get research submissions with their reviewer information using the relationship
        $researchSubmissions = ResearchSubmission::with('reviewers')
            ->paginate($perPage);
            
        // Get all users with the 'Reviewer' role
        $reviewers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Reviewer');
        })->get();

        return view('admin.partials.proposal', compact('researchSubmissions', 'reviewers'));
    }
    
    public function fetchResearchSubmissions(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $search = $request->input('search', '');

    $query = ResearchSubmission::query()
        ->where('approved', '!=', true)
        ->with('reviewers')
        ->leftJoin('proposal_assessments', 'research_submissions.serial_number', '=', 'proposal_assessments.abstract_submission_id')
        ->select(
            'research_submissions.serial_number',
            'research_submissions.article_title',
            'research_submissions.created_at',
            'research_submissions.updated_at',
            'research_submissions.final_status', 
            'research_submissions.user_reg_no',
            // Add any other specific columns you need from abstract_submissions
            DB::raw('AVG(proposal_assessments.total_score) as average_score'),
            DB::raw('COUNT(proposal_assessments.abstract_submission_id) as total_reviews')
        )
        ->groupBy(
            'research_submissions.serial_number',
            'research_submissions.article_title',
            'research_submissions.created_at',
            'research_submissions.updated_at',
            'research_submissions.final_status', 
            'research_submissions.user_reg_no', 
            // Add the same columns here as in the select
        );
    // Apply search filter if provided
    if (!empty($search)) {
        $query->where('article_title', 'LIKE', "%{$search}%")
            ->orWhere('serial_number', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('reg_no', 'LIKE', "%{$search}%");
            });
    }

    // Fetch paginated data
    $researchSubmissions = $query->paginate($perPage);

    return response()->json([
        'data' => $researchSubmissions->items(),
        'current_page' => $researchSubmissions->currentPage(),
        'prev_page_url' => $researchSubmissions->previousPageUrl(),
        'next_page_url' => $researchSubmissions->nextPageUrl(),
        'total' => $researchSubmissions->total(),
        'per_page' => $researchSubmissions->perPage(),
    ]);
}
public function fetchAbstractSubmissions(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $search = $request->input('search', '');

    $query = AbstractSubmission::query()
        ->where('approved', '!=', true)
        ->with('reviewers')
        ->leftJoin('research_assessments', 'abstract_submissions.serial_number', '=', 'research_assessments.abstract_submission_id')
        ->select(
            'abstract_submissions.serial_number',
            'abstract_submissions.title',
            'abstract_submissions.created_at',
            'abstract_submissions.updated_at',
            'abstract_submissions.final_status', 
            'abstract_submissions.user_reg_no',
            // Add any other specific columns you need from abstract_submissions
            DB::raw('AVG(research_assessments.total_score) as average_score'),
            DB::raw('COUNT(research_assessments.abstract_submission_id) as total_reviews')
        )
        ->groupBy(
            'abstract_submissions.serial_number',
            'abstract_submissions.title',
            'abstract_submissions.created_at',
            'abstract_submissions.updated_at',
            'abstract_submissions.final_status', 
            'abstract_submissions.user_reg_no', 
            // Add the same columns here as in the select
        );
    // Apply search filter if provided
    if (!empty($search)) {
        $query->where('title', 'LIKE', "%{$search}%")
            ->orWhere('serial_number', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('reg_no', 'LIKE', "%{$search}%");
            });
    }

    // Fetch paginated data
    $submissions = $query->paginate($perPage);

    return response()->json([
        'data' => $submissions->items(),
        'current_page' => $submissions->currentPage(),
        'prev_page_url' => $submissions->previousPageUrl(),
        'next_page_url' => $submissions->nextPageUrl(),
        'total' => $submissions->total(),
        'per_page' => $submissions->perPage(),
    ]);
}
public function getReviewers()
{
    $reviewers = User::whereHas('roles', function ($query) {
        $query->where('name', 'reviewer');
    })->get();

    // Transform the collection into an array with only the required fields
    $reviewersArray = $reviewers->map(function ($reviewer) {
        return [
            'reg_no' => $reviewer->reg_no,
            'first_name' => $reviewer->first_name,
            'last_name' => $reviewer->last_name
        ];
    });

    return response()->json($reviewersArray);
}
    public function assignAbstractReviewer(Request $request, $serial_number)
    {
        $request->validate([
            'reg_no' => [
                'required',
                'exists:users,reg_no',
                function ($attribute, $value, $fail) {
                    if (!User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->exists()) {
                        $fail('The specified reviewer is not valid or does not have the reviewer role.');
                    }
                },
            ],
        ]);

        try {
            DB::transaction(function () use ($request, $serial_number) {
                // Find and update the submission in one query
                $submission = AbstractSubmission::where('serial_number', $serial_number)
                    ->lockForUpdate()  // Prevents race conditions
                    ->firstOrFail();
                
                $submission->reviewer_reg_no = $request->reg_no;
                $submission->save();

                // Queue notifications
                SendNotificationJob::dispatch($submission->user_reg_no, [
                    'message' => 'Abstract ' . $serial_number . ' is under review',
                    'link' => '/some-link',
                ]);

                SendNotificationJob::dispatch($request->reg_no, [
                    'message' => 'You have been assigned to review Abstract ' . $serial_number,
                    'link' => '/some-link',
                ]);
            });

            return redirect()->back()->with('success', 'Reviewer assigned successfully.');

        } catch (\Exception $e) {
            \Log::error('Reviewer assignment failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to assign reviewer. Please try again.');
        }
    }
    public function removeAbstractReviewer(Request $request, $serial_number)
    {
        try {
            DB::transaction(function () use ($serial_number) {
                // Find and update the submission in one query
                $submission = AbstractSubmission::where('serial_number', $serial_number)
                    ->lockForUpdate()  // Prevents race conditions
                    ->firstOrFail();

                $oldReviewerRegNo = $submission->reviewer_reg_no;

                // Remove the reviewer assignment
                $submission->update([
                    'reviewer_reg_no' => null,
                    'reviewer_status' => ''
                ]);

                // Only dispatch notification if there was a reviewer assigned
                if ($oldReviewerRegNo) {
                    // Check if the user exists and has reviewer role before sending notification
                    $reviewerExists = User::where('reg_no', $oldReviewerRegNo)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'reviewer');
                        })->exists();

                    if ($reviewerExists) {
                        SendNotificationJob::dispatch($oldReviewerRegNo, [
                            'message' => 'You have been removed from reviewing Abstract ' . $serial_number,
                            'link' => '/some-link',
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', 'Reviewer removed successfully.');

        } catch (\Exception $e) {
            \Log::error('Reviewer removal failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to remove reviewer. Please try again.');
        }
    }
    public function assignAbstractMassReviewer(Request $request)
    {
        $request->validate([
            'submissions' => 'required|array|min:1',
            'reviewers' => 'required|array|min:2|max:3',
            'reviewers.*' => [
                'required',
                'exists:users,reg_no',
                function ($attribute, $value, $fail) {
                    if (!User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'Reviewer');
                        })->exists()) {
                        $fail('The specified reviewer does not have the reviewer role.');
                    }
                },
            ],
        ],[
            'submissions.required' => 'You must select at least one abstract.',
            'submissions.min' => 'You must select at least one abstract.',
            'reviewers.min' => 'You must select at least two reviewers.',
            'reviewers.max' => 'You cannot select more than three reviewers.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Get the selected submissions with their current reviewers
                $submissions = AbstractSubmission::whereIn('serial_number', $request->submissions)
                    ->with('reviewers', 'user:reg_no')
                    ->get();

                // Track reassigned reviewers
                $reassignedReviewers = [];

                // Loop over each submission and assign reviewers
                foreach ($submissions as $submission) {
                    // Prepare reviewers data for syncing via the pivot table
                    $reviewersData = [];
                    foreach ($request->reviewers as $reviewerRegNo) {
                        $reviewersData[$reviewerRegNo] = ['created_at' => now(), 'updated_at' => now()];

                        // Check if this reviewer was already assigned to this submission
                        $existingReviewer = $submission->reviewers()->where('users.reg_no', $reviewerRegNo)->first();
                        if ($existingReviewer) {
                            // Track reassigned reviewers
                            $reassignedReviewers[] = $reviewerRegNo;

                            // Delete assessments for the reassigned reviewer
                            DB::table('research_assessments')
                                ->where('abstract_submission_id', $submission->serial_number)
                                ->where('reviewer_reg_no', $reviewerRegNo)
                                ->delete();
                        }
                    }

                    // Sync reviewers
                    $submission->reviewers()->syncWithoutDetaching($reviewersData);
                }

                // Remove duplicates from reassigned reviewers
                $reassignedReviewers = array_unique($reassignedReviewers);

                // Notify reviewers and authors
                $serialNumbersList = $submissions->pluck('serial_number')->implode(', ');

                // Notify new and reassigned reviewers
                foreach ($request->reviewers as $reviewerRegNo) {
                    $message = in_array($reviewerRegNo, $reassignedReviewers)
                        ? 'You have been reassigned the following abstracts for review: ' . $serialNumbersList
                        : 'You have been assigned the following abstracts for review: ' . $serialNumbersList;

                    SendNotificationJob::dispatch($reviewerRegNo, [
                        'message' => $message,
                        'link' => "/reviewer/assessment/abstract/{$submission->serial_number}"
                    ]);
                }

                // Notify authors
                $uniqueUserRegNos = $submissions->pluck('user_reg_no')->unique();
                foreach ($uniqueUserRegNos->chunk(100) as $userRegNoChunk) {
                    foreach ($userRegNoChunk as $userRegNo) {
                        SendNotificationJob::dispatch($userRegNo, [
                            'message' => 'Abstract(s) ' . $serialNumbersList . ' are under review.',
                            'link' => '/some-link'
                        ]);
                    }
                }
            });
            
            return response()->json([
                'message' => 'Reviewers assigned successfully!',
                'assigned_count' => count($request->submissions)
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'The given data was invalid.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while assigning reviewers.',
                'message' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
    public function assignProposalMassReviewer(Request $request)
    {
        $request->validate([
            'researchSubmissions' => 'required|array|min:1', // Ensure at least one submission is selected
            'reviewers' => 'required|array|min:2|max:3', // Require 2-3 reviewers
            'reviewers.*' => [
                'required',
                'exists:users,reg_no', // Ensure reviewers exist
                function ($attribute, $value, $fail) {
                    if (!User::where('reg_no', $value)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'Reviewer'); // Ensure the user has a "reviewer" role
                        })->exists()) {
                        $fail('The specified reviewer does not have the reviewer role.');
                    }
                },
            ],
        ],[
                // Custom messages for validation errors (optional)
                'researchSubmissions.required' => 'You must select at least one abstract.',
                'researchSubmissions.min' => 'You must select at least one abstract.',
                'reviewers.min' => 'You must select at least two reviewers.',
                'reviewers.max' => 'You cannot select more than three reviewers.',
        ] );
    
        try {
            DB::transaction(function () use ($request) {
                // Get the selected submissions with their authors in a single query
                $researchSubmissions = ResearchSubmission::whereIn('serial_number', $request->researchSubmissions)
                    ->with('user:reg_no') // Assuming there's a relationship with the User model
                    ->get();
                
                // Track reassigned reviewers
                $reassignedReviewers = [];
    
                // Loop over each submission and assign reviewers
                foreach ($researchSubmissions as $researchSubmission) {
                    // Prepare reviewers data for syncing via the pivot table
                    $reviewersData = [];
                    foreach ($request->reviewers as $reviewerRegNo) {
                        $reviewersData[$reviewerRegNo] = ['created_at' => now(), 'updated_at' => now()];

                        // Check if this reviewer was already assigned to this submission
                        $existingReviewer = $researchSubmission->reviewers()->where('users.reg_no', $reviewerRegNo)->first();
                        if ($existingReviewer) {
                            // Track reassigned reviewers
                            $reassignedReviewers[] = $reviewerRegNo;

                            // Delete assessments for the reassigned reviewer
                            DB::table('proposal_assessments')
                                ->where('abstract_submission_id', $researchSubmission->serial_number)
                                ->where('reviewer_reg_no', $reviewerRegNo)
                                ->delete();
                        }
                    }
    
                    // Use the 'reviewers' relationship to sync the reviewers
                    $researchSubmission->reviewers()->syncWithoutDetaching($reviewersData);
                }

                // Remove duplicates from reassigned reviewers
                $reassignedReviewers = array_unique($reassignedReviewers);
    
                // Notify reviewers and authors
                $serialNumbersList = $researchSubmission->pluck('serial_number')->implode(', ');
    
                // Notify new and reassigned reviewers
                foreach ($request->reviewers as $reviewerRegNo) {
                    $message = in_array($reviewerRegNo, $reassignedReviewers)
                        ? 'You have been reassigned the following abstracts for review: ' . $serialNumbersList
                        : 'You have been assigned the following abstracts for review: ' . $serialNumbersList;

                    SendNotificationJob::dispatch($reviewerRegNo, [
                        'message' => $message,
                        'link' => "/reviewer/assessment/proposal-view/{$researchSubmission->serial_number}"
                    ]);
                }
    
                // Notify authors
                $uniqueUserRegNos = $researchSubmissions->pluck('user_reg_no')->unique();
                foreach ($uniqueUserRegNos->chunk(100) as $userRegNoChunk) {
                    foreach ($userRegNoChunk as $userRegNo) {
                        SendNotificationJob::dispatch($userRegNo, [
                            'message' => 'Abstract(s) ' . $serialNumbersList . ' are under review.',
                            'link' => '/some-link'
                        ]);
                    }
                }
            });
            
            return response()->json([
                'message' => 'Reviewers assigned successfully!',
                'assigned_count' => count($request->researchSubmissions)
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'The given data was invalid.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while assigning reviewers.',
                'message' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
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
            $submission->admin_comments = "Approved";
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
            $submission->admin_comments = "Not Approved";
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
            $researchSubmission->admin_comments = "Approved";
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
            $researchSubmission->admin_comments = "Not Approved";
            $researchSubmission->save();
            $researchSubmission->save();
    
            return redirect()->back()->with('success', 'Proposal declined successfully.');
        }
        return redirect()->back()->with('error', 'Proposal not found.');
    }
    public function profile()
    {
        return view('admin.partials.profile');
    }
    public function requestArticleUpload(Request $request, $serial_number)
    {
        // Find the abstract submission by serial number with user relationship
        $submission = AbstractSubmission::with('user')
            ->where('serial_number', $serial_number)
            ->firstOrFail();

        // Update the request_made field to true
        $submission->request_made = true;
        $submission->save();
        
        // Prepare data for the notification
        $dataForUser = [
            'message' => 'Your abstract ' . $submission->serial_number . ' was reviewed. Please upload your article.',
            'link' => route('user.submit.article', ['serial_number' => $submission->serial_number]),
        ];
        
        // Dispatch notification job
        SendNotificationJob::dispatch($submission->user_reg_no, $dataForUser);

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

    public function abstractDetails($serial_number)
{
    // Find the submission with related reviewers
    $submission = AbstractSubmission::with(['reviewers' => function ($query) {
        $query->select('reg_no', 'first_name', 'last_name'); // Select necessary user fields
    }])
    ->where('serial_number', $serial_number)
    ->firstOrFail();

    // Pass the submission to the view
    return view('admin.partials.abstract_details', compact('submission'));
}
    public function proposalDetails($serial_number)
    {
        // Find the submission with related reviewers
        $researchSubmission = ResearchSubmission::with(['reviewers' => function ($query) {
            $query->select('reg_no', 'first_name', 'last_name'); // Select necessary user fields
        }])
        ->where('serial_number', $serial_number)
        ->firstOrFail();

        // Pass the submission to the view
        return view('admin.partials.proposal_details', compact('researchSubmission'));
    }

    public function index()
    {
        $submissionTypes = SubmissionType::all();
        return view('admin.partials.submissionsType', compact('submissionTypes'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:conference,research',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'deadline' => 'required|date',
            'format' => 'required|string|max:255',
            'guidelines' => 'nullable|string',
        ]);
    
        // Remove the dd() which was interrupting the process
        SubmissionType::create($validated);
    
        return redirect()->route('submission-types.index')
            ->with('success', 'Submission type created successfully.');
    }

    public function edit($id)
    {
        $submissionType = SubmissionType::findOrFail($id);
        return response()->json($submissionType);
    }

    public function update(Request $request, SubmissionType $submissionType)
    {
        $validated = $request->validate([
            'type' => 'required|in:conference,research',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'deadline' => 'required|date',
            'format' => 'required|string|max:255',
            'guidelines' => 'nullable|string',
        ]);

        $submissionType->update($validated);

        return redirect()->route('submission-types.index')
            ->with('success', 'Submission type updated successfully.');
    }

    public function destroy(SubmissionType $submissionType)
    {
        try {
            $submissionType->delete();
    
            return redirect()->route('submission-types.index')
                ->with('success', 'Submission type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('submission-types.index')
                ->with('error', 'Failed to delete submission type: ' . $e->getMessage());
        }
    }
}
