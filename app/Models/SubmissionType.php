<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionType extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'status',
        'deadline',
        'format',
        'guidelines'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];
}