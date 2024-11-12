<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class RoleSeeder extends Seeder
{
  public function run(): void
  {
    $admin = Role::updateOrCreate(
      ['slug' => 'administrator'],
      [
        'name' => 'Administrador',
        'guard_name' => 'web',
        'slug' => 'administrator',
        'description' => 'Administrador da plataforma com acesso completo.',
        'created_at' => now(),
        'updated_at' => now(),
      ]
    );

    $permissions = Permission::all()->pluck('id')->toArray();
    $admin->syncPermissions($permissions);

    Role::updateOrCreate(
      ['slug' => 'visitor'],
      [
        'name' => 'Visitante',
        'guard_name' => 'web',
        'slug' => 'visitor',
        'description' => 'Visitante na plataforma com acesso limitado.',
        'created_at' => now(),
        'updated_at' => now(),
      ]
    );
  }
}
