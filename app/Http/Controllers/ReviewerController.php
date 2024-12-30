<?php

namespace App\Http\Controllers;

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
            ->whereNull('score')
            ->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)
            ->whereNull('score')
            ->get();

        $abstractCount = $submissions->count();
        $proposalCount = $researchSubmissions->count();
        
        return view('reviewer.partials.dashboard', compact('submissions', 'researchSubmissions', 'abstractCount', 'proposalCount'));
    }
    public function documentsReview()
    {
        $reviewer = Auth::user(); // Assuming the reviewer is logged in

        // Fetch abstracts assigned to the logged-in reviewer
        $submissions = AbstractSubmission::where('reviewer_reg_no', $reviewer->reg_no)
                ->whereNull('score')
                ->get();
        $researchSubmissions = ResearchSubmission::where('reviewer_reg_no', $reviewer->reg_no)
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
            'correction_type' => 'required|in:minor,major,reject',
            'correction_comments' => 'required|string',
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

        return redirect()->route('reviewer.partials.documents')
            ->with('success', 'Abstract assessment submitted successfully');
    }
}
