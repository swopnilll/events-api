<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert roles into the 'roles' table
        Role::create([
            'role_name' => 'Admin',
            'description' => 'Has event creation access',
        ]);

        Role::create([
            'role_name' => 'User',
            'description' => 'User level access',
        ]);
    }
}
