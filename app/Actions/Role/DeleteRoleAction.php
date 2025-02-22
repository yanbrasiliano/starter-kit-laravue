<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Exceptions\RoleIsAssignedToUserException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

final readonly class DeleteRoleAction
{
    public function execute(Role $role): bool
    {
        return DB::transaction(function () use ($role): bool {

            if ($role->users()->exists()) {
                throw new RoleIsAssignedToUserException();
            }

            $role->users()->detach();
            $role->permissions()->detach();

            return (bool) $role->delete();
        });
    }
}
