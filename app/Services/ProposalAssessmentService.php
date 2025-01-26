<?php

namespace App\Services;

use App\Models\ProposalAssessment;
use App\Models\ResearchSubmission;

class ProposalAssessmentService
{
    public function calculateAverageScore($serial_number)
    {
        // Calculate the average score for this specific document
        $averageScore = ProposalAssessment::where('abstract_submission_id', $serial_number)
            ->avg('total_score');

        // Update the abstract submission's score
        ResearchSubmission::where('serial_number', $serial_number)
            ->update([
                'score' => $averageScore ?? 0 // Default to 0 if no scores exist
            ]);

        return $averageScore;
    }
}
