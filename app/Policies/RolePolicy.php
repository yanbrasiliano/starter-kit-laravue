<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function update(User $user, Role $role): bool
    {
        return $user->can('roles.edit') && $role->id !== 1;
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('roles.delete') && !$role->users()->exists();

    }
}
