<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotification;


class User extends Authenticatable implements MustVerifyEmail
{


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;
    

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'reg_no';
    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reg_no',
        'salutation',
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_photo_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_user', 'reg_no', 'role_id')
                    ->withTimestamps();
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }

    /**
     * Get the unread notifications for the user.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
    public function assignedAbstracts()
    {
        return $this->belongsToMany(
            AbstractSubmission::class,
            'abstract_submission_reviewers', // Pivot table name
            'reviewer_id',                  // Foreign key on the pivot table
            'abstract_serial_number',       // Foreign key on the pivot table
            'reg_no',                       // Local key on the users table
            'serial_number'                 // Local key on the abstract_submissions table
        )
        ->withPivot('status', 'decline_reason', 'response_date')
        ->withTimestamps();
    }
    public function assignedProposals()
    {
        return $this->belongsToMany(
            ResearchSubmission::class,
            'proposal_abstract_submission_reviewers', // Pivot table name
            'reviewer_id',                  // Foreign key on the pivot table
            'abstract_serial_number',       // Foreign key on the pivot table
            'reg_no',                       // Local key on the users table
            'serial_number'                 // Local key on the abstract_submissions table
        )
        ->withPivot('status', 'decline_reason', 'response_date')
        ->withTimestamps();
    }
    public function acceptAbstractAssignment(string $serial_number): bool
    {
        $assignment = $this->assignedAbstracts()
            ->wherePivot('abstract_serial_number', $serial_number)
            ->first();

        if (!$assignment) {
            return false;
        }

        return $this->assignedAbstracts()->updateExistingPivot(
            $serial_number,
            [
                'status' => 'accepted',
                'response_date' => now(),
            ]
        );
    }
    public function acceptProposalAssignment(string $serial_number): bool
    {
        $assignment = $this->assignedProposals()
            ->wherePivot('abstract_serial_number', $serial_number)
            ->first();

        if (!$assignment) {
            return false;
        }

        return $this->assignedProposals()->updateExistingPivot(
            $serial_number,
            [
                'status' => 'accepted',
                'response_date' => now(),
            ]
        );
    }

    public function declineAbstractAssignment(string $serial_number): bool
    {
        $assignment = $this->assignedAbstracts()
            ->wherePivot('abstract_serial_number', $serial_number)
            ->first();

        if (!$assignment) {
            return false;
        }

        return $this->assignedAbstracts()->updateExistingPivot(
            $serial_number,
            [
                'status' => 'declined',
                'response_date' => now(),
            ]
        );
    }
    public function declineProposalAssignment(string $serial_number): bool
    {
        $assignment = $this->assignedProposals()
            ->wherePivot('abstract_serial_number', $serial_number)
            ->first();

        if (!$assignment) {
            return false;
        }

        return $this->assignedProposals()->updateExistingPivot(
            $serial_number,
            [
                'status' => 'declined',
                'response_date' => now(),
            ]
        );
    }
    
    public function abstractSubmissions()
    {
        return $this->belongsToMany(
            AbstractSubmission::class, // Model to associate
            'abstract_submission_reviewers', // Pivot table name
            'reviewer_id', // Foreign key on the pivot table
            'abstract_serial_number', // Foreign key on the pivot table
            'reg_no', // Local key on the users table
            'serial_number' // Local key on the abstract submissions table
        )->withPivot('status')
            ->withTimestamps();
    }
    public function researchSubmissions()
    {
        return $this->belongsToMany(
            ResearchSubmission::class,  // Model to associate
            'proposal_abstract_submission_reviewers',  // Pivot table name
            'reviewer_id',  // Foreign key on the pivot table
            'abstract_serial_number',  // Foreign key on the pivot table
            'reg_no',  // Local key on the users table
            'serial_number'  // Local key on the research submissions table
        )->withPivot('status')
            ->withTimestamps();
    }

    public function switchRole(string $roleName)
    {
        // Check if the user already has this role
        if (!$this->hasRole($roleName)) {
            // If not, attach the role
            $role = Role::where('name', $roleName)->firstOrFail();
            $this->roles()->attach($role);
        }
        
        // Optionally, set a session variable to track the current active role
        session(['current_role' => $roleName]);
        
        return true;
    }

    public function getCurrentRole()
    {
        // Return the current active role from session, 
        // or default to the first role if not set
        return session('current_role') ?? $this->roles->first()->name;
    }
    public function assessments()
{
    return $this->hasMany(ResearchAssessment::class); // or use belongsToMany depending on your data structure
}

}
