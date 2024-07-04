<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->upsert([
            [
                'name' => 'users.list',
                'guard_name' => 'web',
                'description' => 'List users',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.create',
                'guard_name' => 'web',
                'description' => 'Create users',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.edit',
                'guard_name' => 'web',
                'description' => 'Edit users',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.delete',
                'guard_name' => 'web',
                'description' => 'Delete users',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.list',
                'guard_name' => 'web',
                'description' => 'List roles',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.view',
                'guard_name' => 'web',
                'description' => 'View roles',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.create',
                'guard_name' => 'web',
                'description' => 'Create roles',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'description' => 'Edit roles',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.delete',
                'guard_name' => 'web',
                'description' => 'Delete roles',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], 'name');
    }
}
