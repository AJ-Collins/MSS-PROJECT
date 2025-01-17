<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a default admin user
        User::updateOrCreate(
            ['email' => 'kiprocolloaj@gmail.com'], // Unique email to prevent duplicates
            [
                'reg_no' => 'BSCS219J2023', // Unique registration number
                'salutation' => 'Dr',
                'first_name' => 'Collins',
                'last_name' => 'Kiprotich',
                'email' => 'kiprocolloaj@gmail.com',
                'password' => Hash::make('Ajcollins987'), // Securely hashed default password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
