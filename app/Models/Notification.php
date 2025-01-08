<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_reg_no', 'reg_no');
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }
}

