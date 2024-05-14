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
                'resource' => 'usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.create',
                'guard_name' => 'web',
                'description' => 'Criar usuários',
                'resource' => 'usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.edit',
                'guard_name' => 'web',
                'description' => 'Editar usuários',
                'resource' => 'usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users.delete',
                'guard_name' => 'web',
                'description' => 'Deletar usuários',
                'resource' => 'usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.list',
                'guard_name' => 'web',
                'description' => 'Listar perfis',
                'resource' => 'perfis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.view',
                'guard_name' => 'web',
                'description' => 'Consultar perfis',
                'resource' => 'perfis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.create',
                'guard_name' => 'web',
                'description' => 'Criar perfis',
                'resource' => 'perfis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'description' => 'Editar perfis',
                'resource' => 'perfis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'roles.delete',
                'guard_name' => 'web',
                'description' => 'Deletar perfis',
                'resource' => 'perfis',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'units.list',
                'guard_name' => 'web',
                'description' => 'Listar unidades',
                'resource' => 'unidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'units.create',
                'guard_name' => 'web',
                'description' => 'Criar unidades',
                'resource' => 'unidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'units.edit',
                'guard_name' => 'web',
                'description' => 'Editar unidades',
                'resource' => 'unidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'units.delete',
                'guard_name' => 'web',
                'description' => 'Deletar unidades',
                'resource' => 'unidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'thematic_areas.list',
                'guard_name' => 'web',
                'description' => 'Listar Áreas Temáticas',
                'resource' => 'areas_tematicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'thematic_areas.create',
                'guard_name' => 'web',
                'description' => 'Criar Áreas Temáticas',
                'resource' => 'areas_tematicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'thematic_areas.edit',
                'guard_name' => 'web',
                'description' => 'Editar Áreas Temáticas',
                'resource' => 'areas_tematicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'thematic_areas.delete',
                'guard_name' => 'web',
                'description' => 'Deletar Áreas Temáticas',
                'resource' => 'areas_tematicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], 'name');
    }
}
