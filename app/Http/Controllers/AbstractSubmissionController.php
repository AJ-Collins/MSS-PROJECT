<?php

namespace App\Http\Controllers;

use App\Models\AbstractSubmission;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Models\User; 

class AbstractSubmissionController extends Controller
{
    public function step1(Request $request)
    {
        $author = $request->session()->get('author');

        $submissionType = $request->input('submission_type', 'default_value');

        return view('user.partials.step1', compact('author', 'submissionType'));
    }

    public function postStep1(Request $request)
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

    return redirect()->route('user.step2');
}
    public function step2(Request $request)
    {
        $abstract = $request->session()->get('abstract');
        return view('user.partials.step2', compact('abstract'));
    }

   public function postStep2(Request $request)
{
    $validatedData = $request->validate([
        'article_title' => 'required|string|max:500',
        'sub_theme' => 'required|string|max:500',
        'abstract' => 'required|string|max:5000',
        'keywords' => 'array',
        'keywords.*' => 'string|max:255',
    ]);

    // Store as array in session
    $request->session()->put('abstract', $validatedData);

    return redirect()->route('user.preview');
}
    public function preview(Request $request)
{
    $author = $request->session()->get('author');
    $abstract = $request->session()->get('abstract');
    $allAuthors = $request->session()->get('all_authors');

    if (!$abstract instanceof AbstractSubmission) {
        $abstract = new AbstractSubmission((array)$abstract);
    }
    
    if (!$author) {
        return redirect()->route('user.step1')->with('error', 'No author data available.');
    }

    return view('user.partials.preview', compact('author', 'abstract', 'allAuthors'));
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

    $request->session()->forget(['author', 'abstract', 'all_authors']);
    return redirect()->route('submit.confirm')->with('success', 'Submission successfully stored.');
}

}
