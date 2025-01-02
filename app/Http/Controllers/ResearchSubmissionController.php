<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchSubmission;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Dompdf\Dompdf;
use Dompdf\Options;


class ResearchSubmissionController extends Controller
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


    public function step1_research(Request $request)
    {
        $author = $request->session()->get('author', []);
        $submissionType = $request->input('submission_type', 'abstract');

        return view('user.partials.step1_research', compact('author', 'submissionType'));
    }

    public function postStep1_research(Request $request)
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

        foreach ($validatedData['authors'] as &$author) {
            $author['is_correspondent'] = $author['is_correspondent'] ?? false;
        }

        // Store the first author's data in session
        $primaryAuthor = $validatedData['authors'][0];
        $allAuthors = $validatedData['authors'];
    
        // Store all authors in session
        session([
            'author' => $primaryAuthor,
            'all_authors' => $allAuthors,
            'submission_type' => $validatedData['submission_type']
        ]);

        return redirect()->route('user.step2_research')->with('success', 'Step 1 completed successfully.');
    }  
    public function step2_research(Request $request)
    {
        $subThemes = [
            'Transformative Education',
            'Business and Entrepreneurship',
            'Health and Food Security',
            'Digital, Creative Economy and Contemporary Societies',
            'Engineering, Technology and Sustainable Environment',
            'Blue Economy & Maritime Affairs',
        ];
        if (!Session::has('author')) {
            return redirect()->route('user.step1')
                ->with('error', 'Please complete author details first.');
        }

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
        return view('user.partials.step2_research', compact('abstract', 'subThemes'));
    }
    // Fix by modifying the session and file handling:
    public function postStep2_research(Request $request)
    {
        $validatedData = $request->validate([
            'article_title' => 'required|string|max:500',
            'sub_theme' => 'required|string|max:500',
            'abstract' => 'required|string|max:5000',
            'keywords' => 'required|array|min:3|max:5',
            'keywords.*' => 'required|string|max:255',
            'pdf_document' => [
                function ($attribute, $value, $fail) {
                    if (!$value && !session()->has('abstract.pdf_document_path')) {
                        $fail('The pdf document field is required.');
                    }
                }
            ],
        ]);

        try {
            // Handle file upload first
            if ($request->hasFile('pdf_document')) {
                $file = $request->file('pdf_document');
                $filename = uniqid('research_') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('research_proposals', $filename, 'public');
                $pdfPath = 'storage/' . $path;
            } else {
                $pdfPath = session('abstract.pdf_document_path');
            }

            // Store all data in session
            session([
                'abstract' => [
                    'article_title' => $validatedData['article_title'],
                    'sub_theme' => $validatedData['sub_theme'],
                    'abstract' => $validatedData['abstract'],
                    'keywords' => $validatedData['keywords'],
                    'pdf_document_path' => $pdfPath
                ],
            ]);

            return redirect()->route('user.preview_research')->with('success', 'Abstract and proposal saved successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function preview_research(Request $request)
    {
        // Retrieve session data
        $author = $request->session()->get('author');
        $allAuthors = $request->session()->get('all_authors');
        $abstract = $request->session()->get('abstract');
        
        // Handle case where abstract data may not be complete
        $articleTitle = $abstract['article_title'] ?? 'Untitled';
        $subTheme = $abstract['sub_theme'] ?? '';
        $keywords = $abstract['keywords'] ?? [];
        $documentPath = $abstract['pdf_document_path'] ?? null;

        if (!$author || !$abstract || !$allAuthors) {
            return redirect()->route('user.step1')->with('error', 'Required data is missing. Please complete all steps.');
        }

        // Find the corresponding author (if exists)
        $correspondingAuthor = collect($allAuthors)->firstWhere('is_correspondent', true);

        // Ensure keywords are an array
        if (!is_array($keywords)) {
            $keywords = [];
        }

        // Pass data to the view
        return view('user.partials.preview_research', [
            'authorData' => $allAuthors,
            'articleTitle' => $articleTitle,
            'subTheme' => $subTheme,
            'keywords' => $keywords,
            'abstract' => $abstract['abstract'], // Pass the abstract text
            'documentPath' => $documentPath,
            'correspondingAuthor' => $correspondingAuthor,
        ]);
    }


    public function postPreview_research(Request $request)
    {
        // Retrieve session data
        $authorData = $request->session()->get('author');
        $submissionData = $request->session()->get('abstract'); // Correct session key
        $allAuthors = $request->session()->get('all_authors');

        if (!$authorData || !$submissionData || !$allAuthors) {
            return redirect()->route('user.step1_research')->with('error', 'No author or submission data available.');
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
        $researchSubmission->final_status = "Pending";  // Ensure the final status is set
        $researchSubmission->save();

        // Save authors
        foreach ($allAuthors as $author) {
            $author['research_submission_id'] = $researchSubmission->id;  // Associate with the correct research_submission
            $author = new Author($author);
            $author->save();
        }

        // Clear session data after submission
        $request->session()->forget(['author', 'abstract', 'all_authors']);  // Remove session keys after saving

        // Return success response
        return redirect()->route('user.dashboard')->with('success', 'Submission successfully.');
    }

    public function downloadAbstractPdf(Request $request)
    {
        // Retrieve session data
        $author = $request->session()->get('author');
        $allAuthors = $request->session()->get('all_authors');
        $abstract = $request->session()->get('abstract');

        // Handle case where abstract data may not be complete
        $articleTitle = $abstract['article_title'] ?? 'Untitled';
        $subTheme = $abstract['sub_theme'] ?? '';
        $keywords = implode(', ', $abstract['keywords'] ?? []);
        $abstractText = $abstract['abstract'] ?? '';

        // Prepare HTML content for the PDF with styling
        $html = '<html><head><title>' . $articleTitle . '</title>';
        $html .= '<style>';
        $html .= 'body { font-family: "Times New Roman", Times, serif; font-size: 14px; line-height: 1.6; }';
        $html .= 'h1 { text-align: center; font-weight: bold; font-size: 20px; }';
        $html .= 'h3, h4, h5 { font-weight: bold; margin-top: 20px; }';
        $html .= 'p { text-align: justify; margin-bottom: 10px; }';
        $html .= '.author-list { text-align: center; margin-bottom: 20px; }';
        $html .= '.author-list p { text-align: center; margin: 5px 0; }';
        $html .= '.author-affiliation { color: #666; font-size: 13px; }';
        $html .= '</style>';
        $html .= '</head><body>';

        // Article Title
        $html .= '<h1>' . $articleTitle . '</h1>';

        // Authors section
        $html .= '<div class="author-list">';
        if (empty($allAuthors)) {
            $html .= '<p>No authors available</p>';
        } else {
            // First line: Author names with asterisk for correspondent
            $authorNames = [];
            foreach ($allAuthors as $author) {
                $name = $author['first_name'] . ' ' . $author['surname'];
                if (isset($author['is_correspondent']) && $author['is_correspondent']) {
                    $name .= '*';
                }
                $authorNames[] = $name;
            }
            $html .= '<p style="margin-bottom: 10px;">' . implode(', ', $authorNames) . '</p>';

            // Collect universities and departments separately
            $universities = [];
            $departments = [];
            foreach ($allAuthors as $author) {
                $universities[] = $author['university'];
                $departments[] = $author['department'];
            }

            // Unique universities and departments
            $uniqueUniversities = implode(', ', array_unique($universities));
            $uniqueDepartments = implode(', ', array_unique($departments));

            // Add universities and departments to the HTML
            $html .= '<p style="text-align: center; margin-bottom: 5px; font-size: 14px;">' . $uniqueUniversities . '</p>';
            $html .= '<p style="text-align: center; margin-top: 0; font-size: 13px;">' . $uniqueDepartments . '</p>';
        }
        $html .= '</div>';

        // Abstract
        $html .= '<h3>Abstract</h3>';
        $html .= '<p>' . $abstractText . '</p>';

        // Keywords
        $html .= '<h4>Keywords</h4>';
        $html .= '<p>' . $keywords . '</p>';

        // Sub-theme
        $html .= '<h5>Sub-Theme</h5>';
        $html .= '<p>' . $subTheme . '</p>';

        $html .= '</body></html>';

        // Initialize Dompdf and load the HTML content
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Set paper size and render PDF
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream the PDF to the browser for download
        return $dompdf->stream('abstract_info.pdf', ['Attachment' => 1]);
    }
}
