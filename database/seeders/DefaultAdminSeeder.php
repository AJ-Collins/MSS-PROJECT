<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the default admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'kiprocolloaj@gmail.com'], // Unique email to prevent duplicates
            [
                'reg_no' => 'BSCS219J2023', // Unique registration number
                'salutation' => 'Dr.',
                'first_name' => 'Collins',
                'last_name' => 'Kiprotich',
                'email' => 'kiprocolloaj@gmail.com',
                'password' => Hash::make('Collinsaj123!'), // Securely hashed default password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign the 'admin' role to the user
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        } else {
            // Log an error or create the role dynamically if it doesn't exist
            \Log::error('Admin role not found. Please run RolesTableSeeder first.');
        }
    }
}
