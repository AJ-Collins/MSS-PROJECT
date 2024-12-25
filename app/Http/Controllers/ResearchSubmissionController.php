<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchSubmission;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ResearchSubmissionController extends Controller
{
    public function step1_research(Request $request)
    {
        $author = $request->session()->get('author');

        $submissionType = $request->input('submission_type', 'default_value');

        return view('user.partials.step1_research', compact('author', 'submissionType'));
    }

    public function postStep1_research(Request $request)
    {
        $validatedData = $request->validate([
            'authors.*.first_name' => 'required|string',
            'authors.*.middle_name' => 'required|string',
            'authors.*.surname' => 'required|string',
            'authors.*.department' => 'required|string',
            'authors.*.university' => 'required|string',
            'authors.*.email' => 'required|email',
            'authors.*.is_correspondent' => 'sometimes|boolean',
            'submission_type' => 'required|in:abstract',
        ]);

        // Store the first author's data in session
        $primaryAuthor = $validatedData['authors'][0];
        $request->session()->put('author', $primaryAuthor);
    
        // Store all authors in session for later use
        $request->session()->put('all_authors', $validatedData['authors']);

        return redirect()->route('user.step2_research');
    }  
    public function step2_research(Request $request)
    {
        $abstract = $request->session()->get('abstract');
        return view('user.partials.step2_research', compact('abstract'));
    }
    public function postStep2_research(Request $request)
{
    $validatedData = $request->validate([
        'article_title' => 'required|string|max:500',
        'sub_theme' => 'required|string|max:500',
        'abstract' => 'required|string|max:5000',
        'keywords' => 'array|max:10',
        'keywords.*' => 'string|max:255',
        'pdf_document' => 'required|file|mimes:pdf,doc,docx|max:102400',
    ]);

    // Prevent duplicate submissions
    if ($request->session()->has('submission_data')) {
        return redirect()->route('submit.preview_research')
            ->with('message', 'You have already submitted this abstract.');
    }

    try {
        $path = null;

        // Handle file upload
        if ($request->hasFile('pdf_document')) {
            $file = $request->file('pdf_document');
            $filename = uniqid('research_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('research_proposals', $filename, 'public');
            $validatedData['pdf_document_path'] = 'storage/' . $path; // Add file path to the validated data
        }

        // Get author data from session
        $author = $request->session()->get('author', []);

        // Store necessary data in session
        $submissionData = [
            'author' => $author,
            'article_title' => $validatedData['article_title'],
            'sub_theme' => $validatedData['sub_theme'],
            'abstract' => $validatedData['abstract'],
            'keywords' => $validatedData['keywords'] ?? [],
            'pdf_document_path' => $validatedData['pdf_document_path'] ?? null,
        ];
        $request->session()->put('submission_data', $submissionData);

        return redirect()->route('user.preview_research')->with('success', 'Abstract and proposal saved successfully.');
    } catch (\Exception $e) {
        // Clean up uploaded file if any error occurs
        if (isset($path)) {
            Storage::disk('public')->delete($path);
        }

        return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
}

public function preview_research(Request $request)
{
    $authorData = session()->get('author');
    $submissionData = $request->session()->get('submission_data');
    
    if (!$submissionData) {
        return redirect()->route('submit.step2_research')
            ->with('error', 'No submission data found.');
    }

    // Ensure keywords is always an array
    $keywords = $submissionData['keywords'] ?? [];
    if (is_string($keywords)) {
        $keywords = array_filter(explode(',', $keywords));
    } elseif (!is_array($keywords)) {
        $keywords = [];
    }

    // Make sure abstract data is set in session
    $articleTitle = $submissionData['article_title'] ?? 'N/A';
    $subTheme = $submissionData['sub_theme'] ?? 'N/A';
    $abstract = $submissionData['abstract'] ?? 'No abstract provided';

    return view('user.partials.preview_research', [
        'authorData' => $authorData,  // Pass author data to the view
        'articleTitle' => $articleTitle,
        'subTheme' => $subTheme,
        'abstract' => $abstract,
        'keywords' => $keywords,
        'documentPath' => $submissionData['pdf_document_path'] ?? null
    ]);
}

public function postPreview_research(Request $request)
{
    // Retrieve session data
    $authorData = $request->session()->get('author');
    $submissionData = $request->session()->get('submission_data');

    if (!$authorData || !$submissionData) {
        return redirect()->route('user.step1_research')->with('error', 'No author or submission data available.');
    }

    // Save author(s) data
    foreach ($request->session()->get('all_authors', []) as $authorData) {
        $author = new Author($authorData);
        $author->save();
    }

    // Generate serial number for research submission
    $subTheme = $submissionData['sub_theme'];
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

    // Save research abstract submission data
    $researchSubmission = new ResearchSubmission();
    $researchSubmission->serial_number = $serialNumber;
    $researchSubmission->article_title = $submissionData['article_title'];
    $researchSubmission->sub_theme = $submissionData['sub_theme'];
    $researchSubmission->abstract = $submissionData['abstract'];
    $researchSubmission->keywords = json_encode($submissionData['keywords']);
    $researchSubmission->pdf_document_path = $submissionData['pdf_document_path'] ?? null;
    $researchSubmission->user_reg_no = $user->reg_no;
    $researchSubmission->save();

    // Clear session data after submission
    $request->session()->forget(['author', 'submission_data', 'all_authors']);

    // Return success response
    return redirect()->route('submit.confirm')->with('success', 'Research submission successfully stored.');
}


}
