<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_reg_no', 
        'message', 
        'link', 
        'read', 
        'type'
    ];

    // Relationship with the User model (assuming you are storing the user's registration number)
    public function notifiable()
    {
        return $this->morphTo();
    }
}

