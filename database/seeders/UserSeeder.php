<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the Admin role dynamically from the roles table using Eloquent
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            // Create or update the default Super Admin user using Eloquent ORM
            User::updateOrCreate(
                ['username' => 'admin'], // Condition to check if admin already exists
                [
                    'name' => 'Super Admin',
                    'phone' => '01700000000',
                    'email' => 'admin@school.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'), // The hashed password is 'password'
                    'role_id' => $adminRole->id,
                    'status' => true, // Activating the user account
                ]
            );
        }
    }
}
