<?php

namespace App\Observers;

use App\Models\ResearchAssessment;
use App\Services\AssessmentService;

class ResearchAssessmentObserver
{
    protected $assessmentService;

    public function __construct()
    {
        $this->assessmentService = new AssessmentService();
    }

    /**
     * Handle the ResearchAssessment "created" event.
     */
    public function created(ResearchAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }

    /**
     * Handle the ResearchAssessment "updated" event.
     */
    public function updated(ResearchAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }

    /**
     * Handle the ResearchAssessment "deleted" event.
     */
    public function deleted(ResearchAssessment $assessment)
    {
        $this->assessmentService->calculateAverageScore($assessment->abstract_submission_id);
    }
}
