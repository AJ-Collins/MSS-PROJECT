<?php

namespace App\Http\Controllers;

use App\Models\AbstractSubmission;
use App\Models\AbstractDraft;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AbstractSubmissionController extends Controller
{
    private const SESSION_KEYS = [
        'author',
        'all_authors',
        'abstract',
        'submission_type'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function step1(Request $request)
    {
        // Check if there's existing session data
        $author = session('author', []);
        $submissionType = session('submission_type', 'abstract');

        return view('user.partials.step1', compact('author', 'submissionType'));
    }

    public function postStep1(Request $request)
    {
        $validatedData = $request->validate([
            'authors' => 'required|array|min:1',
            'authors.*.first_name' => 'required|string|max:255',
            'authors.*.middle_name' => 'nullable|string|max:255',
            'authors.*.surname' => 'required|string|max:255',
            'authors.*.department' => 'required|string|max:255',
            'authors.*.university' => 'required|string|max:255',
            'authors.*.email' => 'required|email|max:255',
            'authors.*.is_correspondent' => 'sometimes|boolean',
            'submission_type' => 'required|in:abstract',
        ]);

        // Ensure 'is_correspondent' defaults to false if not provided
        foreach ($validatedData['authors'] as &$author) {
            $author['is_correspondent'] = $author['is_correspondent'] ?? false;
        }

        // Assign the primary author and store data in session
        $primaryAuthor = $validatedData['authors'][0];
        $allAuthors = $validatedData['authors'];

        session([
            'author' => $primaryAuthor,
            'all_authors' => $allAuthors,
            'submission_type' => $validatedData['submission_type']
        ]);

        return redirect()->route('user.step2')->with('success', 'Step 1 completed successfully.');
    }
    public function step2(Request $request)
    {
        $subThemes = [
            'Transformative Education',
            'Business and Entrepreneurship',
            'Health and Food Security',
            'Digital, Creative Economy and Contemporary Societies',
            'Engineering, Technology and Sustainable Environment',
            'Blue Economy & Maritime Affairs',
        ];

        // Check if step 1 is completed
        if (!Session::has('author')) {
            return redirect()->route('user.step1')
                ->with('error', 'Please complete author details first.');
        }

        // Get existing abstract data if available
        $abstract = array_merge([
            'article_title' => '',
            'sub_theme' => '',
            'abstract' => '',
            'keywords' => [],
        ], Session::get('abstract', []));

        if ($request->has('keywords')) {
            // Save keywords to session
            $abstract['keywords'] = array_filter($request->input('keywords'), function ($value) {
                return !empty($value); // Only save non-empty keywords
            });
            Session::put('abstract', $abstract);
        }

        return view('user.partials.step2', compact('abstract', 'subThemes'));
    }


   public function postStep2(Request $request)
    {
        $validatedData = $request->validate([
            'article_title' => 'required|string|max:500',
            'sub_theme' => 'required|string|max:500',
            'abstract' => 'required|string|max:5000',
            'keywords' => 'required|array|min:3|max:5',
            'keywords.*' => 'string|max:255',
        ]);

        // Store as array in session
        session([
            'abstract' => [
                'article_title' => $validatedData['article_title'],
                'sub_theme' => $validatedData['sub_theme'],
                'abstract' => $validatedData['abstract'],
                'keywords' => $validatedData['keywords'] ?? [],
            ]
        ]);

        return redirect()->route('user.preview');
    }
    public function preview(Request $request)
    {
        // Retrieve session data
        $article_title = $request->session()->get('article_title');
        $author = $request->session()->get('author');
        $abstract = $request->session()->get('abstract');
        $allAuthors = $request->session()->get('all_authors');
    
        // Check if session data is available for required fields
        if (!$author || !$abstract || !$allAuthors) {
            return redirect()->route('user.step1')->with('error', 'Required data is missing. Please complete all steps.');
        }
        
        $correspondingAuthor = collect($allAuthors)->firstWhere('is_correspondent', true);

        // If abstract data is an array, convert it to an AbstractSubmission object for consistency
        if (!isset($abstract['keywords']) || !is_array($abstract['keywords'])) {
            $abstract['keywords'] = [];
        }
    
        // Passing data to the preview view
        return view('user.partials.preview', compact('author', 'abstract', 'allAuthors', 'article_title', 'correspondingAuthor'));
    }
    


    public function postPreview(Request $request)
    {
        $authorData = $request->session()->get('author');
        $abstractData = $request->session()->get('abstract');
        $allAuthors = $request->session()->get('all_authors');
    
        if (!$authorData || !$abstractData) {
            return redirect()->route('user.step1')->with('error', 'No author or abstract data available.');
        }
    
        // Save author(s)
        foreach ($allAuthors as $authorData) {
            $author = new Author($authorData);
            $author->save();
        }
    
        // Generate serial number
        $subTheme = $abstractData['sub_theme'];
        $acronyms = [
            'Transformative Education' => 'TE',
            'Business and Entrepreneurship' => 'BE',
            'Health and Food Security' => 'HFS',
            'Digital, Creative Economy and Contemporary Societies' => 'DCECS',
            'Engineering, Technology and Sustainable Environment' => 'ETSE',
            'Blue Economy & Maritime Affairs' => 'BEMA',
        ];
    
        $acronym = $acronyms[$subTheme] ?? 'N/A';
        $serialCode = mb_strtoupper(Str::random(mt_rand(4, 5)) . Str::random(mt_rand(3, 5)));
        $serialNumber = "{$acronym}-{$serialCode}-" . date('y');
    
        $user = auth()->user();
        // Save abstract
        $abstractSubmission = new AbstractSubmission();
        $abstractSubmission->serial_number = $serialNumber;
        $abstractSubmission->title = $abstractData['article_title'];
        $abstractSubmission->sub_theme = $abstractData['sub_theme'];
        $abstractSubmission->abstract = $abstractData['abstract'];
        $abstractSubmission->keywords = json_encode($abstractData['keywords']);
        $abstractSubmission->user_reg_no = $user->reg_no;
        $abstractSubmission->final_status = "Pending";
        $abstractSubmission->save();
    
        // Save all authors and associate with abstract submission
        foreach ($allAuthors as $authorData) {
            $authorData['abstract_submission_id'] = $serialNumber; // Associate the serial number
            $author = new Author($authorData);
            $author->save();
        }
    
        // Clear all session data related to the submission process
        $request->session()->forget(self::SESSION_KEYS);
    
        return redirect()->route('user.dashboard')->with('success', 'Submission successfully.');
    }    

}
