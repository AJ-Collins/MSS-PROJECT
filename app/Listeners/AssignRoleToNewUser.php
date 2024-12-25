<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Role;

class AssignRoleToNewUser
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        // Assign the 'user' role to the newly registered user
        $role = Role::where('name', 'user')->first();

        if ($role) {
            $user->roles()->attach($role);
        }
    }
}
