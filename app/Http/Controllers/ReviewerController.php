<?php

namespace App\Http\Controllers;

use App\Models\ProposalAssessment;
use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use App\Models\ResearchAssessment;
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
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)
        ->where(function($query) {
            $query->where('reviewer_status', '')
                  ->orWhereNull('reviewer_status');
        })
        ->get();
            
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)
        ->where(function($query) {
            $query->where('reviewer_status', '')
                  ->orWhereNull('reviewer_status');
        })
        ->get();

        $abstractCount = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)->count();
        $proposalCount = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)->count();
        
        $newAbstractCount = $submissions->count();
        $newProposalCount = $researchSubmissions->count();
        
        
        return view('reviewer.partials.dashboard', compact(
            'submissions', 
            'researchSubmissions', 
            'abstractCount', 
            'proposalCount',
            'newAbstractCount',
            'newProposalCount'));
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
            $submission->save();
        }

        return back()->with('success', 'Reviewer status updated successfully!');
    }

    public function abstractReject(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|exists:abstract_submissions,serial_number',
        ]);

        $submission = AbstractSubmission::find($request->serial_number);

        if ($submission) {
            // Update the reviewer status
            $submission->reviewer_status = '';

            // Remove the reviewer_reg_no (set it to null)
            $submission->reviewer_reg_no = null;

            // Save the changes
            $submission->save();
        }

        return back()->with('success', 'Reviewer status updated and reviewer unassigned successfully!');
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
    public function documentsReview()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)
                ->where('reviewer_status', 'accepted')
                ->whereNull('score')
                ->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)
                ->where('reviewer_status', 'accepted')
                ->whereNull('score')
                ->get();

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
    public function revieweddocuments()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)
                ->whereNotNull('score')
                ->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)
                ->whereNotNull('score')
                ->get();

        $abstractCount = $submissions->count();
        $proposalCount = $researchSubmissions->count();

        return view('reviewer.partials.revieweddocuments', compact('submissions', 'researchSubmissions', 'abstractCount', 'proposalCount'));
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
            ->whereNull('score')
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
            'keywords' => $abstract->keywords,
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
            ->whereNull('score')
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
            'keywords' => $abstract->keywords,
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
                'user_reg_no' => auth()->user()->reg_no
            ],
            $validated
        );

        AbstractSubmission::where('serial_number', $serial_number)->update([
            'score' => $validated['total_score']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Abstract assessment submitted successfully',
            'redirect' => route('reviewer.partials.documents')
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
            
            $user = auth()->user();
        // Update or create assessment for this abstract
        ProposalAssessment::updateOrCreate(
            [
                'abstract_submission_id' => $serial_number,
                'reviewer_reg_no' => auth()->user()->reg_no,
                'user_reg_no' => auth()->user()->reg_no
            ],
            $validated
        );

        ResearchSubmission::where('serial_number', $serial_number)->update([
            'score' => $validated['total_score']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proposal assessment submitted successfully',
            'redirect' => route('reviewer.partials.documents')
        ]);
    }
}
