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
                'description' => 'Listar usuários',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.create',
                'guard_name' => 'web',
                'description' => 'Criar usuários',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.edit',
                'guard_name' => 'web',
                'description' => 'Editar usuários',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.delete',
                'guard_name' => 'web',
                'description' => 'Deletar usuários',
                'resource' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.list',
                'guard_name' => 'web',
                'description' => 'Listar perfis',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.view',
                'guard_name' => 'web',
                'description' => 'Visualizar perfis',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.create',
                'guard_name' => 'web',
                'description' => 'Criar perfis',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'description' => 'Editar perfis',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.delete',
                'guard_name' => 'web',
                'description' => 'Deletar perfis',
                'resource' => 'roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], 'name');
    }
}
