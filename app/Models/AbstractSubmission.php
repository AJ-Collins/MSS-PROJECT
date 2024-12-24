<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'serialNumber',
        'title', 
        'sub_theme', 
        'abstract', 
        'keywords',
        // Add any other fields you want to allow mass-assignment for
    ];
}
