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


class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::user();

        $totalReviewers = Role::find(2)->users()->count();
        $totalUsers = Role::find(3)->users()->count();
        
        $totalAbstracts = AbstractSubmission::distinct('serial_number')->count();
        $totalProposals = ResearchSubmission::distinct('serial_number')->count();

        $submissions = AbstractSubmission::where('reviewer_status', Null)->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_status', Null)->get();

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
        $submissions = AbstractSubmission::with('user')->get();
        $researchSubmissions = ResearchSubmission::with('user')->get();

        return view('admin.partials.reports', compact('submissions', 'researchSubmissions'));
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
            'comments' => 'required|string|max:1000',
        ]);
        // Find the abstract by serial number
        $submission = AbstractSubmission::where('serial_number', $request->serial_number)->first();

        if ($submission) {
            // Reject the abstract
            $submission->final_status = "Rejected";
            $submission->admin_comments = $request->comments;
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
            $submission->final_status = "Accepted";
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


    public function downloadAssessmentPDF($serial_number)
    {
        $assessment = ResearchAssessment::with(['abstractSubmission', 'reviewer', 'user'])->findOrFail($serial_number);
        
        // Configure DomPDF options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        
        // Initialize DomPDF
        $dompdf = new Dompdf($options);
        
        // Generate HTML content
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Research Assessment Report</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #333;
                    padding-bottom: 10px;
                }
                .section {
                    margin-bottom: 20px;
                }
                .section-title {
                    background-color: #f5f5f5;
                    padding: 5px 10px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .score-box {
                    border: 1px solid #ddd;
                    padding: 10px;
                    margin-bottom: 10px;
                }
                .score {
                    font-size: 18px;
                    font-weight: bold;
                    color: #2c5282;
                }
                .comments {
                    margin-top: 5px;
                    padding: 10px;
                    background-color: #f8f8f8;
                }
                .meta-info {
                    margin-bottom: 20px;
                    padding: 10px;
                    background-color: #f0f4f8;
                }
                .correction-section {
                    margin-top: 20px;
                    padding: 10px;
                    border: 1px solid #e2e8f0;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Research Assessment Report</h1>
                <p>Generated on: ' . date('F d, Y') . '</p>
            </div>
            
            <div class="meta-info">
                <p><strong>Abstract ID:</strong> ' . $assessment->abstract_submission_id . '</p>
                <p><strong>Reviewer:</strong> ' . $assessment->reviewer->name . '</p>
                <p><strong>Author:</strong> ' . $assessment->user->name . '</p>
            </div>
            
            <div class="section">
                <div class="section-title">Thematic Assessment</div>
                <div class="score-box">
                    <div class="score">Score: ' . $assessment->thematic_score . '/10</div>
                    <div class="comments">' . nl2br($assessment->thematic_comments) . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Title Assessment</div>
                <div class="score-box">
                    <div class="score">Score: ' . $assessment->title_score . '/10</div>
                    <div class="comments">' . nl2br($assessment->title_comments) . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Objectives Assessment</div>
                <div class="score-box">
                    <div class="score">Score: ' . $assessment->objectives_score . '/10</div>
                    <div class="comments">' . nl2br($assessment->objectives_comments) . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Methodology Assessment</div>
                <div class="score-box">
                    <div class="score">Score: ' . $assessment->methodology_score . '/10</div>
                    <div class="comments">' . nl2br($assessment->methodology_comments) . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Output Assessment</div>
                <div class="score-box">
                    <div class="score">Score: ' . $assessment->output_score . '/10</div>
                    <div class="comments">' . nl2br($assessment->output_comments) . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">General Comments</div>
                <div class="comments">' . nl2br($assessment->general_comments) . '</div>
            </div>
            
            <div class="correction-section">
                <h3>Correction Requirements</h3>
                <p><strong>Type:</strong> ' . ucfirst($assessment->correction_type) . '</p>
                <div class="comments">' . nl2br($assessment->correction_comments) . '</div>
            </div>
            
            <div style="margin-top: 30px; text-align: center; font-size: 12px;">
                <p>This is an official assessment report. Please maintain confidentiality.</p>
            </div>
        </body>
        </html>';
        
        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Generate file name
        $fileName = 'Research_Assessment_' . $assessment->abstract_submission_id . '_' . date('Y-m-d') . '.pdf';
        
        // Download PDF
        return $dompdf->stream($fileName, ['Attachment' => true]);
    }

    public function returnRevision ()
    {
    
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

}
