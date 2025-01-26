<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use App\Models\ResearchAssessment;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Options;

class AbstractsController extends Controller
{
    public function downloadPdf($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);

        // Extract relevant data
        $authors = $submission->authors;
        $title = $submission->title;
        $abstract = $submission->abstract;
        $keywords = json_decode($submission->keywords, true) ?? [];
        $subTheme = $submission->sub_theme;

        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Book Antiqua;
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
                    padding-bottom: 10px;
                }
                .title {
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;
                    margin: 15px 0;
                }
                .authors-section {
                    margin: 20px 0;
                    text-align: center;
                }
                .authors-list {
                    margin-bottom: 10px;
                    font-size: 14px;
                }
                .institutions-list {
                    margin: 10px 0;
                    font-size: 14px;
                }
                .email-correspondence {
                    font-style: italic;
                    font-size: 13px;
                    margin: 10px 0;
                    font-weight: bold;
                }
                .section-title {
                    font-size: 18px;
                    font-weight: bold;
                    margin: 15px 0 10px 0;
                    padding-bottom: 5px;
                }
                .content-section {
                    margin: 15px 0;
                    text-align: justify;
                    font-size: 16px;
                }
                .keywords-section {
                    margin: 15px 0;
                    text-align: justify;
                    font-size: 16px;
                }
                sup {
                    font-size: 9px;
                    font-weight: bold;
                }
                .institutions-list {
                    margin: 10px 0;
                    font-size: 12px;
                    text-align: left;
                    padding-left: 200px;
                    
                }
                .asterix {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>';

        // Title
        $html .= '<div class="title">' . htmlspecialchars($title) . '</div>';

        // Authors section
        $html .= '<div class="authors-section">';
        if ($authors->isEmpty()) {
            $html .= '<p>No authors available</p>';
        } else {
            // Format authors with superscript numbers
            $authorsList = [];
            $institutionsList = [];
            $correspondingEmails = [];
            $counter = 1;
            
            foreach ($authors as $author) {
                $name = $author->first_name;
                if (!empty($author->middle_name)) {
                    $name .= ' ' . $author->middle_name;
                }
                $name .= ' ' . $author->surname;
                
                // Add superscript number and asterisk if correspondent
                $name .= '<sup>' . $counter . ($author->is_correspondent ? '*' : '') . '</sup>';
                $authorsList[] = $name;

                // Store institution information
                $institutionsList[] = sprintf(
                    '<div style="text-indent: -15px; margin-left: 15px;"><sup>%d</sup> %s, %s</div>', 
                    $counter,
                    htmlspecialchars($author->university),
                    htmlspecialchars($author->department)
                );

                // Store corresponding author emails
                if ($author->is_correspondent) {
                    $correspondingEmails[] = ($author->email);
                }

                $counter++;
            }

            // Display authors
            $html .= '<div class="authors-list">' . implode(', ', $authorsList) . '</div>';

            // Display institutions
            $html .= '<div class="institutions-list">';
            foreach ($institutionsList as $institution) {
                $html .= '<div>' . $institution . '</div>';
            }
            $html .= '</div>';

            // Display corresponding emails if any
            if (!empty($correspondingEmails)) {
                $html .= '<div ><span class="email-correspondence">* Correspondence: </span>' . 
                        implode('; ', $correspondingEmails) . '</div>';
            }
        }
        $html .= '</div>';

        // Abstract
        $html .= '
            <div class="section-title">Abstract</div>
            <div class="content-section">' . nl2br(htmlspecialchars($abstract)) . '</div>';

        // Keywords
        $html .= '
            <div class="section-title">Keywords</div>
            <div class="keywords-section">' . htmlspecialchars(implode(', ', $keywords)) . '</div>';

        // Sub-theme
        $html .= '
            <div class="section-title">Sub-Theme</div>
            <div class="content-section">' . htmlspecialchars($subTheme) . '</div>';

        $html .= '</body></html>';

        // Generate the PDF using Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="abstract_' . $submission->serial_number . '.pdf"')
            ->header('Cache-Control', 'private, no-transform, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    public function reviwerDownloadPdf($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);

        // Extract relevant data
        $title = $submission->title;
        $abstract = $submission->abstract;
        $keywords = json_decode($submission->keywords, true) ?? [];
        $subTheme = $submission->sub_theme;

        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Book Antiqua;
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
                    padding-bottom: 10px;
                }
                .title {
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;
                    margin: 15px 0;
                }
                .authors-section {
                    margin: 20px 0;
                    text-align: center;
                }
                .authors-list {
                    margin-bottom: 10px;
                    font-size: 14px;
                }
                .institutions-list {
                    margin: 10px 0;
                    font-size: 14px;
                }
                .email-correspondence {
                    font-style: italic;
                    font-size: 13px;
                    margin: 10px 0;
                    font-weight: bold;
                }
                .section-title {
                    font-size: 18px;
                    font-weight: bold;
                    margin: 15px 0 10px 0;
                    padding-bottom: 5px;
                }
                .content-section {
                    margin: 15px 0;
                    text-align: justify;
                    font-size: 16px;
                }
                .keywords-section {
                    margin: 15px 0;
                    text-align: justify;
                    font-size: 16px;
                }
                sup {
                    font-size: 9px;
                    font-weight: bold;
                }
                .institutions-list {
                    margin: 10px 0;
                    font-size: 12px;
                    text-align: left;
                    padding-left: 200px;
                    
                }
                .asterix {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>';

        // Title
        $html .= '<div class="title">' . htmlspecialchars($title) . '</div>';

        // Abstract
        $html .= '
            <div class="section-title">Abstract</div>
            <div class="content-section">' . nl2br(htmlspecialchars($abstract)) . '</div>';

        // Keywords
        $html .= '
            <div class="section-title">Keywords</div>
            <div class="keywords-section">' . htmlspecialchars(implode(', ', $keywords)) . '</div>';

        // Sub-theme
        $html .= '
            <div class="section-title">Sub-Theme</div>
            <div class="content-section">' . htmlspecialchars($subTheme) . '</div>';

        $html .= '</body></html>';

        // Generate the PDF using Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="abstract_' . $submission->serial_number . '.pdf"')
            ->header('Cache-Control', 'private, no-transform, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function downloadAllAbstracts()
    {
        // Fetch all abstract submissions with authors relationship
        $submissions = AbstractSubmission::with('authors')->get();

        // Initialize the HTML content for the PDF
        $html = '<html><head><title>All Abstracts</title>';
        $html .= '<style>';
        $html .= 'body { font-family: "Times New Roman", Times, serif; }';
        $html .= 'h1 { text-align: center; font-weight: bold; margin-bottom: 20px; }';
        $html .= 'h3 { margin-top: 20px; }';
        $html .= 'p, ul { text-align: justify; }';
        $html .= '.author-list { text-align: center; margin-bottom: 20px; }';
        $html .= '.author-email { color: blue; }';
        $html .= '.abstract-container { margin-bottom: 40px; }';
        $html .= '.page-break { page-break-before: always; }'; // CSS for page break
        $html .= '</style>';
        $html .= '</head><body>';

        // Initialize a flag to track the first abstract
        $isFirst = true;

        // Loop through each abstract and add to the HTML
        foreach ($submissions as $submission) {
            // Add a page break before all abstracts except the first one
            if (!$isFirst) {
                $html .= '<div class="page-break"></div>';
            }
            $isFirst = false;

            // Extract relevant data for each submission
            $authors = $submission->authors;
            $title = $submission->title;
            $abstract = $submission->abstract;
            $keywords = json_decode($submission->keywords, true) ?? [];
            $subTheme = $submission->sub_theme;

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
    public function downloadWord($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);

        // Create new PHPWord instance
        $phpWord = new PhpWord();
        
        // Set default font
        $phpWord->setDefaultFontName('Book Antiqua');
        $phpWord->setDefaultFontSize(12);

        // Add a section with proper page settings
        $section = $phpWord->addSection([
            'marginLeft' => 1440,    // 1 inch
            'marginRight' => 1440,   // 1 inch
            'marginTop' => 1440,     // 1 inch
            'marginBottom' => 1440,  // 1 inch
            'pageSizeW' => 12240,    // A4 width in twips
            'pageSizeH' => 15840,    // A4 height in twips
        ]);

        // Title
        $section->addText(
            htmlspecialchars($submission->title),  // Sanitize input
            ['bold' => true, 'size' => 18],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacingAfter' => 300]
        );

        // Authors section
        $authors = $submission->authors;
        if (!$authors->isEmpty()) {
            // Authors on one line
            $textrun = $section->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $counter = 1;
            
            foreach ($authors as $index => $author) {
                $name = htmlspecialchars($author->first_name);
                if (!empty($author->middle_name)) {
                    $name .= ' ' . htmlspecialchars($author->middle_name);
                }
                $name .= ' ' . htmlspecialchars($author->surname);
                
                $textrun->addText($name, ['size' => 10]);
                $textrun->addText($counter . ($author->is_correspondent ? '*' : ''), 
                    ['size' => 9, 'superscript' => true, 'bold' => true]
                );
                
                // Add comma if not the last author
                if ($index < count($authors) - 1) {
                    $textrun->addText(', ', ['size' => 14]);
                }
                $counter++;
            }

            // Institutions
            foreach ($authors as $index => $author) {
                $instTextRun = $section->addTextRun([
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                    'indentation' => ['left' => 2880]  // Adds 1-inch left indentation (1440 twips)
                ]);
                $instTextRun->addText($index + 1, ['size' => 9, 'superscript' => true]);
                $instTextRun->addText(' ' . htmlspecialchars($author->university) . ', ' . 
                    htmlspecialchars($author->department), ['size' => 10]);
            }

            // Corresponding author emails
            $correspondingEmails = $authors->where('is_correspondent', true)
                ->pluck('email')
                ->map(function ($email) {
                    return htmlspecialchars($email);
                })
                ->toArray();

            if (!empty($correspondingEmails)) {
                $textrun = $section->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $textrun->addText('* Correspondence: ', ['italic' => true, 'bold' => true, 'size' => 10]);
                $textrun->addText(implode('; ', $correspondingEmails), ['size' => 10]);
            }
        }

        // Abstract
        $section->addText('Abstract', ['bold' => true, 'size' => 14]);
        $section->addText(
            htmlspecialchars($submission->abstract), 
            ['size' => 12], 
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH]
        );

        // Keywords
        $section->addText('Keywords', ['bold' => true, 'size' => 14]);
        $keywords = json_decode($submission->keywords, true) ?? [];
        $section->addText(
            htmlspecialchars(implode(', ', $keywords)), 
            ['size' => 12]
        );

        // Sub-theme
        $section->addText('Sub-Theme', ['bold' => true, 'size' => 14]);
        $section->addText(
            htmlspecialchars($submission->sub_theme), 
            ['size' => 12]
        );

        try {
            // Use storage path instead of temp directory
            $storage_path = storage_path('app/public/word_exports');
            
            // Create directory if it doesn't exist
            if (!file_exists($storage_path)) {
                mkdir($storage_path, 0755, true);
            }

            $fileName = 'abstract_' . $submission->serial_number . '.docx';
            $filePath = $storage_path . '/' . $fileName;

            // Save file
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($filePath);

            // Check if file exists and is readable
            if (!file_exists($filePath) || !is_readable($filePath)) {
                throw new \Exception('Generated file is not accessible');
            }

            // Return file download response
            return response()->download($filePath, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Word document'], 500);
        }
    }
    public function reviwerDownloadWord($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);

        // Create new PHPWord instance
        $phpWord = new PhpWord();
        
        // Set default font
        $phpWord->setDefaultFontName('Book Antiqua');
        $phpWord->setDefaultFontSize(12);

        // Add a section with proper page settings
        $section = $phpWord->addSection([
            'marginLeft' => 1440,    // 1 inch
            'marginRight' => 1440,   // 1 inch
            'marginTop' => 1440,     // 1 inch
            'marginBottom' => 1440,  // 1 inch
            'pageSizeW' => 12240,    // A4 width in twips
            'pageSizeH' => 15840,    // A4 height in twips
        ]);

        // Title
        $section->addText(
            htmlspecialchars($submission->title),  // Sanitize input
            ['bold' => true, 'size' => 18],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacingAfter' => 300]
        );

        // Abstract
        $section->addText('Abstract', ['bold' => true, 'size' => 14]);
        $section->addText(
            htmlspecialchars($submission->abstract), 
            ['size' => 12], 
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH]
        );

        // Keywords
        $section->addText('Keywords', ['bold' => true, 'size' => 14]);
        $keywords = json_decode($submission->keywords, true) ?? [];
        $section->addText(
            htmlspecialchars(implode(', ', $keywords)), 
            ['size' => 12]
        );

        // Sub-theme
        $section->addText('Sub-Theme', ['bold' => true, 'size' => 14]);
        $section->addText(
            htmlspecialchars($submission->sub_theme), 
            ['size' => 12]
        );

        try {
            // Use storage path instead of temp directory
            $storage_path = storage_path('app/public/word_exports');
            
            // Create directory if it doesn't exist
            if (!file_exists($storage_path)) {
                mkdir($storage_path, 0755, true);
            }

            $fileName = 'abstract_' . $submission->serial_number . '.docx';
            $filePath = $storage_path . '/' . $fileName;

            // Save file
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($filePath);

            // Check if file exists and is readable
            if (!file_exists($filePath) || !is_readable($filePath)) {
                throw new \Exception('Generated file is not accessible');
            }

            // Return file download response
            return response()->download($filePath, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Word document'], 500);
        }
    }
    public function downloadAllAbstractsWord()
    {
        // Fetch all abstract submissions with authors relationship
        $submissions = AbstractSubmission::with('authors')->get();

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
        foreach ($submissions as $submission) {
            // Add title
            $section->addTitle($submission->title, 1);

            // Authors
            if ($submission->authors->isEmpty()) {
                $section->addText('No authors available', null, 'Center');
            } else {
                $authorNames = [];
                foreach ($submission->authors as $author) {
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
            $universities = $submission->authors->pluck('university')->unique()->toArray();
            $departments = $submission->authors->pluck('department')->unique()->toArray();
        
            $section->addText(implode(', ', $universities), ['size' => 11], 'Center');
            $section->addText(implode(', ', $departments), ['size' => 10], 'Center');

            // Add some space before abstract
            $section->addTextBreak(1);

            // Add abstract content
            $section->addTitle('ABSTRACT', 2);
            $section->addText($submission->abstract, null, 'Normal');

            // Add keywords
            $keywords = json_decode($submission->keywords, true) ?? [];
            $section->addTitle('Keywords', 2);
            $section->addText(implode(', ', $keywords), null, 'Normal');

            // Add sub-theme
            $section->addTitle('Sub-Theme', 2);
            $section->addText($submission->sub_theme, null, 'Normal');

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

    public function downloadAssessmentPDF($abstract_submission_id)
    {
        $assessment = ResearchAssessment::with(['abstractSubmission', 'reviewer', 'user'])
            ->where('abstract_submission_id', $abstract_submission_id)
            ->first();

        if (!$assessment) {
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
                <div class="logo-text">RESEARCH ABSTRACT ASSESSMENT</div>
                <div>Reference Number: ' . $assessment->id . '</div>
            </div>

            <table class="document-info">
                <tr>
                    <td class="label">Abstract Serial Number:</td>
                    <td>' . htmlspecialchars($assessment->abstract_submission_id) . '</td>
                    <td class="label">Date of Assessment:</td>
                    <td>' . $assessment->created_at->format('F d, Y') . '</td>
                </tr>
                <tr>
                    <td class="label">Reviewer RegNo:</td>
                    <td>' . htmlspecialchars($assessment->reviewer_reg_no) . '</td>
                    <td class="label">Author RegNo:</td>
                    <td>' . htmlspecialchars($assessment->user_reg_no) . '</td>
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
                    <td>' . nl2br(htmlspecialchars($assessment->thematic_comments)) . '</td>
                    <td class="score-cell">' . $assessment->thematic_score . '/20</td>
                </tr>
                <tr>
                    <td>2. Title Clarity and Appropriateness<br><small>(Clear, concise, and reflective of the study)</small></td>
                    <td>' . nl2br(htmlspecialchars($assessment->title_comments)) . '</td>
                    <td class="score-cell">' . $assessment->title_score . '/20</td>
                </tr>
                <tr>
                    <td>3. Research Objectives<br><small>(Clear, specific, measurable, and achievable)</small></td>
                    <td>' . nl2br(htmlspecialchars($assessment->objectives_comments)) . '</td>
                    <td class="score-cell">' . $assessment->objectives_score . '/20</td>
                </tr>
                <tr>
                    <td>4. Methodology<br><small>(Appropriate design and procedures)</small></td>
                    <td>' . nl2br(htmlspecialchars($assessment->methodology_comments)) . '</td>
                    <td class="score-cell">' . $assessment->methodology_score . '/20</td>
                </tr>
                <tr>
                    <td>5. Expected Output<br><small>(Impact and feasibility)</small></td>
                    <td>' . nl2br(htmlspecialchars($assessment->output_comments)) . '</td>
                    <td class="score-cell">' . $assessment->output_score . '/20</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL SCORE:</td>
                    <td class="score-cell">' . 
                        $assessment->total_score . '/100</td>
                </tr>
            </table>

            <div class="final-section">
                <div class="title">GENERAL ASSESSMENT AND RECOMMENDATIONS</div>
                <div class="comments-box">
                    ' . nl2br(htmlspecialchars($assessment->general_comments)) . '
                </div>

                <div style="margin-top: 20px;">
                    <strong>Decision: </strong>
                    <span style="text-transform: uppercase; font-weight: bold;">' . 
                        ($assessment->correction_type ? ucfirst($assessment->correction_type) . ' Corrections Required' : 'N/A') . 
                    '</span>
                </div>

                <div style="margin-top: 10px;">
                    <strong>Correction Comments:</strong>
                    <div class="comments-box">
                        ' . nl2br(htmlspecialchars($assessment->correction_comments ?? 'No specific corrections noted.')) . '
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
            ->header('Content-Disposition', 'attachment; filename="Assessment_' . $assessment->abstract_submission_id . '.pdf"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}