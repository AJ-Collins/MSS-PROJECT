<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchSubmission extends Model
{
    use HasFactory;
    protected $table = 'research_submissions';
    protected $fillable = [
        'serial_number',
        'article_title', 
        'sub_theme',
        'abstract',
        'keywords',
        'pdf_document_path'
     ];
}
