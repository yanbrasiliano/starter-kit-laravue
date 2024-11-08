<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(
            ['slug' => 'administrator'],
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
                'slug' => 'administrator',
                'description' => 'Manages the system and has full access to all functionalities.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $permissions = Permission::all()->pluck('id')->toArray();
        $admin->syncPermissions($permissions);

       Role::updateOrCreate(
            ['slug' => 'visitor'],
            [
                'name' => 'Guest',
                'guard_name' => 'web',
                'slug' => 'visitor',
                'description' => 'Visitor with limited access to the system, can only view and list users.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

      Role::updateOrCreate(
            ['slug' => 'reviewer'],
            [
                'name' => 'Reviewer',
                'guard_name' => 'web',
                'slug' => 'reviewer',
                'description' => 'Reviewer with limited access to the system, can only view and list users.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
