<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchSubmission;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord; // Import the PhpWord class
use PhpOffice\PhpWord\IOFactory;

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
        $html .= 'body { font-family: "Times New Roman", Times, serif; }';
        $html .= 'h1 { text-align: center; font-weight: bold; }';
        $html .= 'p, ul { text-align: justify; }';
        $html .= '.author-list { text-align: center; margin-bottom: 10px; }';
        $html .= '.author-email { color: blue; }';
        $html .= '</style>';
        $html .= '</head><body>';

        // Title
        $html .= '<h1>' . $title . '</h1>';

        // Authors
        $html .= '<div class="author-list">';
        if ($authors->isEmpty()) {
            $html .= '<p>No authors available</p>'; // Handle case where no authors exist
        } else {
            foreach ($authors as $author) {
                $html .= '<p>' . $author->first_name . ' ' . $author->middle_name . ' ' . $author->surname;
                if ($author->is_correspondent) {
                    $html .= '*'; // Mark correspondent authors with an asterisk
                }
                $html .= '</p>';
            }
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
        // Fetch the abstract submission by serial number with the authors relationship
        $researchSubmission = ResearchSubmission::with('authors')->findOrFail($serial_number);

        // Initialize PhpWord
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Define styles
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'alignment' => 'center']);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14]);
        $phpWord->addParagraphStyle('Normal', ['alignment' => 'both']);
        $phpWord->addParagraphStyle('Center', ['alignment' => 'center']);

        // Title
        $section->addTitle($researchSubmission->article_title, 1);

        // Authors
        if ($researchSubmission->authors->isEmpty()) {
            $section->addText('No authors available', null, 'Center');
        } else {
            foreach ($researchSubmission->authors as $author) {
                $authorText = $author->first_name . ' ' . $author->middle_name . ' ' . $author->surname;
                if ($author->is_correspondent) {
                    $authorText .= ' *'; // Mark correspondent authors with an asterisk
                }
                $section->addText($authorText, null, 'Center');
            }
        }

        // Abstract
        $section->addTitle('ABSTRACT', 2);
        $section->addText($researchSubmission->abstract, null, 'Normal');

        // Keywords
        $keywords = json_decode($researchSubmission->keywords, true) ?? [];
        $section->addTitle('Keywords', 2);
        $section->addText(implode(', ', $keywords), null, 'Normal');

        // Sub-theme
        $section->addTitle('Sub-Theme', 2);
        $section->addText($researchSubmission->sub_theme, null, 'Normal');

        // Generate the Word document
        $fileName = 'abstract_' . $researchSubmission->serial_number . '.docx';
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
        $html .= '.author-list { text-align: left; margin-bottom: 10px; }';
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
            $title = $researchSubmission->title;
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
                foreach ($authors as $author) {
                    $html .= '<p>' . $author->first_name . ' ' . $author->middle_name . ' ' . $author->surname;
                    if ($author->is_correspondent) {
                        $html .= '*';
                    }
                    $html .= '</p>';
                }
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
        $section = $phpWord->addSection();

        // Define styles
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'alignment' => 'center']);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14]);
        $phpWord->addParagraphStyle('Normal', ['alignment' => 'both']);
        $phpWord->addParagraphStyle('Center', ['alignment' => 'center']);

        // Loop through each abstract and add to the Word document
        foreach ($researchSubmissions as $researchSubmission) {
            // Add title
            $section->addTitle($researchSubmission->article_title, 1);

            // Authors
            if ($researchSubmission->authors->isEmpty()) {
                $section->addText('No authors available', null, 'Center');
            } else {
                foreach ($researchSubmission->authors as $author) {
                    $authorText = $author->first_name . ' ' . $author->middle_name . ' ' . $author->surname;
                    if ($author->is_correspondent) {
                        $authorText .= ' *'; // Mark correspondent authors with an asterisk
                    }
                    $section->addText($authorText, null, 'Center');
                }
            }

            // Add abstract content
            $section->addTitle('ABSTRACT', 2);
            $section->addText($researchSubmission->abstract, null, 'Normal');

            // Add keywords
            $keywords = json_decode($researchSubmission->keywords, true) ?? [];
            $section->addTitle('Keywords', 2);
            $section->addText(implode(', ', $keywords), null, 'Normal');

            // Add sub-theme
            $section->addTitle('Sub-Theme', 2);
            $section->addText($researchSubmission->sub_theme, null, 'Normal');

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
}
