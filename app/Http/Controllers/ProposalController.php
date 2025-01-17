<?php

namespace App\Http\Controllers;

use App\Models\ProposalAssessment;
use Illuminate\Http\Request;
use App\Models\ResearchSubmission;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord; // Import the PhpWord class
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Options;

class ProposalController extends Controller
{
    public function downloadPdf($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);

        // Extract relevant data
        $authors = $researchSubmission->authors; // Authors are now loaded via relationship
        $title = $researchSubmission->article_title;
        $abstract = $researchSubmission->abstract;
        $keywords = json_decode($researchSubmission->keywords, true) ?? [];
        $subTheme = $researchSubmission->sub_theme;

        // Generate the HTML content for the PDF
        $html = '<html><head><title>' . $title . '</title>';
        $html .= '<style>';
        $html .= 'body { font-family: "Times New Roman", Times, serif; font-size: 14px; line-height: 1.6; }';
        $html .= 'h1 { text-align: center; font-weight: bold; font-size: 20px; }';
        $html .= 'p, ul { text-align: justify; }';
        $html .= '.author-list { text-align: center; margin-bottom: 20px; }'; // Center container
        $html .= '.author-list p { margin: 5px 0; }'; // Center paragraphs
        $html .= '.author-email { color: blue; font-style: italic; }';
        $html .= '</style>';
        $html .= '</head><body>';

        // Title
        $html .= '<h1>' . $title . '</h1>';

        // Authors
        $html .= '<div class="author-list">';
        if ($authors->isEmpty()) {
            $html .= '<p>No authors available</p>'; // Handle case where no authors exist
        } else {
            $authorNames = [];
            foreach ($authors as $author) {
                $name = $author->first_name . ', ' . $author->surname;
                if (!empty($author->middle_name)) {
                    $name .= ' ' . $author->middle_name; // Add middle name if present
                }
                if ($author->is_correspondent) {
                    $name .= '*'; // Mark correspondent authors with an asterisk
                }
                $authorNames[] = $name; // Add the complete name to the array
            }
             // Display all authors in a single line
             $html .= '<p style="text-align: center; margin: 5px 0;">' . implode(', ', $authorNames) . '</p>';

            // Unique universities and departments
            $universities = $authors->pluck('university')->unique()->toArray();
            $departments = $authors->pluck('department')->unique()->toArray();

            // Add universities and departments to the HTML on separate lines
            $uniqueUniversities = implode(', ', $universities);
            $uniqueDepartments = implode(', ', $departments);

            $html .= '<p style="text-align: center; margin-bottom: 5px; font-size: 14px;">' . $uniqueUniversities . '</p>';
            $html .= '<p style="text-align: center; margin-top: 0; font-size: 13px;">' . $uniqueDepartments . '</p>';
        }
        $html .= '</div>';

        // Abstract
        $html .= '<h3>ABSTRACT</h3>';
        $html .= '<p>' . $abstract . '</p>';

        // Keywords
        $html .= '<h3>Keywords</h3>';
        $html .= '<p>' . implode(', ', $keywords) . '</p>';

        // Sub-theme
        $html .= '<h3>Sub-Theme</h3>';
        $html .= '<p>' . $subTheme . '</p>';

        $html .= '</body></html>';

