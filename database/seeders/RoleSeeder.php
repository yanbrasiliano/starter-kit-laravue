<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(
            ['slug' => 'administrador'],
            [
                'name' => 'Administrador',
                'guard_name' => 'web',
                'slug' => 'administrador',
                'description' => 'Administra o sistema e tem acesso total a todas as funcionalidades.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $permissions = Permission::all()->pluck('id')->toArray();

        $admin->syncPermissions($permissions);

        $servidor_uefs = Role::updateOrCreate(
            ['slug' => 'servidor_uefs'],
            [
                'name' => 'Servidor UEFS',
                'guard_name' => 'web',
                'slug' => 'servidor_uefs',
                'description' => 'Servidor da Universidade Estadual de Feira de Santana com permissões específicas para gerenciamento de recursos da instituição.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $servidor_uefs->syncPermissions([]);

        $aluno = Role::updateOrCreate(
            ['slug' => 'aluno'],
            [
                'name' => 'Aluno',
                'guard_name' => 'web',
                'slug' => 'aluno',
                'description' => 'Aluno matriculado na Universidade Estadual de Feira de Santana com permissões limitadas de acesso ao sistema.',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        );

        $aluno->syncPermissions([]);

        $parecerista = Role::updateOrCreate(
            ['slug' => 'parecerista'],
            [
                'name' => 'Parecerista',
                'guard_name' => 'web',
                'slug' => 'parecerista',
                'description' => 'Aluno matriculado na Universidade Estadual de Feira de Santana com permissões limitadas de acesso ao sistema.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $parecerista->syncPermissions([]);
    }
}
