<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'abstract_submission_id',
        'reviewer_reg_no',
        'user_reg_no',
        'thematic_score',
        'thematic_comments',
        'title_score',
        'title_comments',
        'objectives_score',
        'objectives_comments',
        'methodology_score',
        'methodology_comments',
        'output_score',
        'output_comments',
        'general_comments',
        'correction_type',
        'correction_comments',
        'total_score',
    ];

    public function proposalSubmission()
    {
        return $this->belongsTo(ResearchSubmission::class, 'abstract_submission_id', 'serial_number');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_reg_no', 'reg_no');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_reg_no', 'reg_no');
    }
}
