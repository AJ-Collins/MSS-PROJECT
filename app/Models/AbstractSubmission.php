<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractSubmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'serial_number';
    public $incrementing = false; // Since serial_number is not auto-incrementing
    protected $keyType = 'string';
    protected $fillable = [
        'serial_number',
        'title', 
        'sub_theme', 
        'abstract', 
        'keywords',
        'final_status',
        'reviewer_status',
        'pdf_document_path',
        'reviewer_reg_no',
        // Add any other fields you want to allow mass-assignment for
    ];

    public function authors()
    {
        return $this->hasMany(Author::class, 'abstract_submission_id', 'serial_number');
    }
    public function assessments()
    {
        return $this->hasMany(ResearchAssessment::class, 'abstract_submission_id', 'serial_number');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_reg_no', 'reg_no');
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_reg_no', 'reg_no');
    }
    
}
