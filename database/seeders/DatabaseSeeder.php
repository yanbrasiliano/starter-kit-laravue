<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            ThematicAreaSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            DeleteReasonSeeder::class,
        ]);
    }
}
