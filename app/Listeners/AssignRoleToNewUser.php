<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;


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
        $role = Role::where('name', 'user')->first();
    
        if ($role && $event->user) {
            DB::table('role_user')->insert([
                'reg_no' => $event->user->reg_no,
                'role_id' => $role->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
