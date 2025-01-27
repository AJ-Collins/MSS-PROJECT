<?php

namespace App\Http\Controllers;

use App\Models\ProposalAssessment;
use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use App\Models\ResearchAssessment;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewUserNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\DynamicTitleTrait;


class ReviewerController extends Controller
{
    use DynamicTitleTrait;
    public function profile()
    {
        return view('reviewer.partials.profile');
    }
    public function dashboard(Request $request)
    {
        $reviewer = Auth::user();
        $searchQuery = $request->input('search', '');

        // Fetch pending abstract submissions with search
        $submissions = $reviewer->abstractSubmissions()
            ->wherePivot('status', 'pending')
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(5);

        // Fetch pending research submissions with search
        $researchSubmissions = $reviewer->researchSubmissions()
            ->wherePivot('status', 'pending')
            ->where(function ($query) use ($searchQuery) {
                $query->where('article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(5);

        // Get total counts of all assignments (regardless of status)
        $abstractCount = $reviewer->abstractSubmissions()->count();
        $proposalCount = $reviewer->researchSubmissions()->count();

        // Get counts of pending submissions
        $newAbstractCount = $reviewer->abstractSubmissions()
            ->wherePivot('status', 'pending')
            ->count();

        $newProposalCount = $reviewer->researchSubmissions()
            ->wherePivot('status', 'pending')
            ->count();

        return view('reviewer.partials.dashboard', compact(
            'submissions',
            'researchSubmissions',
            'abstractCount',
            'proposalCount',
            'newAbstractCount',
            'newProposalCount',
            'searchQuery'
        ));
    }
    public function abstractStatus(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
            'reviewer_status' => 'required|string',
        ]);

        $submission = AbstractSubmission::find($request->serial_number);
        if ($submission) {
            $submission->reviewer_status = $request->reviewer_status;
            $submission->final_status = 'under_review';
            $submission->save();
        }

        return back()->with('success', 'Reviewer status updated successfully!');
    }

    public function acceptAssignment(Request $request, string $serial_number)
    {
        $success = auth()->user()->acceptAbstractAssignment($serial_number);
        
        if ($success) {
            return redirect()->back()->with(['message' => 'Assignment accepted successfully']);
        }
        
        return redirect()->back()->with(['message' => 'Unable to accept assignment'], 404);
    }

    public function declineAssignment(Request $request, string $serial_number)
    {
        $success = auth()->user()->declineAbstractAssignment(
            $serial_number
        );
        
        if ($success) {
            return response()->json(['message' => 'Assignment declined successfully']);
        }
        
        return response()->json(['message' => 'Unable to decline assignment'], 404);
    }
    public function acceptProposal(Request $request, string $serial_number)
    {
        $success = auth()->user()->acceptProposalAssignment($serial_number);
        
        if ($success) {
            return redirect()->back()->with('success', 'Assignment accepted successfully');
        }
        
        return redirect()->back()->with('error', 'Unable to accept assignment');
    }
    public function rejectProposal(Request $request, string $serial_number)
    {
        $success = auth()->user()->rejectProposalAssignment($serial_number);
        
        if ($success) {
            return response()->json(['message' => 'Assignment accepted successfully']);
        }
        
        return response()->json(['message' => 'Unable to accept assignment'], 404);
    }
    public function proposalStatus(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
            'reviewer_status' => 'required|string',
        ]);

        $researchSubmission = ResearchSubmission::find($request->serial_number);
        if ($researchSubmission) {
            $researchSubmission->reviewer_status = $request->reviewer_status;
            $researchSubmission->save();
        }

