<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchSubmission;
use App\Models\AbstractDraft;
use App\Traits\DynamicTitleTrait;
use App\Models\SubmissionType;

class UserController extends Controller
{
    use DynamicTitleTrait;
    protected $notifications;
    protected $unreadCount;

    public function __construct()
    {
        $user = auth()->user();

        if ($user) {
            // Fetch notifications and unread count
            $this->notifications = $user->notifications;
            $this->unreadCount = $user->unreadNotifications->count();
        }
    }
    public function profile()
    {
        $user = auth()->user();
        
        return view('user.partials.profile');
    }
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $searchQuery = $request->input('search', '');
        
        // Count total abstracts 
        $totalAbstracts = AbstractSubmission::where('user_reg_no', $user->reg_no)->count();
        $totalArticles = AbstractSubmission::where('user_reg_no', $user->reg_no)
            ->where('pdf_path', '!=', null)
            ->count();
        $abstractsPending = AbstractSubmission::where('user_reg_no', $user->reg_no)
            ->where('final_status', 'submitted')
            
            ->count();
        

        // Count total research submissions
        $totalResearchSubmissions = ResearchSubmission::where('user_reg_no', $user->reg_no)->count();
        $proposalPending = ResearchSubmission::where('user_reg_no', $user->reg_no)->where('final_status', 'submitted')->count();
        
        $totalPendingCount = $abstractsPending + $proposalPending;

        $submissions = AbstractSubmission::where('user_reg_no', $user->reg_no)
            ->where('pdf_path',  null)
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);
        $researchSubmissions = ResearchSubmission::where('user_reg_no', $user->reg_no)
            ->where(function ($query) use ($searchQuery) {
                $query->where('article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);

        $draft = $this->getCurrentDraft();
        
        return view('user.partials.dashboard', [
            'submissions' => $submissions,
            'researchSubmissions' => $researchSubmissions,
            'totalAbstracts' => $totalAbstracts,
            'totalPendingCount' => $totalPendingCount,
            'totalResearchSubmissions' => $totalResearchSubmissions,
            'draft' => $draft,
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
            'totalArticles' => $totalArticles,
            'searchQuery' => $searchQuery

        ]);
    }
    public function documents(Request $request)
    {
        $user = auth()->user();
        $searchQuery = $request->input('search', '');

        $submissions = AbstractSubmission::where('user_reg_no', $user->reg_no)
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);
        $researchSubmissions = ResearchSubmission::where('user_reg_no', $user->reg_no)
            ->where(function ($query) use ($searchQuery) {
                $query->where('article_title', 'like', "%{$searchQuery}%")
                    ->orWhere('serial_number', 'like', "%{$searchQuery}%")
                    ->orWhere('sub_theme', 'like', "%{$searchQuery}%");
            })
            ->paginate(10);

        return view('user.partials.documents', compact(
            'submissions', 
            'researchSubmissions',
            'searchQuery'));
    }
    public function viewProposal($serial_number)
    {
        $userRegNo = auth()->user()->reg_no;

        $researchSubmission = ResearchSubmission::where('serial_number', $serial_number)
            ->where('user_reg_no', $userRegNo)
            ->firstOrFail();

        $submission = AbstractSubmission::where('serial_number', $serial_number)
            ->where('user_reg_no', $userRegNo)
            ->firstOrFail();

        return view('user.partials.document', compact('researchSubmission', 'submission'));
   
    }
    
    public function submit()
    {
        $submissionTypes = SubmissionType::all();
        return view('user.partials.submit', compact('submissionTypes'));
    }
    public function step2()
    {
        return view('user.partials.step2');
    }
    public function preview()
    {
        return view('user.partials.preview');
    }
    public function confirm()
    {
        return view('user.partials.confirm');
    }
    public function step1_research()
    {
        return view('user.partials.step1_research');
    }
    public function step2_research()
    {
        return view('user.partials.step2_research');
    }
    public function preview_research()
    {
        return view('user.partials.preview_research');
    }
    public function confirm_research()
    {
        return view('user.partials.confirm_research');
    }
    public function confirmSubmission(Request $request)
    {
        // Handle your form submission logic

        // Add success message to the session
        session()->flash('success', 'Your submission was successful!');

        // Redirect to dashboard
        return redirect()->route('user.dashboard');
    }

    private function getCurrentDraft()
    {
        return AbstractDraft::where('user_reg_no', auth()->user()->reg_no)
            ->first();

        if (!$draft) {
            return redirect()->route('user.dashboard')->withErrors('No draft available.');
        }
    }
    public function submitArticle($serial_number)
    {
        $submission = AbstractSubmission::where('serial_number', $serial_number)->firstOrFail();

        // Pass the submission record to the view
        return view('user.partials.article_upload', compact('submission'));
    }
    
}