<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};

class UserSeeder extends Seeder {
    private const ADMIN_EMAIL = 'admin@admin.com';
    private const ADMIN_ROLE = 'Administrador';

    public function run() {
        DB::transaction(function () {
            $this->createAdminUser();
            $this->assignAdminRole();
        });
    }
    private function createAdminUser() {
        DB::table('users')->updateOrInsert(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'Administrador',
                'email' => self::ADMIN_EMAIL,
                'cpf' => '32813163015',
                'password' => Hash::make('@dm!n1234%'),
                'active' => StatusEnum::ENABLED,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
    private function assignAdminRole() {
        $user = User::where('email', self::ADMIN_EMAIL)->first();
        $roleId = DB::table('roles')
            ->where('name', self::ADMIN_ROLE)
            ->value('id');

        if ($user && $roleId) {
            DB::table('role_user')->updateOrInsert(
                ['user_id' => $user->id, 'role_id' => $roleId],
                [
                    'role_id' => $roleId,
                    'model_type' => 'App\Models\User',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
