<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dynamically fetch the admin role ID
        $adminRole = Role::where('role_name', 'Admin')->first();

        if (!$adminRole) {
            // If the Admin role doesn't exist, throw an exception
            throw new \Exception('Admin role not found. Please run RoleSeeder first.');
        }

        // Seed the admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Always hash passwords
            'role_id' => $adminRole->id, // Dynamically assign the admin role ID
        ]);
    }
}