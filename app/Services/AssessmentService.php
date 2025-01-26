<?php

namespace App\Services;

use App\Models\ResearchAssessment;
use App\Models\AbstractSubmission;

class AssessmentService
{
    public function calculateAverageScore($serial_number)
    {
        // Calculate the average score for this specific document
        $averageScore = ResearchAssessment::where('abstract_submission_id', $serial_number)
            ->avg('total_score');

        // Update the abstract submission's score
        AbstractSubmission::where('serial_number', $serial_number)
            ->update([
                'score' => $averageScore ?? 0 // Default to 0 if no scores exist
            ]);

        return $averageScore;
    }
}