        // Generate the PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Return the generated PDF as a downloadable response
        return $dompdf->stream('abstract_' . $researchSubmission->serial_number . '.pdf');
    }
    public function downloadProposalWord($serial_number)
    {
        // Fetch the research submission by serial number with the authors relationship
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);

        // Initialize PhpWord
        $phpWord = new PhpWord();

        // Define styles
        $phpWord->addTitleStyle(1, [
            'bold' => true, 
            'size' => 14,
            'spaceAfter' => 120
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        $phpWord->addTitleStyle(2, [
            'bold' => true, 
            'size' => 12,
            'spaceAfter' => 120
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH
        ]);

        // Define paragraph styles
        $phpWord->addParagraphStyle('Normal', [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
            'lineHeight' => 1.15,
            'spaceAfter' => 120
        ]);

        $phpWord->addParagraphStyle('Center', [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => 120
        ]);

        // Create single section with margins
        $section = $phpWord->addSection([
            'marginLeft' => 1440,   // 1 inch in twips
            'marginRight' => 1440,
            'marginTop' => 1440,
            'marginBottom' => 1440
        ]);

        // Title
        $section->addTitle($researchSubmission->article_title, 1);

        // Authors
        if ($researchSubmission->authors->isEmpty()) {
            $section->addText('No authors available', ['size' => 11], 'Center');
        } else {
            $authorNames = [];
            foreach ($researchSubmission->authors as $author) {
                $name = $author->surname . ', ' . $author->first_name;
                if (!empty($author->middle_name)) {
                    $name .= ' ' . $author->middle_name;
                }
                if ($author->is_correspondent) {
                    $name .= ' *'; // Mark correspondent authors with an asterisk
                }
                $authorNames[] = $name;
            }
            // Add authors with appropriate spacing
            $authorNamesText = implode(', ', $authorNames);
            $section->addText($authorNamesText, ['size' => 11], 'Center');
        }

        // Universities and departments
        $universities = $researchSubmission->authors->pluck('university')->unique()->toArray();
        $departments = $researchSubmission->authors->pluck('department')->unique()->toArray();

        $universitiesText = !empty($universities) ? implode(', ', $universities) : '';
        $departmentsText = !empty($departments) ? implode(', ', $departments) : '';

        $section->addText($universitiesText, ['size' => 11], 'Center');
        $section->addText($departmentsText, ['size' => 10], 'Center');

        // Abstract
        $section->addTitle('ABSTRACT', 2);
        $section->addText($researchSubmission->abstract, ['size' => 11], 'Normal');

        // Keywords
        $keywords = json_decode($researchSubmission->keywords, true) ?? [];
        $section->addTitle('Keywords', 2);
        $section->addText(implode(', ', $keywords), ['size' => 11], 'Normal');

        // Sub-theme
        $section->addTitle('Sub-Theme', 2);
        $section->addText($researchSubmission->sub_theme, ['size' => 11], 'Normal');

        // Generate the Word document
        $fileName = 'proposal_' . $researchSubmission->serial_number . '.docx';
        $tempFilePath = storage_path($fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);

        // Return the Word document as a downloadable response
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function downloadAllProposalAbstracts()
    {
        // Fetch all abstract submissions with authors relationship
        $researchSubmissions = ResearchSubmission::with('authors')->get();

        // Initialize the HTML content for the PDF
        $html = '<html><head><title>All Abstracts</title>';
        $html .= '<style>';
        $html .= 'body { font-family: "Times New Roman", Times, serif; }';
        $html .= 'h1 { text-align: center; font-weight: bold; margin-bottom: 20px; }';
        $html .= 'h3 { margin-top: 20px; }';
        $html .= 'p, ul { text-align: justify; }';
        $html .= '.author-list { text-align: center; margin-bottom: 10px; }';
        $html .= '.author-email { color: blue; }';
        $html .= '.abstract-container { margin-bottom: 40px; }';
        $html .= '.page-break { page-break-before: always; }'; // CSS for page break
        $html .= '</style>';
        $html .= '</head><body>';

        // Initialize a flag to track the first abstract
        $isFirst = true;

        // Loop through each abstract and add to the HTML
        foreach ($researchSubmissions as $researchSubmission) {
            // Add a page break before all abstracts except the first one
            if (!$isFirst) {
                $html .= '<div class="page-break"></div>';
            }
            $isFirst = false;

            // Extract relevant data for each submission
            $authors = $researchSubmission->authors;
            $title = $researchSubmission->article_title;
            $abstract = $researchSubmission->abstract;
            $keywords = json_decode($researchSubmission->keywords, true) ?? [];
            $subTheme = $researchSubmission->sub_theme;

            // Add submission title
            $html .= '<div class="abstract-container">';
            $html .= '<h1>' . $title . '</h1>';

            // Authors
            $html .= '<div class="author-list">';
            if ($authors->isEmpty()) {
                $html .= '<p>No authors available</p>';
            } else {
                $authorNames = [];
            foreach ($authors as $author) {
                $name = $author->first_name . ' ' . $author->surname;
                if (!empty($author->middle_name)) {
                    $name .= ' ' . $author->middle_name; // Add middle name if present
                }
                if ($author->is_correspondent) {
                    $name .= '*'; // Mark correspondent authors with an asterisk
                }
                $authorNames[] = $name; // Add the complete name to the array
            }
                // Display all authors in a single line
                $html .= '<p style="text-align: center; margin: 5px 0;">' . implode(', ', $authorNames) . '</p>';

                // Unique universities and departments
                $universities = $authors->pluck('university')->unique()->toArray();
                $departments = $authors->pluck('department')->unique()->toArray();

                // Add universities and departments to the HTML on separate lines
                $uniqueUniversities = implode(', ', $universities);
                $uniqueDepartments = implode(', ', $departments);

                $html .= '<p style="text-align: center; margin-bottom: 5px; font-size: 14px;">' . $uniqueUniversities . '</p>';
                $html .= '<p style="text-align: center; margin-top: 0; font-size: 13px;">' . $uniqueDepartments . '</p>';
            }
            $html .= '</div>';

            // Abstract
            $html .= '<h3>ABSTRACT</h3>';
            $html .= '<p>' . $abstract . '</p>';

            // Keywords
            $html .= '<h3>Keywords</h3>';
            $html .= '<p>' . implode(', ', $keywords) . '</p>';

            // Sub-theme
            $html .= '<h3>Sub-Theme</h3>';
            $html .= '<p>' . $subTheme . '</p>';
            $html .= '</div>'; // End of abstract container
        }

        $html .= '</body></html>';

        // Generate the PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Return the generated PDF as a downloadable response
        return $dompdf->stream('all_abstracts.pdf');
    }
    public function downloadAllProposalAbstractsWord()
    {
        // Fetch all abstract submissions with authors relationship
        $researchSubmissions = ResearchSubmission::with('authors')->get();

        // Initialize PhpWord
        $phpWord = new PhpWord();

        // Define styles
        $phpWord->addTitleStyle(1, [
            'bold' => true, 
            'size' => 14,
            'spaceAfter' => 120
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);
        
        $phpWord->addTitleStyle(2, [
            'bold' => true, 
            'size' => 12,
            'spaceAfter' => 120
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH
        ]);
        
        // Define paragraph styles
        $phpWord->addParagraphStyle('Normal', [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
            'lineHeight' => 1.15,
            'spaceAfter' => 120
        ]);
        
        $phpWord->addParagraphStyle('Center', [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => 120
        ]);
    
        // Create single section with margins
        $section = $phpWord->addSection([
            'marginLeft' => 1440,   // 1 inch in twips
            'marginRight' => 1440,
            'marginTop' => 1440,
            'marginBottom' => 1440
        ]);

        // Loop through each abstract and add to the Word document
        foreach ($researchSubmissions as $researchSubmission) {
            // Add title
            $section->addTitle($researchSubmission->article_title, 1);

            // Authors
            if ($researchSubmission->authors->isEmpty()) {
                $section->addText('No authors available', ['size' => 11], 'Center');
            } else {
                $authorNames = [];
                foreach ($researchSubmission->authors as $author) {
                    $name = $author->first_name . ' ' . $author->surname;
                    if (!empty($author->middle_name)) {
                        $name .= ' ' . $author->middle_name;
                    }
                    if ($author->is_correspondent) {
                        $name .= ' *';
                    }
                    $authorNames[] = $name;
                }
            }
        
            // Add authors with appropriate spacing
            $section->addText(implode(', ', $authorNames), ['size' => 11], 'Center');
        
            // Universities and departments
            $universities = $researchSubmission->authors->pluck('university')->unique()->toArray();
            $departments = $researchSubmission->authors->pluck('department')->unique()->toArray();
        
            $section->addText(implode(', ', $universities), ['size' => 11], 'Center');
            $section->addText(implode(', ', $departments), ['size' => 10], 'Center');

            // Add some space before abstract
            $section->addTextBreak(1);

            // Add abstract content
            $section->addTitle('ABSTRACT', 2);
            $section->addText($researchSubmission->abstract, ['size' => 11], 'Normal');

            // Add keywords
            $keywords = json_decode($researchSubmission->keywords, true) ?? [];
            $section->addTitle('Keywords', 2);
            $section->addText(implode(', ', $keywords), ['size' => 11], 'Normal');

            // Add sub-theme
            $section->addTitle('Sub-Theme', 2);
            $section->addText($researchSubmission->sub_theme, ['size' => 11], 'Normal');

            // Add a page break after each abstract
            $section->addPageBreak();
        }

        // Generate the Word document
        $fileName = 'all_abstracts.docx';
        $tempFilePath = storage_path($fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);

        // Return the Word document as a downloadable response
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function downloadProposalAssessmentPDF($abstract_submission_id)
    {
        $researchAssessment = ProposalAssessment::with(['proposalSubmission', 'reviewer', 'user'])
            ->where('abstract_submission_id', $abstract_submission_id)
            ->first();

        if (!$researchAssessment) {
            return redirect()->back()->with('error', 'Assessment not found.');
        }

        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    margin: 30px;
                    color: #333;
                    font-size: 12px;
                }
                .letterhead {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo-text {
                    font-size: 20px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                }
                .title {
                    font-size: 16px;
                    font-weight: bold;
                    margin: 15px 0;
                }
                .document-info {
                    margin: 20px 0;
                    width: 100%;
                    border-collapse: collapse;
                }
                .document-info td {
                    padding: 5px;
                    border: 1px solid #000;
                }
                .document-info .label {
                    font-weight: bold;
                    background-color: #f0f0f0;
                    width: 30%;
                }
                .assessment-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                .assessment-table th, .assessment-table td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                .assessment-table th {
                    background-color: #f0f0f0;
                    font-weight: bold;
                }
                .score-cell {
                    text-align: center;
                    font-weight: bold;
                    width: 80px;
                }
                .comments-box {
                    border: 1px solid #000;
                    padding: 10px;
                    margin: 10px 0;
                    min-height: 60px;
                }
                .final-section {
                    margin: 20px 0;
                    padding: 15px;
                    border: 1px solid #000;
                }
                .signature-section {
                    margin-top: 50px;
                    page-break-inside: avoid;
                }
                .signature-line {
                    border-top: 1px solid #000;
                    width: 200px;
                    margin-top: 40px;
                    margin-bottom: 5px;
                }
                .confidential-stamp {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%) rotate(-45deg);
                    font-size: 72px;
                    opacity: 0.15;
                    color: #808080;
                    z-index: -1;
                }
            </style>
        </head>
        <body>
            <div class="letterhead">
                <div class="logo-text">PROPOSAL ABSTRACT ASSESSMENT</div>
                <div>Reference Number: ' . $researchAssessment->id . '</div>
            </div>

            <table class="document-info">
                <tr>
                    <td class="label">Abstract Serial Number:</td>
                    <td>' . htmlspecialchars($researchAssessment->abstract_submission_id) . '</td>
                    <td class="label">Date of Assessment:</td>
                    <td>' . $researchAssessment->created_at->format('F d, Y') . '</td>
                </tr>
                <tr>
                    <td class="label">Reviewer RegNo:</td>
                    <td>' . htmlspecialchars($researchAssessment->reviewer_reg_no) . '</td>
                    <td class="label">Author RegNo:</td>
                    <td>' . htmlspecialchars($researchAssessment->user_reg_no) . '</td>
                </tr>
            </table>

            <div class="title">EVALUATION CRITERIA AND SCORING</div>

            <table class="assessment-table">
                <tr>
                    <th width="40%">Assessment Criteria</th>
                    <th>Comments</th>
                    <th width="15%">Score</th>
                </tr>
                <tr>
                    <td>1. Thematic Relevance<br><small>(Alignment with research priorities)</small></td>
                    <td>' . nl2br(htmlspecialchars($researchAssessment->thematic_comments)) . '</td>
                    <td class="score-cell">' . $researchAssessment->thematic_score . '/20</td>
                </tr>
                <tr>
                    <td>2. Title Clarity and Appropriateness<br><small>(Clear, concise, and reflective of the study)</small></td>
                    <td>' . nl2br(htmlspecialchars($researchAssessment->title_comments)) . '</td>
                    <td class="score-cell">' . $researchAssessment->title_score . '/20</td>
                </tr>
                <tr>
                    <td>3. Research Objectives<br><small>(Clear, specific, measurable, and achievable)</small></td>
                    <td>' . nl2br(htmlspecialchars($researchAssessment->objectives_comments)) . '</td>
                    <td class="score-cell">' . $researchAssessment->objectives_score . '/20</td>
                </tr>
                <tr>
                    <td>4. Methodology<br><small>(Appropriate design and procedures)</small></td>
                    <td>' . nl2br(htmlspecialchars($researchAssessment->methodology_comments)) . '</td>
                    <td class="score-cell">' . $researchAssessment->methodology_score . '/20</td>
                </tr>
                <tr>
                    <td>5. Expected Output<br><small>(Impact and feasibility)</small></td>
                    <td>' . nl2br(htmlspecialchars($researchAssessment->output_comments)) . '</td>
                    <td class="score-cell">' . $researchAssessment->output_score . '/20</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL SCORE:</td>
                    <td class="score-cell">' . 
                        $researchAssessment->total_score . '/100</td>
                </tr>
            </table>

            <div class="final-section">
                <div class="title">GENERAL ASSESSMENT AND RECOMMENDATIONS</div>
                <div class="comments-box">
                    ' . nl2br(htmlspecialchars($researchAssessment->general_comments)) . '
                </div>

                <div style="margin-top: 20px;">
                    <strong>Decision: </strong>
                    <span style="text-transform: uppercase; font-weight: bold;">' . 
                        ($researchAssessment->correction_type ? ucfirst($researchAssessment->correction_type) . ' Corrections Required' : 'N/A') . 
                    '</span>
                </div>

                <div style="margin-top: 10px;">
                    <strong>Correction Comments:</strong>
                    <div class="comments-box">
                        ' . nl2br(htmlspecialchars($researchAssessment->correction_comments ?? 'No specific corrections noted.')) . '
                    </div>
                </div>
            </div>
        </body>
        </html>';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Length', strlen($pdfContent))
            ->header('Cache-Control', 'private, no-transform, no-store, must-revalidate')
            ->header('Content-Disposition', 'attachment; filename="Assessment_' . $researchAssessment->abstract_submission_id . '.pdf"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
