<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\AssignRoleToNewUser;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\ProposalAssessment;
use App\Observers\ProposalAssessmentObserver;

class EventServiceProvider extends ServiceProvider
{
     /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            AssignRoleToNewUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
        ProposalAssessment::observe(ProposalAssessmentObserver::class);
        

        // Additional event boot logic if needed
    }
}
