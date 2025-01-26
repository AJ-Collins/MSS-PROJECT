<?php

namespace App\Observers;

use App\Models\ProposalAssessment;
use App\Services\ProposalAssessmentService;

class ProposalAssessmentObserver
{
    protected $assessmentService;

    public function __construct()
    {
        $this->assessmentService = new ProposalAssessmentService();
    }

    /**
     * Handle the ResearchAssessment "created" event.
     */
    public function created(ProposalAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }

    /**
     * Handle the ResearchAssessment "updated" event.
     */
    public function updated(ProposalAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }

    /**
     * Handle the ResearchAssessment "deleted" event.
     */
    public function deleted(ProposalAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }
}
