<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;


function asAdmin(): User
{
    $user = User::factory()->create();
    $user->createToken('test-token')->plainTextToken;
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $user->assignRole([$roleAdminId]);
    return $user;
}

function asReviewer(): User
{
    $user = User::factory()->create();
    $user->createToken('test-token')->plainTextToken;
    $roleAdminId = Role::where('slug', RolesEnum::REVIEWER->value)->first()->id;
    $user->assignRole([$roleAdminId]);
    return $user;
}

function createUsers(int $quantity = 20): User | Collection
{
    return User::factory($quantity)->create();
}

function createUser(array $attrs = [])
{
    return count($attrs) >= 1 ? 
        User::factory()->create($attrs) : 
        User::factory()->create();
}

function createRoles()
{
    Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    Artisan::call('db:seed', ['--class' => 'PermissionSeeder']);
}

function createTemporaryUrlForUser(User $user, Carbon $carbonTime): string
{
    return URL::temporarySignedRoute(
        'users.verify',
        $carbonTime,
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]
    );
}