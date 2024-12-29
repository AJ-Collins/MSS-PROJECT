<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'email',
        'university',
        'department',
        'is_correspondent',
        'submission_type',
        'abstract_submission_id',
        'research_submission_id',
    ];

    public function abstractSubmission()
    {
        return $this->belongsTo(AbstractSubmission::class, 'abstract_submission_id', 'serial_number');
    }
    public function proposalSubmission()
    {
        return $this->belongsTo(ResearchSubmission::class, 'research_submission_id', 'serial_number');
    }
}
