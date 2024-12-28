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
    ];

    public function abstractSubmission()
    {
        return $this->belongsTo(AbstractSubmission::class, 'abstract_submission_id');
    }
    public function proposalSubmission()
    {
        return $this->belongsTo(ResearchSubmission::class, 'abstract_submission_id');
    }
}