        return back()->with('success', 'Reviewer status updated successfully!');
    }
    public function proposalReject(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|exists:research_submissions,serial_number',
        ]);

        $researchSubmission = ResearchSubmission::find($request->serial_number);

        if ($researchSubmission) {
            // Update the reviewer status
            $researchSubmission->reviewer_status = '';

            // Remove the reviewer_reg_no (set it to null)
            $researchSubmission->reviewer_reg_no = null;

            // Save the changes
            $researchSubmission->save();
        }

        return back()->with('success', 'Reviewer status updated and reviewer unassigned successfully!');
    }
    public function documentsReview(Request $request)
    {
        $reviewer = Auth::user();
        $searchQuery = $request->input('search', '');

        // Fetch abstracts assigned to the reviewer with pending status
        $submissions = $reviewer->abstractSubmissions()
            ->wherePivot('status', 'accepted')
            ->leftJoin('research_assessments', function ($join) use ($reviewer) {
                $join->on('abstract_submissions.serial_number', '=', 'research_assessments.abstract_submission_id')
                    ->where('research_assessments.reviewer_reg_no', $reviewer->reg_no);
            })
            ->whereNull('research_assessments.total_score')
            ->select(
                'abstract_submissions.*', 
                'research_assessments.total_score as reviewer_total_score'
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('abstract_submissions.title', 'like', "%{$searchQuery}%")
                    ->orWhere('abstract_submissions.serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('abstract_submissions.sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);

        // Fetch research submissions with pending status
        $researchSubmissions = $reviewer->researchSubmissions()
            ->wherePivot('status', 'accepted')
            ->leftJoin('proposal_assessments', function ($join) use ($reviewer) {
                $join->on('research_submissions.serial_number', '=', 'proposal_assessments.abstract_submission_id')
                    ->where('proposal_assessments.reviewer_reg_no', $reviewer->reg_no);
            })
            ->whereNull('proposal_assessments.total_score')
            ->select(
                'research_submissions.*', 
                'proposal_assessments.total_score as reviewer_total_score'
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('research_submissions.article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('research_submissions.serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('research_submissions.sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);

        $abstractCount = $submissions->total();
        $proposalCount = $researchSubmissions->total();

        return view('reviewer.partials.documents', compact(
            'submissions', 
            'researchSubmissions', 
            'abstractCount', 
            'proposalCount',
            'searchQuery'
        ));
    }
    public function assignedAbstracts()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submission = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->get();

        return view('reviewer.partials.dashboard', compact('submission'));
    }
    public function getAbstract($serial_number)
    {
        $abstract = AbstractSubmission::with('authors')->where('serial_number', $serial_number)->first();

        if (!$abstract) {
            return response()->json(['error' => 'Abstract not found'], 404);
        }

        $keywords = json_decode($abstract->keywords);
        // Format keywords as comma-separated string
        $formattedKeywords = is_array($keywords) ? implode(', ', $keywords) : '';
        
        $authors = $abstract->authors->map(function ($author) {
            return [
                'first_name' => $author->first_name,
                'middle_name' => $author->middle_name,
                'surname' => $author->surname,
                'university' => $author->university,
                'department' => $author->department,
                'is_correspondent' => $author->is_correspondent,
            ];
        });

        return response()->json([
            'title' => $abstract->title,
            'abstract' => $abstract->abstract,
            'keywords' => $formattedKeywords,
            'sub_theme' => $abstract->sub_theme,
            'authors' => $authors,
        ]);
    }

    public function getProposal($serial_number)
    {
        $abstract = ResearchSubmission::with('authors')->where('serial_number', $serial_number)->first();

        if (!$abstract) {
            return response()->json(['error' => 'Abstract not found'], 404);
        }

        $keywords = json_decode($abstract->keywords);
        // Format keywords as comma-separated string
        $formattedKeywords = is_array($keywords) ? implode(', ', $keywords) : '';
        
        $authors = $abstract->authors->map(function ($author) {
            return [
                'first_name' => $author->first_name,
                'middle_name' => $author->middle_name,
                'surname' => $author->surname,
                'university' => $author->university,
                'department' => $author->department,
                'is_correspondent' => $author->is_correspondent,
            ];
        });

        return response()->json([
            'title' => $abstract->article_title,
            'abstract' => $abstract->abstract,
            'keywords' => $formattedKeywords,
            'sub_theme' => $abstract->sub_theme,
            'authors' => $authors,
        ]);
    }
    public function revieweddocuments(Request $request)
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in
        $searchQuery = $request->input('search', '');

        // Fetch abstracts reviewed by the logged-in reviewer
        $submissions = $reviewer->abstractSubmissions()
            ->leftJoin('research_assessments', function ($join) use ($reviewer) {
                $join->on('abstract_submissions.serial_number', '=', 'research_assessments.abstract_submission_id')
                    ->where('research_assessments.reviewer_reg_no', $reviewer->reg_no);
            })
            ->select(
                'abstract_submissions.*', 
                'research_assessments.total_score as reviewer_total_score'
            )
            ->whereNotNull('research_assessments.total_score')
            ->where(function ($query) use ($searchQuery) {
                $query->where('abstract_submissions.title', 'like', "%{$searchQuery}%")
                      ->orWhere('abstract_submissions.serial_number', 'like', "%{$searchQuery}%")
                      ->orWhere('abstract_submissions.sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(20);

        // Fetch research submissions reviewed by the logged-in reviewer
        $researchSubmissions = $reviewer->researchSubmissions()
            ->leftJoin('proposal_assessments', function ($join) use ($reviewer) {
                $join->on('research_submissions.serial_number', '=', 'proposal_assessments.abstract_submission_id')
                    ->where('proposal_assessments.reviewer_reg_no', $reviewer->reg_no);
            })
            ->select(
                'research_submissions.*', 
                'proposal_assessments.total_score as reviewer_total_score'
            )
            ->whereNotNull('proposal_assessments.total_score')
            ->where(function ($query) use ($searchQuery) {
                $query->where('research_submissions.article_title', 'like', "%{$searchQuery}%")
                      ->orWhere('research_submissions.serial_number', 'like', "%{$searchQuery}%")
                      ->orWhere('research_submissions.sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(20);

        $abstractCount = $submissions->total();
        $proposalCount = $researchSubmissions->total();

        return view('reviewer.partials.revieweddocuments', compact(
            'submissions', 
            'researchSubmissions', 
            'abstractCount', 
            'proposalCount',
            'searchQuery'));
    }

    public function AbstractAssessment($serial_number)
    {
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);
        
        // Retrieve existing assessment or initialize an empty one
        $ResearchAssessment = ResearchAssessment::firstOrNew(
            [
                'abstract_submission_id' => $serial_number,
                'reviewer_reg_no' => auth()->user()->reg_no,
                'user_reg_no' => auth()->user()->reg_no
            ]
        );

        return view('reviewer.partials.assessment', compact('submission', 'ResearchAssessment', 'serial_number'));
    }
    public function ProposalAssessment($serial_number)
    {
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);
        
        // Retrieve existing assessment or initialize an empty one
        $ResearchAssessment = ResearchAssessment::firstOrNew(
            [
                'abstract_submission_id' => $serial_number,
                'reviewer_reg_no' => auth()->user()->reg_no,
                'user_reg_no' => auth()->user()->reg_no
            ]
        );

        return view('reviewer.partials.proposalAssessment', compact('researchSubmission', 'ResearchAssessment', 'serial_number'));
    }

    public function AbstracPreview($serial_number)
    {
        $abstract = AbstractSubmission::where('serial_number', $serial_number)
            ->with(['authors' => function ($query) {
                $query->select('first_name', 'middle_name', 'surname', 'abstract_submission_id')->distinct();
            }])
            ->first();

        if (!$abstract) {
            return response()->json(['error' => 'Abstract not found'], 404);
        }

        return response()->json([
            'title' => $abstract->title,
            'content' => $abstract->abstract,
            'keywords' => array_map('trim', json_decode($abstract->keywords, true) ?? []),
            'sub_theme' => $abstract->sub_theme,
            'authors' => $abstract->authors->map(function ($author) {
                return [
                    'first_name' => $author->first_name,
                    'middle_name' => $author->middle_name,
                    'surname' => $author->surname,
                ];
            }),
        ]);
    }
    public function ProposalPreview($serial_number)
    {
        $abstract = ResearchSubmission::where('serial_number', $serial_number)
            ->with(['authors' => function ($query) {
                $query->select('first_name', 'middle_name', 'surname', 'research_submission_id')->distinct();
            }])
            ->first();

        if (!$abstract) {
            return response()->json(['error' => 'Abstract not found'], 404);
        }

        return response()->json([
            'title' => $abstract->article_title,
            'content' => $abstract->abstract,
            'keywords' => array_map('trim', json_decode($abstract->keywords, true) ?? []),
            'sub_theme' => $abstract->sub_theme,
            'authors' => $abstract->authors->map(function ($author) {
                return [
                    'first_name' => $author->first_name,
                    'middle_name' => $author->middle_name,
                    'surname' => $author->surname,
                ];
            }),
        ]);
    }

    public function AbstractAssessmentStore(Request $request, $serial_number)
    {
        $validated = $request->validate([
            'thematic_score' => 'required|integer|min:0|max:5',
            'thematic_comments' => 'required|string',
            'title_score' => 'required|integer|min:0|max:5',
            'title_comments' => 'required|string',
            'objectives_score' => 'required|integer|min:0|max:5',
            'objectives_comments' => 'required|string',
            'methodology_score' => 'required|integer|min:0|max:30',
            'methodology_comments' => 'required|string',
            'output_score' => 'required|integer|min:0|max:5',
            'output_comments' => 'required|string',
            'general_comments' => 'required|string',
            'correction_type' => 'nullable|string|in:minor,major,reject',
            'correction_comments' => 'string',
        ]);

        // Calculate total score
        $validated['total_score'] = 
            $validated['thematic_score'] +
            $validated['title_score'] +
            $validated['objectives_score'] +
            $validated['methodology_score'] +
            $validated['output_score'];
            
            $user = auth()->user();
        // Update or create assessment for this abstract
        ResearchAssessment::updateOrCreate(
            [
                'abstract_submission_id' => $serial_number,
                'reviewer_reg_no' => auth()->user()->reg_no,
            ],
            array_merge($validated, [
                'user_reg_no' => AbstractSubmission::where('serial_number', $serial_number)->value('user_reg_no')
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Abstract assessment submitted successfully',
            'redirect' => route('reviewer.documents')
        ]);
    }

    public function ProposalAssessmentStore(Request $request, $serial_number)
    {
        $validated = $request->validate([
            'thematic_score' => 'required|integer|min:0|max:5',
            'thematic_comments' => 'required|string',
            'title_score' => 'required|integer|min:0|max:5',
            'title_comments' => 'required|string',
            'objectives_score' => 'required|integer|min:0|max:5',
            'objectives_comments' => 'required|string',
            'methodology_score' => 'required|integer|min:0|max:30',
            'methodology_comments' => 'required|string',
            'output_score' => 'required|integer|min:0|max:5',
            'output_comments' => 'required|string',
            'general_comments' => 'required|string',
            'correction_type' => 'nullable|string|in:minor,major,reject',
            'correction_comments' => 'string',
        ]);

        // Calculate total score
        $validated['total_score'] = 
            $validated['thematic_score'] +
            $validated['title_score'] +
            $validated['objectives_score'] +
            $validated['methodology_score'] +
            $validated['output_score'];

        // Update or create assessment for this abstract
        ProposalAssessment::updateOrCreate(
            [
                'abstract_submission_id' => $serial_number,
                'reviewer_reg_no' => auth()->user()->reg_no
            ],
            array_merge($validated, [
                'user_reg_no' => ResearchSubmission::where('serial_number', $serial_number)->value('user_reg_no')
            ])
        );

        ResearchSubmission::where('serial_number', $serial_number)->update([
            'score' => $validated['total_score']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proposal assessment submitted successfully',
            'redirect' => route('reviewer.documents')
        ]);
    }

    public function requestAbstractRevision (Request $request, $serial_number)
    {
        try {
            // Find the abstract submission
            $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();
    
            // Ensure that the current user is the assigned reviewer
            $reviewerRegNo = auth()->user()->reg_no;
            if ($submission->reviewer_reg_no !== $reviewerRegNo) {
                return redirect()->back()->with('error', 'You are not authorized to request a revision for this abstract.');
            }
    
            // Update the abstract submission status and other relevant fields
            $submission->final_status = 'revision_required';
            $submission->score = Null;
            $submission->save();

            $admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->first();

            $notificationData = [
                'message' => 'Revision request for abstract: ' . $submission->serial_number,
                'link' => route('admin.documents', ['serial_number' => $serial_number]),
                'user_reg_no' => $admin->reg_no,
            ];
    
            $admin->notify(new NewUserNotification($notificationData));
    
            return response()->json(['message' => 'Revision requested successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
