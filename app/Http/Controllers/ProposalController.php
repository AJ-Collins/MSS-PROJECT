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
         $authors = $researchSubmission->authors;
         $title = $researchSubmission->article_title;
         $abstract = $researchSubmission->abstract;
         $keywords = json_decode($researchSubmission->keywords, true) ?? [];
         $subTheme = $researchSubmission->sub_theme;
 
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
             ->header('Content-Disposition', 'attachment; filename="abstract_' . $researchSubmission->serial_number . '.pdf"')
             ->header('Cache-Control', 'private, no-transform, no-store, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', '0');
    }
    public function reviewerDownloadPdf($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);

        // Extract relevant data
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
        // Fetch the abstract submission by ID with the authors relationship
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);

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
            htmlspecialchars($researchSubmission->article_title),  // Sanitize input
            ['bold' => true, 'size' => 18],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacingAfter' => 300]
        );

        // Authors section
        $authors = $researchSubmission->authors;
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
            htmlspecialchars($researchSubmission->abstract), 
            ['size' => 12], 
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH]
        );

        // Keywords
        $section->addText('Keywords', ['bold' => true, 'size' => 14]);
        $keywords = json_decode($researchSubmission->keywords, true) ?? [];
        $section->addText(
            htmlspecialchars(implode(', ', $keywords)), 
            ['size' => 12]
        );

        // Sub-theme
        $section->addText('Sub-Theme', ['bold' => true, 'size' => 14]);
        $section->addText(
            htmlspecialchars($researchSubmission->sub_theme), 
            ['size' => 12]
        );

        try {
            // Use storage path instead of temp directory
            $storage_path = storage_path('app/public/word_exports');
            
            // Create directory if it doesn't exist
            if (!file_exists($storage_path)) {
                mkdir($storage_path, 0755, true);
            }

            $fileName = 'abstract_' . $researchSubmission->serial_number . '.docx';
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
    public function downloadReviewerProposalWord($serial_number)
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

         if ($researchSubmissions->isEmpty()) {
             return redirect()->back()->with('error', 'No abstracts available for download.');
         }
 
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
                 .page-break {
                     page-break-before: always;
                 }
             </style>
         </head>
         <body>';
 
         foreach ($researchSubmissions as $index => $researchSubmission) {
             $authors = $researchSubmission->authors;
             $title = $researchSubmission->article_title;
             $abstract = $researchSubmission->abstract;
             $keywords = json_decode($researchSubmission->keywords, true) ?? [];
             $subTheme = $researchSubmission->sub_theme;
 
             $html .= $index > 0 ? '<div class="page-break">' : '<div>'; // Add a page break for all except the first one
 
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
 
             $html .= '</div>'; // Close page content div
         }
 
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
             ->header('Content-Disposition', 'attachment; filename="all_abstracts.pdf"')
             ->header('Cache-Control', 'private, no-transform, no-store, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', '0');
    }
    public function downloadAllProposalAbstractsWord()
    {
         // Fetch all abstract submissions with authors relationship
         $researchSubmissions = ResearchSubmission::with('authors')->get();

         // Create new PHPWord instance
         $phpWord = new PhpWord();
         $phpWord->setDefaultFontName('Book Antiqua');
         $phpWord->setDefaultFontSize(12);
 
         foreach ($researchSubmissions as $researchSubmission) {
             // Add a new section for each abstract with proper page settings
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
                 htmlspecialchars($researchSubmission->article_title),  // Sanitize input
                 ['bold' => true, 'size' => 18],
                 ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacingAfter' => 300]
             );
 
             // Authors section
             $authors = $researchSubmission->authors;
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
                 htmlspecialchars($researchSubmission->abstract), 
                 ['size' => 12], 
                 ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH]
             );
 
             // Keywords
             $section->addText('Keywords', ['bold' => true, 'size' => 14]);
             $keywords = json_decode($researchSubmission->keywords, true) ?? [];
             $section->addText(
                 htmlspecialchars(implode(', ', $keywords)), 
                 ['size' => 12]
             );
 
             // Sub-theme
             $section->addText('Sub-Theme', ['bold' => true, 'size' => 14]);
             $section->addText(
                 htmlspecialchars($researchSubmission->sub_theme), 
                 ['size' => 12]
             );
 
             // Add a page break after each abstract
             $section->addPageBreak();
         }
 
         try {
             $storage_path = storage_path('app/public/word_exports');
 
             if (!file_exists($storage_path)) {
                 mkdir($storage_path, 0755, true);
             }
 
             $fileName = 'all_abstracts.docx';
             $filePath = $storage_path . '/' . $fileName;
 
             // Save the Word document
             $writer = IOFactory::createWriter($phpWord, 'Word2007');
             $writer->save($filePath);
 
             if (!file_exists($filePath) || !is_readable($filePath)) {
                 throw new \Exception('Generated file is not accessible');
             }
 
             return response()->download($filePath, $fileName, [
                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                 'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
             ])->deleteFileAfterSend(true);
 
         } catch (\Exception $e) {
             return response()->json(['error' => 'Failed to generate Word document'], 500);
         }
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
