<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * The admin user's default email.
   */
  private const ADMIN_EMAIL = 'admin@admin.com';

  /**
   * The admin role name.
   */
  private const ADMIN_ROLE = 'Administrator';

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::transaction(function () {
      $this->createAdminUser();
      $this->assignAdminRole();
    });
  }

  /**
   * Create an admin user if it does not exist.
   *
   * @return void
   */
  private function createAdminUser()
  {
    DB::table('users')->updateOrInsert(
      ['email' => self::ADMIN_EMAIL],
      [
        'name' => 'Administrador',
        'email' => self::ADMIN_EMAIL,
        'cpf' => '12345678909',
        'password' => Hash::make('admin1234'),
        'active' => StatusEnum::ENABLED,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ]
    );
  }

  /**
   * Assign the admin role to the admin user.
   *
   * @return void
   */
  private function assignAdminRole()
  {
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
