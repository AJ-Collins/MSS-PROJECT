<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_reg_no',
        'serial_number',
        'title',
        'sub_theme',
        'abstract',
        'keywords',
        'authors',
    ];

    protected $casts = [
        'keywords' => 'array',
        'authors' => 'array',
    ];
}
