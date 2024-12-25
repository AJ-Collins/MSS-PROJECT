<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create a user and assign the 'admin' role
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'kiprocolloaj@gmail.com',
        ]);

        // Assign the 'admin' role to the newly created user
        $user->assignRole($adminRole);

        // Optionally, you can create more users and assign them roles as well
        $anotherUser = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'regularuser@example.com',
        ]);

        // Assign 'user' role to the second user
        $anotherUser->assignRole($userRole);
    }
}
