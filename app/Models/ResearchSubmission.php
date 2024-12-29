<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchSubmission extends Model
{
    use HasFactory;
    protected $primaryKey = 'serial_number';
    public $incrementing = false; // Since serial_number is not auto-incrementing
    protected $keyType = 'string';
    protected $table = 'research_submissions';
    protected $fillable = [
        'serial_number',
        'article_title', 
        'sub_theme',
        'abstract',
        'keywords',
        'pdf_document_path',
        'reviewer_reg_no',
     ];

     public function authors()
    {
        return $this->hasMany(Author::class, 'research_submission_id','serial_number');
    }
}
