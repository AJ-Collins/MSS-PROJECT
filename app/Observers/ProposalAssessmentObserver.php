<?php

namespace App\Observers;

use App\Models\ProposalAssessment;
use App\Models\ResearchSubmission;

class ProposalAssessmentObserver
{
    public function created(ProposalAssessment $assessment)
    {
        \Log::info("ProposalAssessmentObserver: created event triggered for serial number: {$assessment->abstract_submission_id}");
        dd("Observer triggered for serial number: {$assessment->abstract_submission_id}");
        $this->updateSubmissionScore($assessment->abstract_submission_id);
    }

    public function updated(ProposalAssessment $assessment)
    {
        $this->updateSubmissionScore($assessment->abstract_submission_id);
    }

    public function deleted(ProposalAssessment $assessment)
    {
        $this->updateSubmissionScore($assessment->abstract_submission_id);
    }

    protected function updateSubmissionScore($serialNumber)
    {
        $submission = ResearchSubmission::where('serial_number', $serialNumber)->first();

        if ($submission) {
            $averageScore = ProposalAssessment::where('abstract_submission_id', $serialNumber)
                ->avg('total_score');
            
            $submission->update([
                'score' => $averageScore ? round($averageScore, 2) : null
            ]);
        }
    }
}
