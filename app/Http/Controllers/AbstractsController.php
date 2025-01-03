<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbstractSubmission;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord; // Import the PhpWord class
use PhpOffice\PhpWord\IOFactory;

class AbstractsController extends Controller
{
    public function downloadPdf($serial_number)
    {
        // Fetch the abstract submission by ID with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);

        // Extract relevant data
        $authors = $submission->authors; // Authors are now loaded via relationship
        $title = $submission->title;
        $abstract = $submission->abstract;
        $keywords = json_decode($submission->keywords, true) ?? [];
        $subTheme = $submission->sub_theme;

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
                $name = $author->surname . ', ' . $author->first_name;
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
        $html .= '<h3>Abstract</h3>';
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
        return $dompdf->stream('abstract_' . $submission->serial_number . '.pdf');
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
                $name = $author->surname . ', ' . $author->first_name;
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
        // Fetch the abstract submission by serial number with the authors relationship
        $submission = AbstractSubmission::with('authors')->findOrFail($serial_number);
    
        // Initialize PhpWord with default settings
        $phpWord = new PhpWord();
        
        // Define styles with appropriate font sizes
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
        $section->addTitle($submission->title, 1);
    
        // Authors
        if ($submission->authors->isEmpty()) {
            $section->addText('No authors available', ['size' => 11], 'Center');
        } else {
            $authorNames = [];
            foreach ($submission->authors as $author) {
                $name = $author->surname . ', ' . $author->first_name;
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
    
        // Abstract
        $section->addTitle('ABSTRACT', 2);
        $section->addText($submission->abstract, ['size' => 11], 'Normal');
    
        // Keywords
        $keywords = json_decode($submission->keywords, true) ?? [];
        $section->addTitle('Keywords', 2);
        $section->addText(implode(', ', $keywords), ['size' => 11], 'Normal');
    
        // Sub-theme
        $section->addTitle('Sub-Theme', 2);
        $section->addText($submission->sub_theme, ['size' => 11], 'Normal');
    
        // Generate the Word document
        $fileName = 'abstract_' . $submission->serial_number . '.docx';
        $tempFilePath = storage_path($fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);
    
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
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
                    $name = $author->surname . ', ' . $author->first_name;
                    if (!empty($author->middle_name)) {
                        $name .= ' ' . $author->middle_name;
                    }
                    if ($author->is_correspondent) {
                        $name .= ' *';
                    }
                    $authorNames[] = $name;
                }
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
        // Generate the Word document
        $fileName = 'all_abstracts.docx';
        $tempFilePath = storage_path($fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);

        // Return the Word document as a downloadable response
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }
}